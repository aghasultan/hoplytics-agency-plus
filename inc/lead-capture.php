<?php
/**
 * Lead Capture — Email gate for tool results + smart contact form REST API.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register 'lead' custom post type for capturing tool users.
 */
function hoplytics_register_lead_cpt(): void
{
    register_post_type('hoplytics_lead', [
        'labels' => [
            'name' => __('Leads', 'hoplytics'),
            'singular_name' => __('Lead', 'hoplytics'),
            'menu_name' => __('Leads', 'hoplytics'),
            'all_items' => __('All Leads', 'hoplytics'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title'],
        'has_archive' => false,
        'rewrite' => false,
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
    ]);

    // Custom admin columns
    add_filter('manage_hoplytics_lead_posts_columns', function (array $columns): array {
        return [
            'cb' => $columns['cb'],
            'title' => __('Name', 'hoplytics'),
            'lead_email' => __('Email', 'hoplytics'),
            'lead_source' => __('Source', 'hoplytics'),
            'lead_score' => __('Score', 'hoplytics'),
            'date' => __('Date', 'hoplytics'),
        ];
    });

    add_action('manage_hoplytics_lead_posts_custom_column', function (string $column, int $post_id): void {
        match ($column) {
            'lead_email' => print ('<a href="mailto:' . esc_attr(get_post_meta($post_id, '_lead_email', true)) . '">' . esc_html(get_post_meta($post_id, '_lead_email', true)) . '</a>'),
            'lead_source' => print (esc_html(get_post_meta($post_id, '_lead_source', true))),
            'lead_score' => print ('<strong>' . esc_html(get_post_meta($post_id, '_lead_score', true)) . '</strong>'),
            default => null,
        };
    }, 10, 2);
}
add_action('init', 'hoplytics_register_lead_cpt');

/**
 * Register lead capture REST routes.
 */
function hoplytics_register_lead_routes(): void
{
    // Email gate: capture email to unlock full tool results
    register_rest_route('hoplytics/v1', '/lead/capture', [
        'methods' => 'POST',
        'callback' => 'hoplytics_capture_lead',
        'permission_callback' => '__return_true',
        'args' => [
            'email' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_email',
                'validate_callback' => fn($val) => is_email($val) !== false,
            ],
            'name' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '',
            ],
            'source' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'tool_gate',
            ],
            'tool' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '',
            ],
            'meta' => [
                'required' => false,
                'type' => 'object',
                'default' => [],
            ],
        ],
    ]);

    // Smart contact form
    register_rest_route('hoplytics/v1', '/lead/contact', [
        'methods' => 'POST',
        'callback' => 'hoplytics_contact_form',
        'permission_callback' => '__return_true',
        'args' => [
            'name' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'email' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_email',
                'validate_callback' => fn($val) => is_email($val) !== false,
            ],
            'company' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '',
            ],
            'service' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'budget' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '',
            ],
            'message' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            'website' => [
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'default' => '',
            ],
        ],
    ]);
}
add_action('rest_api_init', 'hoplytics_register_lead_routes');

/**
 * Capture a lead from email gate.
 */
function hoplytics_capture_lead(WP_REST_Request $request): WP_REST_Response
{
    $email = $request->get_param('email');
    $name = $request->get_param('name');
    $source = $request->get_param('source');
    $tool = $request->get_param('tool');
    $meta = $request->get_param('meta');

    // Rate limiting: max 10 captures per IP per hour
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $transient_key = 'hoplytics_lead_' . md5($ip);
    $count = (int) get_transient($transient_key);

    if ($count >= 10) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Too many requests. Please try again later.',
        ], 429);
    }

    set_transient($transient_key, $count + 1, HOUR_IN_SECONDS);

    // Check for existing lead with same email
    $existing = get_posts([
        'post_type' => 'hoplytics_lead',
        'meta_key' => '_lead_email',
        'meta_value' => $email,
        'post_status' => 'any',
        'numberposts' => 1,
    ]);

    // Lead scoring based on actions
    $score = 10; // base score for email capture
    if ($tool)
        $score += 5; // used a tool
    if ($name)
        $score += 5; // provided name

    if ($existing) {
        // Update existing lead
        $lead_id = $existing[0]->ID;
        $existing_score = (int) get_post_meta($lead_id, '_lead_score', true);
        update_post_meta($lead_id, '_lead_score', $existing_score + $score);
        update_post_meta($lead_id, '_lead_last_activity', current_time('mysql'));

        if ($tool) {
            $tools_used = get_post_meta($lead_id, '_lead_tools_used', true);
            $tools_used = $tools_used ? json_decode($tools_used, true) : [];
            $tools_used[] = [
                'tool' => $tool,
                'date' => current_time('mysql'),
            ];
            update_post_meta($lead_id, '_lead_tools_used', wp_json_encode($tools_used));
        }
    } else {
        // Create new lead
        $lead_id = wp_insert_post([
            'post_type' => 'hoplytics_lead',
            'post_title' => $name ?: $email,
            'post_status' => 'private',
            'meta_input' => [
                '_lead_email' => $email,
                '_lead_name' => $name,
                '_lead_source' => $source,
                '_lead_score' => $score,
                '_lead_ip' => $ip,
                '_lead_created' => current_time('mysql'),
                '_lead_last_activity' => current_time('mysql'),
                '_lead_tools_used' => $tool ? wp_json_encode([['tool' => $tool, 'date' => current_time('mysql')]]) : '[]',
                '_lead_meta' => wp_json_encode($meta),
            ],
        ]);
    }

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = sprintf('🎯 New Lead: %s — %s', $name ?: 'Anonymous', $source);
    $body = sprintf(
        "New lead captured!\n\nName: %s\nEmail: %s\nSource: %s\nTool Used: %s\nScore: %d\nDate: %s",
        $name ?: 'Not provided',
        $email,
        $source,
        $tool ?: 'None',
        $score,
        current_time('M j, Y g:i A')
    );
    wp_mail($admin_email, $subject, $body);

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Thank you! Check your email for your full report.',
        'lead_id' => $lead_id,
    ], 200);
}

/**
 * Handle smart contact form submission.
 */
function hoplytics_contact_form(WP_REST_Request $request): WP_REST_Response
{
    $name = $request->get_param('name');
    $email = $request->get_param('email');
    $company = $request->get_param('company');
    $service = $request->get_param('service');
    $budget = $request->get_param('budget');
    $message = $request->get_param('message');
    $website = $request->get_param('website');

    // Rate limiting
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $transient_key = 'hoplytics_contact_' . md5($ip);
    $count = (int) get_transient($transient_key);

    if ($count >= 5) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Too many submissions. Please try again later.',
        ], 429);
    }

    set_transient($transient_key, $count + 1, HOUR_IN_SECONDS);

    // Lead scoring: contact form = higher intent
    $score = 30; // base score for contact form (higher than email gate)
    if ($company)
        $score += 10;
    if ($website)
        $score += 10;
    if ($budget) {
        $score += match ($budget) {
            '5k-10k' => 15,
            '10k-25k' => 25,
            '25k+' => 40,
            default => 5,
        };
    }

    // Save as lead
    $lead_id = wp_insert_post([
        'post_type' => 'hoplytics_lead',
        'post_title' => $name . ' — ' . $service,
        'post_status' => 'private',
        'meta_input' => [
            '_lead_email' => $email,
            '_lead_name' => $name,
            '_lead_company' => $company,
            '_lead_source' => 'contact_form',
            '_lead_service' => $service,
            '_lead_budget' => $budget,
            '_lead_website' => $website,
            '_lead_message' => $message,
            '_lead_score' => $score,
            '_lead_ip' => $ip,
            '_lead_created' => current_time('mysql'),
            '_lead_last_activity' => current_time('mysql'),
        ],
    ]);

    // Send notification to admin with routing info
    $admin_email = get_option('admin_email');
    $subject = sprintf('🔥 New Contact: %s — %s (Score: %d)', $name, $service, $score);
    $body = sprintf(
        "New contact form submission!\n\n" .
        "Name: %s\n" .
        "Email: %s\n" .
        "Company: %s\n" .
        "Service: %s\n" .
        "Budget: %s\n" .
        "Website: %s\n" .
        "Lead Score: %d\n\n" .
        "Message:\n%s\n\n" .
        "— Hoplytics Lead System",
        $name,
        $email,
        $company ?: 'N/A',
        $service,
        $budget ?: 'Not specified',
        $website ?: 'N/A',
        $score,
        $message
    );
    wp_mail($admin_email, $subject, $body);

    // Auto-reply to the lead
    $reply_subject = 'Thanks for reaching out, ' . $name . '! — Hoplytics';
    $reply_body = sprintf(
        "Hi %s,\n\n" .
        "Thanks for getting in touch! We've received your inquiry about %s and will be in touch within 24 hours.\n\n" .
        "In the meantime, feel free to explore our free tools: %s/free-tools\n\n" .
        "Best,\nThe Hoplytics Team",
        $name,
        $service,
        home_url()
    );
    wp_mail($email, $reply_subject, $reply_body);

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Thanks, ' . $name . '! We\'ll be in touch within 24 hours.',
        'lead_id' => $lead_id,
    ], 200);
}
