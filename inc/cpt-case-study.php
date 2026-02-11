<?php
/**
 * Custom Post Type: Case Studies — portfolio items with results metrics.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

function hoplytics_register_case_study_cpt(): void
{
    register_post_type('case_study', [
        'labels' => [
            'name' => __('Case Studies', 'hoplytics'),
            'singular_name' => __('Case Study', 'hoplytics'),
            'menu_name' => __('Case Studies', 'hoplytics'),
            'add_new' => __('Add Case Study', 'hoplytics'),
            'add_new_item' => __('Add New Case Study', 'hoplytics'),
            'edit_item' => __('Edit Case Study', 'hoplytics'),
            'view_item' => __('View Case Study', 'hoplytics'),
            'search_items' => __('Search Case Studies', 'hoplytics'),
            'not_found' => __('No case studies found', 'hoplytics'),
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'case-studies', 'with_front' => false],
        'template' => [
            ['core/paragraph', ['placeholder' => 'Write the case study overview...']],
        ],
    ]);

    // Register taxonomy for service type
    register_taxonomy('service_type', 'case_study', [
        'labels' => [
            'name' => __('Service Types', 'hoplytics'),
            'singular_name' => __('Service Type', 'hoplytics'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'service-type'],
    ]);

    // Register meta fields
    $meta_fields = [
        '_cs_client' => 'string',
        '_cs_industry' => 'string',
        '_cs_duration' => 'string',
        '_cs_services' => 'string',
        '_cs_challenge' => 'string',
        '_cs_solution' => 'string',
        '_cs_metric_1_label' => 'string',
        '_cs_metric_1_value' => 'string',
        '_cs_metric_1_change' => 'string',
        '_cs_metric_2_label' => 'string',
        '_cs_metric_2_value' => 'string',
        '_cs_metric_2_change' => 'string',
        '_cs_metric_3_label' => 'string',
        '_cs_metric_3_value' => 'string',
        '_cs_metric_3_change' => 'string',
        '_cs_testimonial' => 'string',
        '_cs_testimonial_author' => 'string',
        '_cs_testimonial_role' => 'string',
        '_cs_website' => 'string',
    ];

    foreach ($meta_fields as $key => $type) {
        register_post_meta('case_study', $key, [
            'show_in_rest' => true,
            'single' => true,
            'type' => $type,
            'auth_callback' => fn() => current_user_can('edit_posts'),
        ]);
    }

    // Admin columns
    add_filter('manage_case_study_posts_columns', function (array $columns): array {
        $new = [];
        $new['cb'] = $columns['cb'];
        $new['title'] = __('Case Study', 'hoplytics');
        $new['client'] = __('Client', 'hoplytics');
        $new['industry'] = __('Industry', 'hoplytics');
        $new['services'] = __('Services', 'hoplytics');
        $new['date'] = $columns['date'];
        return $new;
    });

    add_action('manage_case_study_posts_custom_column', function (string $column, int $post_id): void {
        match ($column) {
            'client' => print (esc_html(get_post_meta($post_id, '_cs_client', true))),
            'industry' => print (esc_html(get_post_meta($post_id, '_cs_industry', true))),
            'services' => print (esc_html(get_post_meta($post_id, '_cs_services', true))),
            default => null,
        };
    }, 10, 2);

    // Add meta boxes for case study details
    add_action('add_meta_boxes', function (): void {
        add_meta_box(
            'cs_details',
            __('Case Study Details', 'hoplytics'),
            'hoplytics_cs_details_metabox',
            'case_study',
            'normal',
            'high'
        );
        add_meta_box(
            'cs_metrics',
            __('Results & Metrics', 'hoplytics'),
            'hoplytics_cs_metrics_metabox',
            'case_study',
            'normal',
            'high'
        );
        add_meta_box(
            'cs_testimonial',
            __('Client Testimonial', 'hoplytics'),
            'hoplytics_cs_testimonial_metabox',
            'case_study',
            'side',
            'default'
        );
    });
}
add_action('init', 'hoplytics_register_case_study_cpt');

/**
 * Case Study Details meta box.
 */
function hoplytics_cs_details_metabox(WP_Post $post): void
{
    wp_nonce_field('cs_details_nonce', 'cs_details_nonce');
    $fields = [
        '_cs_client' => 'Client Name',
        '_cs_industry' => 'Industry',
        '_cs_duration' => 'Engagement Duration',
        '_cs_services' => 'Services Provided',
        '_cs_website' => 'Client Website',
        '_cs_challenge' => 'The Challenge',
        '_cs_solution' => 'Our Solution',
    ];

    echo '<table class="form-table"><tbody>';
    foreach ($fields as $key => $label) {
        $val = esc_attr(get_post_meta($post->ID, $key, true));
        $type = in_array($key, ['_cs_challenge', '_cs_solution'], true) ? 'textarea' : 'input';
        echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
        if ($type === 'textarea') {
            echo '<textarea name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" rows="4" class="large-text">' . esc_textarea(get_post_meta($post->ID, $key, true)) . '</textarea>';
        } else {
            echo '<input type="text" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . $val . '" class="regular-text" />';
        }
        echo '</td></tr>';
    }
    echo '</tbody></table>';
}

/**
 * Results & Metrics meta box.
 */
function hoplytics_cs_metrics_metabox(WP_Post $post): void
{
    echo '<p><em>Add up to 3 key performance metrics to showcase results.</em></p>';
    echo '<table class="form-table"><tbody>';
    for ($i = 1; $i <= 3; $i++) {
        $label = esc_attr(get_post_meta($post->ID, "_cs_metric_{$i}_label", true));
        $value = esc_attr(get_post_meta($post->ID, "_cs_metric_{$i}_value", true));
        $change = esc_attr(get_post_meta($post->ID, "_cs_metric_{$i}_change", true));
        echo "<tr><th>Metric {$i}</th><td>";
        echo '<input type="text" name="_cs_metric_' . $i . '_label" value="' . $label . '" placeholder="e.g. Organic Traffic" style="width:180px" /> ';
        echo '<input type="text" name="_cs_metric_' . $i . '_value" value="' . $value . '" placeholder="e.g. 245%" style="width:100px" /> ';
        echo '<input type="text" name="_cs_metric_' . $i . '_change" value="' . $change . '" placeholder="e.g. ↑ 245% increase" style="width:200px" />';
        echo '</td></tr>';
    }
    echo '</tbody></table>';
}

/**
 * Client Testimonial meta box.
 */
function hoplytics_cs_testimonial_metabox(WP_Post $post): void
{
    $quote = esc_textarea(get_post_meta($post->ID, '_cs_testimonial', true));
    $author = esc_attr(get_post_meta($post->ID, '_cs_testimonial_author', true));
    $role = esc_attr(get_post_meta($post->ID, '_cs_testimonial_role', true));

    echo '<textarea name="_cs_testimonial" rows="4" style="width:100%" placeholder="Client quote...">' . $quote . '</textarea>';
    echo '<p><input type="text" name="_cs_testimonial_author" value="' . $author . '" placeholder="Name" style="width:100%" /></p>';
    echo '<p><input type="text" name="_cs_testimonial_role" value="' . $role . '" placeholder="Title & Company" style="width:100%" /></p>';
}

/**
 * Save Case Study meta.
 */
function hoplytics_save_cs_meta(int $post_id): void
{
    if (!isset($_POST['cs_details_nonce']) || !wp_verify_nonce($_POST['cs_details_nonce'], 'cs_details_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    $fields = [
        '_cs_client',
        '_cs_industry',
        '_cs_duration',
        '_cs_services',
        '_cs_website',
        '_cs_challenge',
        '_cs_solution',
        '_cs_testimonial',
        '_cs_testimonial_author',
        '_cs_testimonial_role',
        '_cs_metric_1_label',
        '_cs_metric_1_value',
        '_cs_metric_1_change',
        '_cs_metric_2_label',
        '_cs_metric_2_value',
        '_cs_metric_2_change',
        '_cs_metric_3_label',
        '_cs_metric_3_value',
        '_cs_metric_3_change',
    ];

    foreach ($fields as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }
}
add_action('save_post_case_study', 'hoplytics_save_cs_meta');

/**
 * REST API endpoint to fetch case studies for the archive page.
 */
function hoplytics_register_case_study_routes(): void
{
    register_rest_route('hoplytics/v1', '/case-studies', [
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request): WP_REST_Response {
            $per_page = $request->get_param('per_page') ?: 9;
            $page = $request->get_param('page') ?: 1;
            $service = $request->get_param('service') ?: '';

            $args = [
                'post_type' => 'case_study',
                'posts_per_page' => (int) $per_page,
                'paged' => (int) $page,
                'post_status' => 'publish',
            ];

            if ($service) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'service_type',
                        'field' => 'slug',
                        'terms' => sanitize_text_field($service),
                    ]
                ];
            }

            $query = new WP_Query($args);
            $studies = [];

            foreach ($query->posts as $post) {
                $metrics = [];
                for ($i = 1; $i <= 3; $i++) {
                    $label = get_post_meta($post->ID, "_cs_metric_{$i}_label", true);
                    if ($label) {
                        $metrics[] = [
                            'label' => $label,
                            'value' => get_post_meta($post->ID, "_cs_metric_{$i}_value", true),
                            'change' => get_post_meta($post->ID, "_cs_metric_{$i}_change", true),
                        ];
                    }
                }

                $studies[] = [
                    'id' => $post->ID,
                    'title' => get_the_title($post),
                    'excerpt' => get_the_excerpt($post),
                    'url' => get_permalink($post),
                    'thumbnail' => get_the_post_thumbnail_url($post, 'medium_large'),
                    'client' => get_post_meta($post->ID, '_cs_client', true),
                    'industry' => get_post_meta($post->ID, '_cs_industry', true),
                    'services' => get_post_meta($post->ID, '_cs_services', true),
                    'metrics' => $metrics,
                ];
            }

            return new WP_REST_Response([
                'success' => true,
                'studies' => $studies,
                'total' => $query->found_posts,
                'total_pages' => $query->max_num_pages,
            ], 200);
        },
        'permission_callback' => '__return_true',
        'args' => [
            'per_page' => ['type' => 'integer', 'default' => 9],
            'page' => ['type' => 'integer', 'default' => 1],
            'service' => ['type' => 'string', 'default' => ''],
        ],
    ]);
}
add_action('rest_api_init', 'hoplytics_register_case_study_routes');
