<?php
/**
 * Performance optimizations — speculative loading, fetchpriority, preconnect.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Add speculative loading rules for navigation prerendering.
 * @see https://developer.chrome.com/docs/web-platform/prerender-pages
 */
function hoplytics_speculative_loading(): void
{
    ?>
    <script type="speculationrules">
            {
                "prerender": [
                    {
                        "where": {
                            "and": [
                                { "href_matches": "/*" },
                                { "not": { "href_matches": "/wp-admin/*" } },
                                { "not": { "href_matches": "/*\\?*(^|&)s=*" } },
                                { "not": { "selector_matches": "[rel~=nofollow]" } }
                            ]
                        },
                        "eagerness": "moderate"
                    }
                ],
                "prefetch": [
                    {
                        "where": {
                            "and": [
                                { "href_matches": "/*" },
                                { "not": { "href_matches": "/wp-admin/*" } }
                            ]
                        },
                        "eagerness": "conservative"
                    }
                ]
            }
            </script>
    <?php
}
add_action('wp_head', 'hoplytics_speculative_loading', 1);

/**
 * Add preconnect hints for external domains.
 */
function hoplytics_resource_hints(): void
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">' . "\n";
}
add_action('wp_head', 'hoplytics_resource_hints', 2);

/**
 * Enable cross-document View Transitions API (Chrome 111+).
 */
function hoplytics_view_transitions_meta(): void
{
    echo '<meta name="view-transition" content="same-origin">' . "\n";
}
add_action('wp_head', 'hoplytics_view_transitions_meta', 3);

/**
 * Set fetchpriority="high" on hero images and logos.
 *
 * @param array $attr Existing image attributes.
 * @return array Modified attributes.
 */
function hoplytics_set_fetchpriority(array $attr): array
{
    // Only apply to the first image in the content (LCP candidate)
    static $applied = false;

    if (!$applied && is_front_page()) {
        $attr['fetchpriority'] = 'high';
        $attr['loading'] = 'eager';  // Override lazy for LCP
        $applied = true;
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'hoplytics_set_fetchpriority');

/**
 * Add async/defer attributes to non-critical scripts.
 *
 * @param string $tag    The script tag HTML.
 * @param string $handle The script handle.
 * @return string Modified script tag.
 */
function hoplytics_script_loading_strategy(string $tag, string $handle): string
{
    // Scripts that can be deferred
    $defer_scripts = ['chart-js', 'comment-reply'];

    if (in_array($handle, $defer_scripts, true)) {
        return str_replace(' src=', ' defer src=', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'hoplytics_script_loading_strategy', 10, 2);
