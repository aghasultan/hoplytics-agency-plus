<?php
/**
 * Enqueue scripts and styles.
 *
 * Uses Vite manifest for production builds (hashed filenames for cache-busting)
 * and raw source files for development.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Enqueue scripts and styles.
 */
function hoplytics_scripts(): void
{
    // Google Fonts (Inter, Orbitron, Rajdhani, Space Grotesk, DM Sans)
    wp_enqueue_style(
        'hoplytics-google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Inter:wght@400;600;700&family=Orbitron:wght@700&family=Rajdhani:wght@400;600&family=Space+Grotesk:wght@400;700&display=swap',
        [],
        null
    );

    // Main Theme Styles — uses dist/ hashed version in production
    hoplytics_enqueue_style('hoplytics-variables', 'assets/css/variables.css');
    hoplytics_enqueue_style('hoplytics-design-system', 'assets/css/design-system.css', ['hoplytics-variables']);
    hoplytics_enqueue_style('hoplytics-main', 'assets/css/main.css', ['hoplytics-design-system']);

    // Dark mode toggle (load in head to prevent FOUC)
    hoplytics_enqueue_script('hoplytics-dark-mode', 'assets/js/dark-mode-toggle.js', [], false);

    // AJAX Forms
    hoplytics_enqueue_script('hoplytics-forms', 'assets/js/forms.js');
    hoplytics_enqueue_script('hoplytics-animations', 'assets/js/animations.js');
    wp_localize_script('hoplytics-forms', 'hoplyticsApi', [
        'restUrl' => esc_url_raw(rest_url('hoplytics/v1')),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Free Tools (audit, pixel checker, SEO score)
    hoplytics_enqueue_style('hoplytics-free-tools-css', 'assets/css/free-tools.css', ['hoplytics-main']);
    hoplytics_enqueue_style('hoplytics-contact-form', 'assets/css/contact-form.css', ['hoplytics-main']);
    hoplytics_enqueue_style('hoplytics-header-nav', 'assets/css/header-nav.css', ['hoplytics-main']);
    hoplytics_enqueue_script('hoplytics-free-tools', 'assets/js/free-tools.js');
}
add_action('wp_enqueue_scripts', 'hoplytics_scripts');
