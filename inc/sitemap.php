<?php
/**
 * Sitemap Enhancements — Customize WordPress core sitemaps.
 *
 * WordPress 5.5+ has built-in XML sitemaps at /wp-sitemap.xml.
 * This module customises which post types and taxonomies are included,
 * adds custom priorities, and filters out thin content.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Filter which post types appear in the sitemap.
 * Remove attachment, and include case_study.
 */
function hoplytics_sitemap_post_types(array $post_types): array
{
    // Remove attachments (media pages are thin content)
    unset($post_types['attachment']);

    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'hoplytics_sitemap_post_types');

/**
 * Filter which taxonomies appear in the sitemap.
 * Remove post_format and post_tag (usually thin content).
 */
function hoplytics_sitemap_taxonomies(array $taxonomies): array
{
    unset($taxonomies['post_format']);
    unset($taxonomies['post_tag']);

    return $taxonomies;
}
add_filter('wp_sitemaps_taxonomies', 'hoplytics_sitemap_taxonomies');

/**
 * Exclude specific posts/pages from the sitemap.
 * For example, utility pages that have noindex set.
 */
function hoplytics_sitemap_query_args(array $args, string $post_type): array
{
    // Exclude posts with _hoplytics_noindex meta
    $args['meta_query'] = $args['meta_query'] ?? [];
    $args['meta_query'][] = [
        'relation' => 'OR',
        [
            'key' => '_hoplytics_noindex',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key' => '_hoplytics_noindex',
            'value' => '1',
            'compare' => '!=',
        ],
    ];

    return $args;
}
add_filter('wp_sitemaps_posts_query_args', 'hoplytics_sitemap_query_args', 10, 2);

/**
 * Add lastmod to sitemap entries for better crawl prioritisation.
 */
function hoplytics_sitemap_entry(array $entry, string $post_type, \WP_Post $post): array
{
    $entry['lastmod'] = get_the_modified_date('c', $post);

    return $entry;
}
add_filter('wp_sitemaps_posts_entry', 'hoplytics_sitemap_entry', 10, 3);

/**
 * Remove the sitemap stylesheet so search engines parse raw XML.
 * (Optional — helps reduce page weight for bot requests.)
 */
function hoplytics_remove_sitemap_stylesheet(string $stylesheet): string
{
    return '';
}
add_filter('wp_sitemaps_stylesheet_url', 'hoplytics_remove_sitemap_stylesheet');

/**
 * Increase max URLs per sitemap page for smaller sites.
 * Default is 2000, but for a site with <50 pages, 1 page is cleaner.
 */
function hoplytics_sitemap_max_urls(int $max_urls, string $object_type): int
{
    return 5000; // Keep everything in one page per type
}
add_filter('wp_sitemaps_max_urls', 'hoplytics_sitemap_max_urls', 10, 2);
