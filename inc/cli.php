<?php
/**
 * WP-CLI Commands — Theme management utilities.
 *
 * Available commands:
 *   wp hoplytics info         — Show theme version and status
 *   wp hoplytics seed         — Seed demo content (services, projects, testimonials)
 *   wp hoplytics audit        — Health check (PHP version, required plugins, asset status)
 *   wp hoplytics flush        — Flush all transients and caches
 *   wp hoplytics cleanup      — Delete sample posts, fix typos, clean stale content
 *   wp hoplytics seed-cases   — Seed demo case studies with metrics
 *   wp hoplytics create-pages — Create missing pages (About, Free Tools, Services)
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

    /**
     * Content cleanup — delete sample posts, fix typos, remove stale content.
     *
     * ## OPTIONS
     *
     * [--dry-run]
     * : Show what would be changed without making changes.
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *     wp hoplytics cleanup
     *     wp hoplytics cleanup --dry-run
     *     wp hoplytics cleanup --force
     *
     * @subcommand cleanup
     */
    public function cleanup(array $args, array $assoc_args): void
    {
        $dry_run = WP_CLI\Utils\get_flag_value($assoc_args, 'dry-run', false);
        $force = WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);

        if (!$force && !$dry_run) {
            WP_CLI::confirm('This will delete sample posts and fix content issues. Continue?');
        }

        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ Epic 2: Content Cleanup ━━━%n'));
        $changes = 0;

        // 2.1 — Delete sample/test posts
        $sample_patterns = [
            'Sample Post',
            'Sample post',
            'Hello world',
            'Hello World',
        ];

        $all_posts = get_posts([
            'post_type' => ['post', 'page'],
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]);

        foreach ($all_posts as $post_id) {
            $title = get_the_title($post_id);
            foreach ($sample_patterns as $pattern) {
                if (stripos($title, $pattern) !== false) {
                    if ($dry_run) {
                        WP_CLI::log(sprintf('  🔍 [DRY RUN] Would delete: "%s" (ID: %d)', $title, $post_id));
                    } else {
                        wp_delete_post($post_id, true);
                        WP_CLI::log(sprintf('  🗑️  Deleted: "%s" (ID: %d)', $title, $post_id));
                    }
                    $changes++;
                    break;
                }
            }
        }

        // 2.4 — Fix "Lets Connect" typo → "Let's Connect"
        $typo_pages = get_posts([
            'post_type' => 'page',
            'title' => 'Lets Connect',
            'post_status' => 'any',
            'posts_per_page' => 1,
        ]);

        if (!empty($typo_pages)) {
            $page = $typo_pages[0];
            if ($dry_run) {
                WP_CLI::log(sprintf('  🔍 [DRY RUN] Would fix typo: "%s" → "Let\'s Connect" (ID: %d)', $page->post_title, $page->ID));
            } else {
                wp_update_post([
                    'ID' => $page->ID,
                    'post_title' => "Let's Connect",
                ]);
                WP_CLI::log(sprintf('  ✏️  Fixed typo: "Lets Connect" → "Let\'s Connect" (ID: %d)', $page->ID));
            }
            $changes++;
        }

        // 2.2 — Update blog titles to remove year references
        $year_posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            's' => 'in 2021',
        ]);

        foreach ($year_posts as $post) {
            $new_title = str_ireplace(
                [' in 2021', ' in 2022', ' in 2023', ' in 2024', ' in 2025'],
                '',
                $post->post_title
            );
            if ($new_title !== $post->post_title) {
                if ($dry_run) {
                    WP_CLI::log(sprintf('  🔍 [DRY RUN] Would update title: "%s" → "%s" (ID: %d)', $post->post_title, $new_title, $post->ID));
                } else {
                    wp_update_post([
                        'ID' => $post->ID,
                        'post_title' => $new_title,
                    ]);
                    WP_CLI::log(sprintf('  ✏️  Updated title: "%s" → "%s" (ID: %d)', $post->post_title, $new_title, $post->ID));
                }
                $changes++;
            }
        }

        // 2.3 — Update Case Studies page if it says "Coming soon"
        $cs_page = get_page_by_path('case-studies');
        if ($cs_page) {
            $content = $cs_page->post_content;
            if (stripos($content, 'coming soon') !== false || empty(trim($content))) {
                $new_content = '<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.125rem"},"color":{"text":"#9CA3AF"}}} -->
<p class="has-text-align-center" style="color:#9CA3AF;font-size:1.125rem">We\'re currently building detailed case studies showcasing our client results. In the meantime, book a free strategy call and we\'ll walk you through real examples.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-glow"} -->
<div class="wp-block-button is-style-glow"><a class="wp-block-button__link" href="/get-started">Book Your Free Strategy Call →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->';

                if ($dry_run) {
                    WP_CLI::log('  🔍 [DRY RUN] Would replace Case Studies "Coming soon" with CTA');
                } else {
                    wp_update_post([
                        'ID' => $cs_page->ID,
                        'post_content' => $new_content,
                    ]);
                    WP_CLI::log('  ✏️  Updated Case Studies page — replaced "Coming soon" with CTA');
                }
                $changes++;
            }
        }

        WP_CLI::log('');
        if ($changes === 0) {
            WP_CLI::success('Nothing to clean up — site content is already clean! 🧼');
        } else {
            $verb = $dry_run ? 'would be made' : 'made';
            WP_CLI::success(sprintf('%d change(s) %s. 🧹', $changes, $verb));
        }
    }

    /**
     * Seed demo case studies with realistic metrics.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *     wp hoplytics seed-cases
     *     wp hoplytics seed-cases --force
     *
     * @subcommand seed-cases
     */
    public function seed_cases(array $args, array $assoc_args): void
    {
        $force = WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);

        if (!$force) {
            WP_CLI::confirm('This will create 3 demo case studies. Continue?');
        }

        $case_studies = [
            [
                'title' => 'InsureMax — 340% More Exclusive Leads in 90 Days',
                'content' => '<p>InsureMax was struggling with lead quality. They were buying shared leads from aggregators and competing with 8+ other agents per lead. We built a proprietary lead generation system using Google Ads and a custom landing page funnel that generated 340% more exclusive leads within the first quarter.</p>',
                'excerpt' => 'How we built a proprietary lead gen system that eliminated shared leads and delivered 340% growth.',
                'meta' => [
                    '_cs_client' => 'InsureMax Financial',
                    '_cs_industry' => 'Life Insurance',
                    '_cs_duration' => '6 months',
                    '_cs_services' => 'Google Ads, Landing Pages, CRM Integration',
                    '_cs_challenge' => 'Buying shared leads from aggregators with 8+ agents competing per lead, resulting in 3% close rates and wasted ad spend.',
                    '_cs_solution' => 'Built exclusive lead generation funnels with Google Ads, custom landing pages, and automated CRM follow-up sequences.',
                    '_cs_metric_1_label' => 'Exclusive Leads/Month',
                    '_cs_metric_1_value' => '185',
                    '_cs_metric_1_change' => '↑ 340% increase',
                    '_cs_metric_2_label' => 'Cost Per Lead',
                    '_cs_metric_2_value' => '$28',
                    '_cs_metric_2_change' => '↓ 62% decrease',
                    '_cs_metric_3_label' => 'Close Rate',
                    '_cs_metric_3_value' => '18%',
                    '_cs_metric_3_change' => '↑ from 3% to 18%',
                    '_cs_testimonial' => 'Hoplytics completely transformed our lead pipeline. We went from chasing shared leads to having an exclusive system that books appointments for us automatically.',
                    '_cs_testimonial_author' => 'David K.',
                    '_cs_testimonial_role' => 'Managing Partner, InsureMax Financial',
                ],
            ],
            [
                'title' => 'UrbanFit Studios — $127K Revenue From Social Media in 4 Months',
                'content' => '<p>UrbanFit Studios had 2,000 Instagram followers but zero attribution to revenue. We overhauled their content strategy, launched targeted Facebook and Instagram ad campaigns, and implemented conversion tracking. Within 4 months, social media became their #1 revenue channel.</p>',
                'excerpt' => 'From vanity metrics to $127K in tracked revenue — how strategic social media marketing transformed a fitness brand.',
                'meta' => [
                    '_cs_client' => 'UrbanFit Studios',
                    '_cs_industry' => 'Fitness & Wellness',
                    '_cs_duration' => '4 months',
                    '_cs_services' => 'Social Media Marketing, Paid Social, Content Strategy',
                    '_cs_challenge' => '2,000 Instagram followers with zero revenue attribution. Posting random content with no strategy or tracking.',
                    '_cs_solution' => 'Built authority content calendar, launched targeted FB/IG campaigns with retargeting, implemented end-to-end conversion tracking.',
                    '_cs_metric_1_label' => 'Revenue from Social',
                    '_cs_metric_1_value' => '$127,000',
                    '_cs_metric_1_change' => '↑ from $0 attributed',
                    '_cs_metric_2_label' => 'ROAS',
                    '_cs_metric_2_value' => '5.8x',
                    '_cs_metric_2_change' => '↑ 5.8x return on ad spend',
                    '_cs_metric_3_label' => 'New Members',
                    '_cs_metric_3_value' => '340+',
                    '_cs_metric_3_change' => '↑ 340 new signups',
                    '_cs_testimonial' => 'We had no idea social media could actually drive real revenue. The Hoplytics team showed us exactly what was working and doubled down on it.',
                    '_cs_testimonial_author' => 'Rachel M.',
                    '_cs_testimonial_role' => 'Owner, UrbanFit Studios',
                ],
            ],
            [
                'title' => 'NexaTech SaaS — Page 1 Rankings for 42 Keywords in 5 Months',
                'content' => '<p>NexaTech had a solid product but zero organic visibility. Their website ranked for almost nothing. We executed a comprehensive SEO overhaul — technical fixes, content cluster strategy, and authority link building — achieving page 1 rankings for 42 target keywords in 5 months.</p>',
                'excerpt' => 'Zero organic traffic to 42 page-one rankings — how a comprehensive SEO strategy unlocked sustainable growth for a SaaS company.',
                'meta' => [
                    '_cs_client' => 'NexaTech Solutions',
                    '_cs_industry' => 'SaaS / Technology',
                    '_cs_duration' => '5 months',
                    '_cs_services' => 'SEO, Content Marketing, Technical Audits',
                    '_cs_challenge' => 'Brand-new website with zero domain authority, no content strategy, and competitors dominating all target keywords.',
                    '_cs_solution' => 'Full technical SEO audit and fix, 30-article content cluster strategy, 150+ authority backlinks via outreach.',
                    '_cs_metric_1_label' => 'Page 1 Rankings',
                    '_cs_metric_1_value' => '42',
                    '_cs_metric_1_change' => '↑ from 0 keywords',
                    '_cs_metric_2_label' => 'Organic Traffic',
                    '_cs_metric_2_value' => '12,400/mo',
                    '_cs_metric_2_change' => '↑ from 200/mo',
                    '_cs_metric_3_label' => 'Demo Requests',
                    '_cs_metric_3_value' => '85/mo',
                    '_cs_metric_3_change' => '↑ from 4/mo',
                    '_cs_testimonial' => 'The SEO results speak for themselves. We went from invisible to dominating our niche. Best investment we have ever made.',
                    '_cs_testimonial_author' => 'James T.',
                    '_cs_testimonial_role' => 'VP Marketing, NexaTech Solutions',
                ],
            ],
        ];

        // Ensure taxonomy terms exist
        $service_types = ['SEO', 'PPC', 'Social Media', 'Content Marketing'];
        foreach ($service_types as $term) {
            if (!term_exists($term, 'service_type')) {
                wp_insert_term($term, 'service_type');
            }
        }

        foreach ($case_studies as $cs) {
            // Check if already exists
            $existing = get_page_by_title($cs['title'], OBJECT, 'case_study');
            if ($existing) {
                WP_CLI::log(sprintf('  ⏭️  Skipped (exists): "%s"', $cs['title']));
                continue;
            }

            $post_id = wp_insert_post([
                'post_type' => 'case_study',
                'post_title' => $cs['title'],
                'post_content' => $cs['content'],
                'post_excerpt' => $cs['excerpt'],
                'post_status' => 'publish',
            ]);

            if (is_wp_error($post_id)) {
                WP_CLI::warning(sprintf('Failed to create: "%s" — %s', $cs['title'], $post_id->get_error_message()));
                continue;
            }

            // Set meta fields
            foreach ($cs['meta'] as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }

            WP_CLI::log(sprintf('  ✅ Case Study: "%s" (ID: %d)', $cs['title'], $post_id));
        }

        WP_CLI::success('Demo case studies seeded. 📊');
    }

    /**
     * Create missing pages and assign correct templates.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *     wp hoplytics create-pages
     *     wp hoplytics create-pages --force
     *
     * @subcommand create-pages
     */
    public function create_pages(array $args, array $assoc_args): void
    {
        $force = WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);

        if (!$force) {
            WP_CLI::confirm('This will create missing pages and assign templates. Continue?');
        }

        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ Creating Missing Pages ━━━%n'));

        $pages = [
            [
                'title' => 'About',
                'slug' => 'about',
                'template' => 'page-about',
                'content' => '',
            ],
            [
                'title' => 'Free Marketing Tools',
                'slug' => 'free-tools',
                'template' => 'page-free-tools',
                'content' => '',
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'template' => 'page-services',
                'content' => '',
            ],
        ];

        foreach ($pages as $page_data) {
            $existing = get_page_by_path($page_data['slug']);

            if ($existing) {
                // Page exists — just ensure template is set
                $current_template = get_page_template_slug($existing->ID);
                if ($current_template !== $page_data['template']) {
                    update_post_meta($existing->ID, '_wp_page_template', $page_data['template']);
                    WP_CLI::log(sprintf('  ✏️  Updated template for "%s" → %s (ID: %d)', $page_data['title'], $page_data['template'], $existing->ID));
                } else {
                    WP_CLI::log(sprintf('  ⏭️  Skipped "%s" — already exists with correct template (ID: %d)', $page_data['title'], $existing->ID));
                }
                continue;
            }

            $post_id = wp_insert_post([
                'post_type' => 'page',
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
            ]);

            if (is_wp_error($post_id)) {
                WP_CLI::warning(sprintf('Failed to create "%s": %s', $page_data['title'], $post_id->get_error_message()));
                continue;
            }

            update_post_meta($post_id, '_wp_page_template', $page_data['template']);
            WP_CLI::log(sprintf('  ✅ Created: "%s" → /%s/ (ID: %d, template: %s)', $page_data['title'], $page_data['slug'], $post_id, $page_data['template']));
        }

        WP_CLI::log('');
        WP_CLI::success('All pages created and templates assigned. 📄');
    }
}

WP_CLI::add_command('hoplytics', 'Hoplytics_CLI');
