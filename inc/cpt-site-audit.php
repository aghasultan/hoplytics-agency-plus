<?php
/**
 * Custom Post Type: Site Audit — stores free tool results.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

function hoplytics_register_audit_cpt(): void
{
    register_post_type('site_audit', [
        'labels' => [
            'name' => __('Site Audits', 'hoplytics'),
            'singular_name' => __('Site Audit', 'hoplytics'),
            'menu_name' => __('Audits', 'hoplytics'),
            'all_items' => __('All Audits', 'hoplytics'),
            'view_item' => __('View Audit', 'hoplytics'),
            'search_items' => __('Search Audits', 'hoplytics'),
            'not_found' => __('No audits found', 'hoplytics'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-chart-area',
        'supports' => ['title'],
        'has_archive' => false,
        'rewrite' => false,
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
    ]);

    // Custom columns
    add_filter('manage_site_audit_posts_columns', function (array $columns): array {
        $new = [];
        $new['cb'] = $columns['cb'];
        $new['title'] = __('Audit', 'hoplytics');
        $new['audit_url'] = __('URL', 'hoplytics');
        $new['audit_score'] = __('Score', 'hoplytics');
        $new['audit_date'] = __('Date', 'hoplytics');
        return $new;
    });

    add_action('manage_site_audit_posts_custom_column', function (string $column, int $post_id): void {
        switch ($column) {
            case 'audit_url':
                echo '<code>' . esc_html(get_post_meta($post_id, '_audit_url', true)) . '</code>';
                break;
            case 'audit_score':
                echo '<strong>' . esc_html(get_post_meta($post_id, '_audit_score', true)) . '/100</strong>';
                break;
            case 'audit_date':
                echo esc_html(get_post_meta($post_id, '_audit_date', true));
                break;
        }
    }, 10, 2);
}
add_action('init', 'hoplytics_register_audit_cpt');
