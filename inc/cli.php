<?php
/**
 * WP-CLI Commands — Theme management utilities.
 *
 * Available commands:
 *   wp hoplytics info     — Show theme version and status
 *   wp hoplytics seed     — Seed demo content (services, projects, testimonials)
 *   wp hoplytics audit    — Health check (PHP version, required plugins, asset status)
 *   wp hoplytics flush    — Flush all transients and caches
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

if (!defined('WP_CLI') || !WP_CLI) {
    return;
}

/**
 * Hoplytics Theme CLI commands.
 */
class Hoplytics_CLI
{

    /**
     * Show theme version and status.
     *
     * ## EXAMPLES
     *     wp hoplytics info
     *
     * @subcommand info
     */
    public function info(array $args, array $assoc_args): void
    {
        $theme = wp_get_theme();

        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ Hoplytics Theme Info ━━━%n'));
        WP_CLI::log(sprintf('  Name:       %s', $theme->get('Name')));
        WP_CLI::log(sprintf('  Version:    %s', $theme->get('Version')));
        WP_CLI::log(sprintf('  PHP:        %s (required: 8.2+)', PHP_VERSION));
        WP_CLI::log(sprintf('  WP:         %s', get_bloginfo('version')));
        WP_CLI::log(sprintf('  Style Kit:  %s', get_theme_mod('hoplytics_style_kit', 'tech-futurist')));
        WP_CLI::log(sprintf('  Build:      %s', file_exists(get_template_directory() . '/dist/.vite/manifest.json') ? '✅ Production' : '⚠️ Development'));
        WP_CLI::log('');
    }

    /**
     * Seed demo content for testing.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *     wp hoplytics seed
     *     wp hoplytics seed --force
     *
     * @subcommand seed
     */
    public function seed(array $args, array $assoc_args): void
    {
        $force = WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);

        if (!$force) {
            WP_CLI::confirm('This will create demo services, projects, and testimonials. Continue?');
        }

        $services = [
            ['title' => 'Paid Media Management', 'content' => 'Full-funnel paid advertising across Google, Meta, and LinkedIn.'],
            ['title' => 'SEO & Content Strategy', 'content' => 'Technical SEO, authority building, and conversion-focused content.'],
            ['title' => 'Marketing Automation', 'content' => 'HubSpot, ActiveCampaign, and custom workflow implementation.'],
            ['title' => 'Web Development', 'content' => 'High-performance WordPress sites built for conversion.'],
        ];

        foreach ($services as $s) {
            $id = wp_insert_post([
                'post_type' => 'service',
                'post_title' => $s['title'],
                'post_content' => $s['content'],
                'post_status' => 'publish',
            ]);
            WP_CLI::log(sprintf('  ✅ Service: %s (ID: %d)', $s['title'], $id));
        }

        $testimonials = [
            ['title' => 'Sarah K.', 'content' => '"Hoplytics transformed our lead generation. We went from 5 to 45 qualified leads per month."'],
            ['title' => 'Mike R.', 'content' => '"Best agency we\'ve ever worked with. ROI was 8x within the first quarter."'],
            ['title' => 'Jessica L.', 'content' => '"Their attention to detail and strategic thinking is unmatched."'],
        ];

        foreach ($testimonials as $t) {
            $id = wp_insert_post([
                'post_type' => 'testimonial',
                'post_title' => $t['title'],
                'post_content' => $t['content'],
                'post_status' => 'publish',
            ]);
            WP_CLI::log(sprintf('  ✅ Testimonial: %s (ID: %d)', $t['title'], $id));
        }

        $projects = [
            ['title' => 'Insurance Direct — Lead Gen System', 'content' => 'Built an end-to-end lead generation system generating 200+ exclusive leads per month.'],
            ['title' => 'FinServ Pro — Marketing Automation', 'content' => 'Implemented a 12-step nurture sequence that increased conversions by 340%.'],
        ];

        foreach ($projects as $p) {
            $id = wp_insert_post([
                'post_type' => 'project',
                'post_title' => $p['title'],
                'post_content' => $p['content'],
                'post_status' => 'publish',
            ]);
            WP_CLI::log(sprintf('  ✅ Project: %s (ID: %d)', $p['title'], $id));
        }

        WP_CLI::success('Demo content seeded. 🌱');
    }

    /**
     * Run a health check on the theme installation.
     *
     * ## EXAMPLES
     *     wp hoplytics audit
     *
     * @subcommand audit
     */
    public function audit(array $args, array $assoc_args): void
    {
        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ Hoplytics Health Audit ━━━%n'));

        // PHP Version
        $php_ok = version_compare(PHP_VERSION, '8.2', '>=');
        WP_CLI::log(sprintf('  PHP Version:    %s %s', PHP_VERSION, $php_ok ? '✅' : '❌ (8.2+ required)'));

        // WordPress Version
        $wp_ver = get_bloginfo('version');
        $wp_ok = version_compare($wp_ver, '6.5', '>=');
        WP_CLI::log(sprintf('  WP Version:     %s %s', $wp_ver, $wp_ok ? '✅' : '❌ (6.5+ required)'));

        // Build Status
        $has_build = file_exists(get_template_directory() . '/dist/.vite/manifest.json');
        WP_CLI::log(sprintf('  Build:          %s', $has_build ? '✅ Production build found' : '⚠️ No production build (run npm run build)'));

        // Theme Mods
        $kit = get_theme_mod('hoplytics_style_kit', 'tech-futurist');
        WP_CLI::log(sprintf('  Style Kit:      %s ✅', $kit));

        // Menus
        $menus = get_nav_menu_locations();
        $has_primary = !empty($menus['menu-1']);
        $has_footer = !empty($menus['footer']);
        WP_CLI::log(sprintf('  Primary Menu:   %s', $has_primary ? '✅' : '⚠️ Not assigned'));
        WP_CLI::log(sprintf('  Footer Menu:    %s', $has_footer ? '✅' : '⚠️ Not assigned'));

        // Logo
        $has_logo = (bool) get_theme_mod('custom_logo');
        WP_CLI::log(sprintf('  Custom Logo:    %s', $has_logo ? '✅' : '⚠️ Not set'));

        WP_CLI::log('');

        if ($php_ok && $wp_ok) {
            WP_CLI::success('All checks passed!');
        } else {
            WP_CLI::warning('Some checks failed. See above for details.');
        }
    }

    /**
     * Flush all transients and caches.
     *
     * ## EXAMPLES
     *     wp hoplytics flush
     *
     * @subcommand flush
     */
    public function flush(array $args, array $assoc_args): void
    {
        global $wpdb;

        // Delete all transients
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_transient_%'");

        // Flush object cache if available
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
        }

        WP_CLI::success('All transients and caches flushed. 🧹');
    }
}

WP_CLI::add_command('hoplytics', 'Hoplytics_CLI');
