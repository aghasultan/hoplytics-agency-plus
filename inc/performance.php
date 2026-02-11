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

/**
 * Remove jQuery Migrate on the frontend (not needed for modern scripts).
 */
function hoplytics_remove_jquery_migrate(WP_Scripts $scripts): void
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $deps = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps = array_diff($deps, ['jquery-migrate']);
    }
}
add_action('wp_default_scripts', 'hoplytics_remove_jquery_migrate');

/**
 * Remove emoji scripts & styles — saves ~10 KB per page load.
 */
function hoplytics_disable_emojis(): void
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'hoplytics_disable_emojis');

/**
 * Dequeue WP block library CSS on pages that don't use blocks.
 * (Keep it on singular content — posts, pages, case studies.)
 */
function hoplytics_conditionally_dequeue_block_css(): void
{
    if (!is_singular()) {
        return;
    }

    global $post;
    if ($post && !has_blocks($post)) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }
}
add_action('wp_enqueue_scripts', 'hoplytics_conditionally_dequeue_block_css', 100);

/**
 * Add loading="lazy" to all iframes (YouTube, maps, etc.).
 */
function hoplytics_lazy_load_iframes(string $content): string
{
    if (empty($content) || is_admin()) {
        return $content;
    }

    return (string) preg_replace(
        '/<iframe((?!.*loading\s*=)[^>]*)>/i',
        '<iframe$1 loading="lazy">',
        $content
    );
}
add_filter('the_content', 'hoplytics_lazy_load_iframes', 20);

/**
 * Preload critical CSS via HTTP Link header for fastest possible delivery.
 */
function hoplytics_preload_critical_assets(): void
{
    if (is_admin()) {
        return;
    }

    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    if (!file_exists($manifest_path)) {
        return;
    }

    $manifest = json_decode((string) file_get_contents($manifest_path), true);
    if (!$manifest) {
        return;
    }

    // Preload the main CSS (most critical)
    foreach ($manifest as $entry) {
        if (isset($entry['css'])) {
            foreach ($entry['css'] as $css_file) {
                $url = get_template_directory_uri() . '/dist/' . $css_file;
                echo sprintf(
                    '<link rel="preload" href="%s" as="style">' . "\n",
                    esc_url($url)
                );
                break 2; // Only preload the first/main CSS
            }
        }
    }
}
add_action('wp_head', 'hoplytics_preload_critical_assets', 1);

/**
 * Add security + performance headers.
 */
function hoplytics_security_headers(): void
{
    if (is_admin() || defined('DOING_AJAX')) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}
add_action('send_headers', 'hoplytics_security_headers');
