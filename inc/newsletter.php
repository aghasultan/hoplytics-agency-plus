<?php
/**
 * Newsletter Subscription — REST API endpoint + admin management.
 *
 * Endpoint:
 *   POST /hoplytics/v1/newsletter/subscribe
 *
 * Stores subscribers as a custom post type visible in WP Admin.
 * Includes rate-limiting, duplicate detection, and admin notification.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

// ────────────────────────────────────────────────────────────────
//  CUSTOM POST TYPE
// ────────────────────────────────────────────────────────────────

function hoplytics_register_subscriber_cpt(): void
{
    register_post_type('hoplytics_subscriber', [
        'labels' => [
            'name' => __('Subscribers', 'hoplytics'),
            'singular_name' => __('Subscriber', 'hoplytics'),
            'menu_name' => __('Newsletter', 'hoplytics'),
            'all_items' => __('All Subscribers', 'hoplytics'),
            'search_items' => __('Search Subscribers', 'hoplytics'),
            'not_found' => __('No subscribers found', 'hoplytics'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => ['title'],
        'has_archive' => false,
        'rewrite' => false,
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
    ]);

    // Custom admin columns
    add_filter('manage_hoplytics_subscriber_posts_columns', function (array $columns): array {
        return [
            'cb' => $columns['cb'],
            'title' => __('Email', 'hoplytics'),
            'subscriber_source' => __('Source', 'hoplytics'),
            'subscriber_status' => __('Status', 'hoplytics'),
            'subscriber_date' => __('Subscribed', 'hoplytics'),
        ];
    });

    add_action('manage_hoplytics_subscriber_posts_custom_column', function (string $column, int $post_id): void {
        switch ($column) {
            case 'subscriber_source':
                echo esc_html(get_post_meta($post_id, '_subscriber_source', true) ?: 'blog');
                break;
            case 'subscriber_status':
                $status = get_post_meta($post_id, '_subscriber_status', true) ?: 'active';
                $badge_color = $status === 'active' ? '#10B981' : '#EF4444';
                printf(
                    '<span style="display:inline-block;padding:2px 8px;border-radius:4px;background:%s;color:#fff;font-size:0.8rem;font-weight:600">%s</span>',
                    esc_attr($badge_color),
                    esc_html(ucfirst($status))
                );
                break;
            case 'subscriber_date':
                echo esc_html(get_post_meta($post_id, '_subscriber_date', true) ?: get_the_date('Y-m-d H:i'));
                break;
        }
    }, 10, 2);
}
add_action('init', 'hoplytics_register_subscriber_cpt');

// ────────────────────────────────────────────────────────────────
//  REST API ROUTE
// ────────────────────────────────────────────────────────────────

function hoplytics_register_newsletter_routes(): void
{
    register_rest_route('hoplytics/v1', '/newsletter/subscribe', [
        'methods' => 'POST',
        'callback' => 'hoplytics_newsletter_subscribe',
        'permission_callback' => '__return_true',
        'args' => [
            'email' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_email',
                'validate_callback' => fn($val) => is_email($val) !== false,
            ],
            'source' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'blog',
            ],
        ],
    ]);
}
add_action('rest_api_init', 'hoplytics_register_newsletter_routes');

// ────────────────────────────────────────────────────────────────
//  SUBSCRIPTION HANDLER
// ────────────────────────────────────────────────────────────────

function hoplytics_newsletter_subscribe(WP_REST_Request $request): WP_REST_Response
{
    $email = $request->get_param('email');
    $source = $request->get_param('source');

    // Rate limiting (max 5 subscriptions per IP per hour)
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $transient_key = 'hoplytics_nl_' . md5($ip);
    $attempts = (int) get_transient($transient_key);

    if ($attempts >= 5) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Too many requests. Please try again later.',
        ], 429);
    }

    set_transient($transient_key, $attempts + 1, HOUR_IN_SECONDS);

    // Check for existing subscriber
    $existing = get_posts([
        'post_type' => 'hoplytics_subscriber',
        'meta_key' => '_subscriber_email',
        'meta_value' => $email,
        'fields' => 'ids',
    ]);

    if (!empty($existing)) {
        // Reactivate if they'd previously unsubscribed
        $status = get_post_meta($existing[0], '_subscriber_status', true);
        if ($status === 'unsubscribed') {
            update_post_meta($existing[0], '_subscriber_status', 'active');
            update_post_meta($existing[0], '_subscriber_resubscribed', current_time('mysql'));
        }

        return new WP_REST_Response([
            'success' => true,
            'message' => 'You\'re already subscribed! We\'ll keep the insights coming.',
        ], 200);
    }

    // Create new subscriber
    $subscriber_id = wp_insert_post([
        'post_type' => 'hoplytics_subscriber',
        'post_title' => $email,
        'post_status' => 'publish',
        'meta_input' => [
            '_subscriber_email' => $email,
            '_subscriber_source' => $source,
            '_subscriber_status' => 'active',
            '_subscriber_date' => current_time('mysql'),
            '_subscriber_ip' => $ip,
        ],
    ]);

    if (is_wp_error($subscriber_id)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Something went wrong. Please try again.',
        ], 500);
    }

    // Notify admin
    $admin_email = get_option('admin_email');
    wp_mail(
        $admin_email,
        '📧 New Newsletter Subscriber — ' . $email,
        sprintf(
            "New newsletter signup!\n\nEmail: %s\nSource: %s\nDate: %s\nIP: %s\n\nTotal subscribers: %d\n\n—\nHoplytics Newsletter System",
            $email,
            $source,
            current_time('mysql'),
            $ip,
            wp_count_posts('hoplytics_subscriber')->publish
        ),
        ['Content-Type: text/plain; charset=UTF-8']
    );

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Welcome aboard! You\'ll receive our next marketing insight.',
    ], 201);
}

// ────────────────────────────────────────────────────────────────
//  ADMIN DASHBOARD WIDGET — Subscriber Stats
// ────────────────────────────────────────────────────────────────

function hoplytics_newsletter_dashboard_widget(): void
{
    wp_add_dashboard_widget(
        'hoplytics_newsletter_stats',
        '📧 Newsletter Subscribers',
        'hoplytics_newsletter_widget_render'
    );
}
add_action('wp_dashboard_setup', 'hoplytics_newsletter_dashboard_widget');

function hoplytics_newsletter_widget_render(): void
{
    $total = wp_count_posts('hoplytics_subscriber')->publish ?? 0;

    // Last 7 days
    $recent = get_posts([
        'post_type' => 'hoplytics_subscriber',
        'posts_per_page' => -1,
        'date_query' => [['after' => '7 days ago']],
        'fields' => 'ids',
    ]);
    $this_week = count($recent);

    // Latest 5
    $latest = get_posts([
        'post_type' => 'hoplytics_subscriber',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    printf('<p style="font-size:2rem;font-weight:700;margin:0">%d</p>', $total);
    printf('<p style="color:#6B7280;margin-top:0">Total subscribers · <strong>+%d</strong> this week</p>', $this_week);

    if (!empty($latest)) {
        echo '<table style="width:100%;border-collapse:collapse;margin-top:1rem">';
        echo '<tr><th style="text-align:left;padding:4px 0;border-bottom:1px solid #E5E7EB">Email</th>';
        echo '<th style="text-align:left;padding:4px 0;border-bottom:1px solid #E5E7EB">Source</th>';
        echo '<th style="text-align:right;padding:4px 0;border-bottom:1px solid #E5E7EB">Date</th></tr>';

        foreach ($latest as $sub) {
            $email = esc_html(get_post_meta($sub->ID, '_subscriber_email', true));
            $source = esc_html(get_post_meta($sub->ID, '_subscriber_source', true) ?: 'blog');
            $date = esc_html(get_the_date('M j', $sub));

            printf(
                '<tr><td style="padding:4px 0;font-size:0.9rem">%s</td><td style="padding:4px 0;font-size:0.9rem">%s</td><td style="text-align:right;padding:4px 0;font-size:0.9rem;color:#6B7280">%s</td></tr>',
                $email,
                $source,
                $date
            );
        }
        echo '</table>';
    }

    printf(
        '<p style="margin-top:1rem"><a href="%s">View all subscribers →</a></p>',
        esc_url(admin_url('edit.php?post_type=hoplytics_subscriber'))
    );
}
