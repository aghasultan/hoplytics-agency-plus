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
 *   wp hoplytics seo-check      — Audit SEO completeness across all published content
 *   wp hoplytics seed-articles  — Seed 3 evergreen blog articles
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

    /**
     * SEO completeness audit across all published content.
     *
     * ## EXAMPLES
     *     wp hoplytics seo-check
     *
     * @subcommand seo-check
     */
    public function seo_check(array $args, array $assoc_args): void
    {
        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ SEO Completeness Audit ━━━%n'));

        $post_types = ['post', 'page', 'case_study'];
        $issues = 0;
        $total = 0;

        foreach ($post_types as $pt) {
            $posts = get_posts([
                'post_type' => $pt,
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ]);

            if (empty($posts))
                continue;

            WP_CLI::log('');
            WP_CLI::log(WP_CLI::colorize(sprintf('  %s%%B %s (%d)%%n', '', ucfirst(str_replace('_', ' ', $pt)), count($posts))));

            foreach ($posts as $post) {
                $total++;
                $post_issues = [];

                // Check meta description
                $meta_desc = get_post_meta($post->ID, '_hoplytics_meta_description', true);
                $has_excerpt = !empty(trim($post->post_excerpt));
                if (empty($meta_desc) && !$has_excerpt) {
                    $post_issues[] = 'No meta description or excerpt';
                }

                // Check title length
                $title_len = mb_strlen($post->post_title);
                if ($title_len > 60) {
                    $post_issues[] = sprintf('Title too long (%d chars, max 60)', $title_len);
                } elseif ($title_len < 10) {
                    $post_issues[] = sprintf('Title too short (%d chars)', $title_len);
                }

                // Check featured image
                if ($pt !== 'page' && !has_post_thumbnail($post->ID)) {
                    $post_issues[] = 'No featured image';
                }

                // Check content length
                $word_count = str_word_count(wp_strip_all_tags($post->post_content));
                if ($pt === 'post' && $word_count < 300) {
                    $post_issues[] = sprintf('Thin content (%d words, aim for 300+)', $word_count);
                }

                // Check noindex
                $noindex = get_post_meta($post->ID, '_hoplytics_noindex', true);
                if ($noindex === '1') {
                    $post_issues[] = '⚠️ Marked as noindex';
                }

                if (!empty($post_issues)) {
                    $issues += count($post_issues);
                    WP_CLI::log(sprintf('    ❌ "%s" (ID: %d)', $post->post_title, $post->ID));
                    foreach ($post_issues as $issue) {
                        WP_CLI::log(sprintf('       └─ %s', $issue));
                    }
                } else {
                    WP_CLI::log(sprintf('    ✅ "%s"', $post->post_title));
                }
            }
        }

        // Check infrastructure
        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B  Infrastructure%n'));

        // Sitemap
        $sitemap_url = home_url('/wp-sitemap.xml');
        WP_CLI::log(sprintf('    📍 Sitemap: %s', $sitemap_url));

        // Structured data files
        $sd_file = get_template_directory() . '/inc/structured-data.php';
        WP_CLI::log(sprintf('    📍 Structured Data: %s', file_exists($sd_file) ? '✅ Loaded' : '❌ Missing'));

        $meta_file = get_template_directory() . '/inc/seo-meta.php';
        WP_CLI::log(sprintf('    📍 SEO Meta Tags: %s', file_exists($meta_file) ? '✅ Loaded' : '❌ Missing'));

        $sitemap_file = get_template_directory() . '/inc/sitemap.php';
        WP_CLI::log(sprintf('    📍 Sitemap Enhancements: %s', file_exists($sitemap_file) ? '✅ Loaded' : '❌ Missing'));

        // OG image
        $og_image = get_template_directory() . '/assets/images/og-default.png';
        WP_CLI::log(sprintf('    📍 OG Default Image: %s', file_exists($og_image) ? '✅ Found' : '⚠️ Missing (create assets/images/og-default.png)'));

        // Summary
        WP_CLI::log('');
        $score = $total > 0 ? round((($total * 4 - $issues) / ($total * 4)) * 100) : 0;
        WP_CLI::log(sprintf('  📊 %d pages audited, %d issues found', $total, $issues));
        WP_CLI::log(sprintf('  📊 SEO Score: %d%%', $score));
        WP_CLI::log('');

        if ($issues === 0) {
            WP_CLI::success('Perfect SEO score! All content is optimised. 🏆');
        } else {
            WP_CLI::warning(sprintf('%d SEO issues found. Review and fix the items above.', $issues));
        }
    }

    /**
     * Seed 3 evergreen blog articles aligned with service offerings.
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *     wp hoplytics seed-articles
     *     wp hoplytics seed-articles --force
     *
     * @subcommand seed-articles
     */
    public function seed_articles(array $args, array $assoc_args): void
    {
        $force = WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);

        if (!$force) {
            WP_CLI::confirm('This will create 3 evergreen blog articles. Continue?');
        }

        WP_CLI::log('');
        WP_CLI::log(WP_CLI::colorize('%B━━━ Seeding Evergreen Articles ━━━%n'));

        // Ensure 'Articles' category exists
        $articles_cat = term_exists('Articles', 'category');
        if (!$articles_cat) {
            $articles_cat = wp_insert_term('Articles', 'category');
        }
        $articles_cat_id = is_array($articles_cat) ? $articles_cat['term_id'] : $articles_cat;

        // Ensure 'SEO' category exists
        $seo_cat = term_exists('SEO', 'category');
        if (!$seo_cat) {
            $seo_cat = wp_insert_term('SEO', 'category');
        }
        $seo_cat_id = is_array($seo_cat) ? $seo_cat['term_id'] : $seo_cat;

        $articles = [
            [
                'title' => '7 SEO Strategies That Still Work in ' . date('Y') . ' (And 3 That Don\'t)',
                'slug' => 'seo-strategies-that-work',
                'excerpt' => 'Cut through the noise. Here are the search engine optimization tactics that actually move the needle for small and mid-size businesses — backed by real campaign data.',
                'meta_desc' => 'Discover 7 proven SEO strategies for ' . date('Y') . '. From topical authority to technical optimization, learn what actually drives organic growth.',
                'category' => (int) $seo_cat_id,
                'content' => '<h2>The SEO Landscape Has Changed — Your Strategy Should Too</h2>
<p>Every year, Google rolls out hundreds of algorithm updates. Most are noise. But a handful fundamentally change what works. After managing SEO campaigns for dozens of businesses, here are the strategies that consistently deliver results.</p>

<h2>1. Topical Authority Over Individual Keywords</h2>
<p>Google\'s Helpful Content system now evaluates entire domains, not just individual pages. Instead of targeting isolated keywords, build comprehensive topic clusters. Create a "pillar page" covering a broad topic, then link 8-12 supporting articles that explore subtopics in depth.</p>
<p><strong>Example:</strong> Instead of one page targeting "social media marketing," we create a pillar page plus supporting content on platform strategy, content calendars, paid social integration, analytics tracking, and community management.</p>

<h2>2. Technical SEO as a Foundation</h2>
<p>No amount of content fixes a broken technical foundation. Prioritize Core Web Vitals — especially Largest Contentful Paint (LCP) and Cumulative Layout Shift (CLS). Sites that score 90+ on mobile PageSpeed Insights consistently outrank slower competitors for the same keywords.</p>

<h2>3. Strategic Internal Linking</h2>
<p>Internal links are the most underrated SEO lever. Every new piece of content should link to 3-5 existing pages, and receive links from 2-3 established pages. This distributes page authority and helps Google understand your content hierarchy.</p>

<h2>4. E-E-A-T Signals (Experience, Expertise, Authority, Trust)</h2>
<p>Google explicitly looks for signals that content creators have firsthand experience. Add author bios with credentials, link to case studies, include original data, and reference specific client results (with permission). Generic AI-generated content without these signals will struggle.</p>

<h2>5. Local SEO for Service Businesses</h2>
<p>If you serve a specific geographic area, local SEO often delivers the highest ROI. Optimize your Google Business Profile, build citations on industry directories, collect reviews systematically, and create location-specific landing pages with unique content.</p>

<h2>6. Content Refresh Strategy</h2>
<p>Publishing new content is only half the equation. Set a quarterly schedule to update your top-performing pages with fresh data, updated screenshots, and new internal links. Pages that are updated regularly retain rankings longer and often see ranking improvements.</p>

<h2>7. Backlink Quality Over Quantity</h2>
<p>One editorial link from an industry publication is worth more than 50 directory listings. Focus on creating linkable assets — original research, industry surveys, free tools, and comprehensive guides that journalists and bloggers naturally want to reference.</p>

<h2>What No Longer Works</h2>
<ul>
<li><strong>Keyword stuffing:</strong> Repeating your target keyword unnecessarily hurts more than it helps. Write naturally.</li>
<li><strong>Mass guest posting:</strong> Low-quality guest posts on irrelevant sites are now a negative signal.</li>
<li><strong>Thin page-per-keyword strategy:</strong> Creating separate pages for slight keyword variations causes cannibalization. Consolidate instead.</li>
</ul>

<h2>The Bottom Line</h2>
<p>SEO in ' . date('Y') . ' rewards businesses that create genuinely useful content, maintain technically sound websites, and build real authority in their niche. There are no shortcuts, but the compounding returns make it the highest-ROI marketing channel for most businesses.</p>

<p><strong>Need help building an SEO strategy?</strong> <a href="/get-started/">Book a free strategy call</a> and we\'ll audit your current organic presence.</p>',
            ],
            [
                'title' => 'The ROI of Social Media Marketing: Real Numbers From Real Campaigns',
                'slug' => 'social-media-marketing-roi',
                'excerpt' => 'Social media marketing isn\'t just brand awareness. Here are concrete ROI metrics and frameworks from actual client campaigns showing how social drives revenue.',
                'meta_desc' => 'Discover real social media marketing ROI data from actual campaigns. Learn how to measure, optimize, and scale paid and organic social for maximum return.',
                'category' => (int) $articles_cat_id,
                'content' => '<h2>Stop Guessing — Start Measuring Social Media ROI</h2>
<p>"We post every day but can\'t prove it works." We hear this from nearly every new client. The problem isn\'t social media — it\'s the measurement framework. Here\'s how to fix that, with real numbers from campaigns we\'ve managed.</p>

<h2>The Social Media ROI Framework</h2>
<p>ROI isn\'t just revenue divided by ad spend. For social media, you need to track three tiers of value:</p>
<ol>
<li><strong>Direct Revenue:</strong> Sales directly attributed to social clicks (tracked via UTMs and conversion pixels)</li>
<li><strong>Assisted Revenue:</strong> Social as a touchpoint in multi-channel customer journeys (requires Google Analytics 4 attribution modeling)</li>
<li><strong>Brand Equity:</strong> Share of voice, sentiment, engagement rate trends, audience growth quality (not vanity metrics)</li>
</ol>

<h2>Case Study: B2B Service Company</h2>
<p>A professional services firm came to us spending $2,000/month on boosted posts with no tracking. We restructured their approach:</p>
<ul>
<li><strong>Platform focus:</strong> Shifted 80% of effort to LinkedIn (where their buyers actually are)</li>
<li><strong>Content mix:</strong> 60% educational, 25% social proof, 15% promotional</li>
<li><strong>Ad strategy:</strong> Retargeting website visitors with case study content</li>
</ul>
<p><strong>Results (6 months):</strong> 12 qualified leads from LinkedIn alone, $180K in closed revenue from a $12K ad spend. That\'s a 15x return.</p>

<h2>Case Study: E-Commerce Brand</h2>
<p>An online retailer was running Facebook Ads with a 1.2x ROAS (barely breaking even). Our optimization:</p>
<ul>
<li>Rebuilt audiences using Lookalike models from top 10% LTV customers</li>
<li>Created UGC-style video ads instead of polished product shots</li>
<li>Implemented a post-purchase review → social proof → retargeting loop</li>
</ul>
<p><strong>Results (90 days):</strong> ROAS improved from 1.2x to 4.8x. Monthly revenue from social increased 310%.</p>

<h2>Organic Social: The Long Game</h2>
<p>Organic social is slower but compounds over time. The key metrics that matter:</p>
<ul>
<li><strong>Engagement Rate:</strong> Industry average is 1-3%. Our clients typically achieve 4-7% by focusing on conversation-starting content.</li>
<li><strong>Save/Share Ratio:</strong> Saves and shares are stronger signals than likes. Create content people bookmark for later.</li>
<li><strong>Profile Visit Rate:</strong> Track how many people visit your profile from posts. This indicates purchase intent.</li>
</ul>

<h2>Budgeting Guidelines</h2>
<p>Based on our experience across 50+ campaigns:</p>
<ul>
<li><strong>Startups:</strong> $1,500-3,000/month (focused on 1-2 platforms)</li>
<li><strong>Growth stage:</strong> $3,000-8,000/month (3 platforms + paid amplification)</li>
<li><strong>Established:</strong> $8,000-20,000+/month (full-funnel strategy across all channels)</li>
</ul>

<h2>Getting Started</h2>
<p>The first step is always an audit. Where are your customers? What content resonates? Where are the gaps? <a href="/free-tools/">Use our free Social Media Presence Checker</a> to get a baseline, then <a href="/get-started/">book a strategy session</a> to build your custom plan.</p>',
            ],
            [
                'title' => 'Google Ads Optimization: 5 Levers That Drive Down Cost Per Lead',
                'slug' => 'google-ads-optimization-guide',
                'excerpt' => 'Spending more on Google Ads but getting fewer leads? These 5 optimization levers can reduce your cost per lead by 30-60% without cutting your budget.',
                'meta_desc' => 'Learn 5 proven Google Ads optimization tactics to reduce cost per lead by 30-60%. Real campaign data and actionable strategies for PPC success.',
                'category' => (int) $articles_cat_id,
                'content' => '<h2>Why Most Google Ads Accounts Waste 20-40% of Their Budget</h2>
<p>We audit hundreds of Google Ads accounts every year. The pattern is always the same: broad match keywords eating budget, no negative keyword strategy, landing pages that don\'t convert, and no bid strategy testing. Here are the 5 levers that consistently drive results.</p>

<h2>1. Negative Keyword Mining</h2>
<p>This is the single highest-impact optimization for most accounts. Review your Search Terms report weekly and add irrelevant queries as negative keywords. Most accounts we audit have 50-200 wasted clicks per month on completely irrelevant searches.</p>
<p><strong>Pro tip:</strong> Create a shared negative keyword list and apply it across all campaigns. Include common qualifiers: "free," "salary," "jobs," "how to," "DIY," and "reddit."</p>

<h2>2. Landing Page Alignment</h2>
<p>Never send ad traffic to your homepage. Every ad group should have a dedicated landing page that matches the search intent exactly. The headline should echo the search query. The form should ask for minimum information. The page should load in under 2 seconds on mobile.</p>
<p><strong>Impact:</strong> Switching from homepage to dedicated landing pages typically improves conversion rate by 40-80%. Quality Score also improves, which reduces CPC.</p>

<h2>3. Bid Strategy Optimization</h2>
<p>Google\'s automated bidding has gotten remarkably good — but only when fed the right data. Start with Maximize Conversions to collect data, then switch to Target CPA once you have 50+ conversions in 30 days. Always set a maximum CPC cap to prevent outlier clicks.</p>

<h2>4. Ad Copy Testing</h2>
<p>Run at least 3 responsive search ad variations per ad group. Test different value propositions, CTAs, and social proof elements. Pin your strongest headline in position 1 and let Google rotate the rest.</p>
<p>Winning patterns we\'ve seen:</p>
<ul>
<li>Headlines with specific numbers ("340% More Leads" beats "More Leads")</li>
<li>CTAs that reduce friction ("Get Free Quote" beats "Contact Us")</li>
<li>Social proof ("Trusted by 500+ Companies" in your description)</li>
</ul>

<h2>5. Audience Layering</h2>
<p>Don\'t just target keywords — layer audience signals on top. Add in-market audiences, custom intent audiences based on competitor URLs, and retargeting lists. Bid modifiers let you spend more on high-intent audiences and less on cold traffic.</p>

<h2>The Optimization Cadence</h2>
<table>
<thead><tr><th>Frequency</th><th>Action</th></tr></thead>
<tbody>
<tr><td>Daily</td><td>Check spend pacing, pause any runaway campaigns</td></tr>
<tr><td>Weekly</td><td>Negative keyword mining, bid adjustments, ad copy review</td></tr>
<tr><td>Biweekly</td><td>Landing page conversion rate analysis, A/B test review</td></tr>
<tr><td>Monthly</td><td>Full account audit, budget reallocation, strategy review</td></tr>
<tr><td>Quarterly</td><td>Campaign restructure, new keyword research, competitor analysis</td></tr>
</tbody>
</table>

<h2>When to Call in Help</h2>
<p>If you\'re spending more than $3,000/month on Google Ads, professional management typically pays for itself through efficiency gains. Our clients see an average 42% reduction in CPA within the first 90 days of management.</p>
<p><a href="/get-started/">Book a free Google Ads audit</a> and we\'ll identify your top 3 optimization opportunities.</p>',
            ],
        ];

        foreach ($articles as $article) {
            // Check if article already exists
            $existing = get_page_by_path($article['slug'], OBJECT, 'post');
            if ($existing && !$force) {
                WP_CLI::log(sprintf('  ⏭️  Skipped: "%s" (already exists, ID: %d)', $article['title'], $existing->ID));
                continue;
            }

            if ($existing && $force) {
                wp_delete_post($existing->ID, true);
            }

            $post_id = wp_insert_post([
                'post_type' => 'post',
                'post_title' => $article['title'],
                'post_name' => $article['slug'],
                'post_content' => $article['content'],
                'post_excerpt' => $article['excerpt'],
                'post_status' => 'publish',
                'post_category' => [$article['category']],
            ]);

            if (is_wp_error($post_id)) {
                WP_CLI::warning(sprintf('Failed to create: "%s" — %s', $article['title'], $post_id->get_error_message()));
                continue;
            }

            // Set SEO meta description
            update_post_meta($post_id, '_hoplytics_meta_description', $article['meta_desc']);

            WP_CLI::log(sprintf('  ✅ Created: "%s" (ID: %d)', $article['title'], $post_id));
        }

        WP_CLI::log('');
        WP_CLI::success('Evergreen articles published! 📝');
    }
}

WP_CLI::add_command('hoplytics', 'Hoplytics_CLI');
