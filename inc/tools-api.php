<?php
/**
 * Free Tools REST API — 7 data-driven marketing tools.
 *
 * Endpoints:
 *   POST /hoplytics/v1/audit           — Full website audit
 *   POST /hoplytics/v1/pixel-check     — Meta Pixel & tracking checker
 *   POST /hoplytics/v1/seo-score       — SEO score calculator
 *   POST /hoplytics/v1/speed-check     — Page speed analyzer
 *   POST /hoplytics/v1/social-check    — Social media presence checker
 *   POST /hoplytics/v1/roi-calculator  — Marketing ROI calculator
 *   POST /hoplytics/v1/pricing-estimate — Pricing estimator
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register free tools REST routes.
 */
function hoplytics_register_tools_routes(): void
{
    register_rest_route('hoplytics/v1', '/audit', [
        'methods' => 'POST',
        'callback' => 'hoplytics_website_audit',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'validate_callback' => fn($val) => filter_var($val, FILTER_VALIDATE_URL) !== false,
            ],
        ],
    ]);

    register_rest_route('hoplytics/v1', '/pixel-check', [
        'methods' => 'POST',
        'callback' => 'hoplytics_pixel_checker',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'validate_callback' => fn($val) => filter_var($val, FILTER_VALIDATE_URL) !== false,
            ],
        ],
    ]);

    register_rest_route('hoplytics/v1', '/seo-score', [
        'methods' => 'POST',
        'callback' => 'hoplytics_seo_score',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'validate_callback' => fn($val) => filter_var($val, FILTER_VALIDATE_URL) !== false,
            ],
        ],
    ]);

    // Page Speed Analyzer
    register_rest_route('hoplytics/v1', '/speed-check', [
        'methods' => 'POST',
        'callback' => 'hoplytics_speed_check',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'validate_callback' => fn($val) => filter_var($val, FILTER_VALIDATE_URL) !== false,
            ],
        ],
    ]);

    // Social Media Presence Checker
    register_rest_route('hoplytics/v1', '/social-check', [
        'methods' => 'POST',
        'callback' => 'hoplytics_social_check',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => [
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'validate_callback' => fn($val) => filter_var($val, FILTER_VALIDATE_URL) !== false,
            ],
        ],
    ]);

    // Marketing ROI Calculator
    register_rest_route('hoplytics/v1', '/roi-calculator', [
        'methods' => 'POST',
        'callback' => 'hoplytics_roi_calculator',
        'permission_callback' => '__return_true',
        'args' => [
            'monthly_spend' => ['required' => true, 'type' => 'number', 'sanitize_callback' => 'absint'],
            'monthly_revenue' => ['required' => true, 'type' => 'number', 'sanitize_callback' => 'absint'],
            'conversion_rate' => ['required' => false, 'type' => 'number', 'default' => 2.5],
            'avg_deal_value' => ['required' => false, 'type' => 'number', 'default' => 500],
            'monthly_traffic' => ['required' => false, 'type' => 'number', 'default' => 1000],
            'industry' => ['required' => false, 'type' => 'string', 'default' => 'general', 'sanitize_callback' => 'sanitize_text_field'],
        ],
    ]);

    // Pricing Estimator
    register_rest_route('hoplytics/v1', '/pricing-estimate', [
        'methods' => 'POST',
        'callback' => 'hoplytics_pricing_estimate',
        'permission_callback' => '__return_true',
        'args' => [
            'services' => ['required' => true, 'type' => 'array'],
            'business_size' => ['required' => false, 'type' => 'string', 'default' => 'small', 'sanitize_callback' => 'sanitize_text_field'],
            'goals' => ['required' => false, 'type' => 'array', 'default' => []],
            'timeline' => ['required' => false, 'type' => 'string', 'default' => 'standard', 'sanitize_callback' => 'sanitize_text_field'],
        ],
    ]);
}
add_action('rest_api_init', 'hoplytics_register_tools_routes');

// ────────────────────────────────────────────────────────────────
//  WEBSITE AUDIT
// ────────────────────────────────────────────────────────────────

function hoplytics_website_audit(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');

    // Fetch the page
    $response = wp_remote_get($url, [
        'timeout' => 15,
        'user-agent' => 'Hoplytics-Audit-Bot/1.0',
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Unable to reach the website. Please check the URL and try again.',
        ], 400);
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $html = wp_remote_retrieve_body($response);
    $headers = wp_remote_retrieve_headers($response);

    if ($status_code >= 400) {
        return new WP_REST_Response([
            'success' => false,
            'message' => sprintf('Website returned HTTP %d error.', $status_code),
        ], 400);
    }

    $checks = [];
    $score = 0;
    $max = 0;

    // 1. HTTPS Check
    $max += 10;
    $is_ssl = str_starts_with($url, 'https://');
    $checks[] = [
        'name' => 'HTTPS / SSL',
        'status' => $is_ssl ? 'pass' : 'critical',
        'value' => $is_ssl ? 'Secured with HTTPS' : 'Not using HTTPS — vulnerability risk',
        'advice' => $is_ssl ? '' : 'Install an SSL certificate immediately. All modern hosting includes free SSL.',
        'points' => $is_ssl ? 10 : 0,
    ];
    $score += $is_ssl ? 10 : 0;

    // 2. Title Tag
    $max += 10;
    preg_match('/<title[^>]*>(.*?)<\/title>/si', $html, $title_match);
    $title = $title_match[1] ?? '';
    $title_len = mb_strlen(strip_tags($title));
    $title_ok = $title_len >= 30 && $title_len <= 60;
    $checks[] = [
        'name' => 'Title Tag',
        'status' => $title ? ($title_ok ? 'pass' : 'warning') : 'critical',
        'value' => $title ?: 'Missing',
        'detail' => sprintf('%d characters (ideal: 30–60)', $title_len),
        'advice' => $title ? ($title_ok ? '' : 'Adjust title length to 30–60 characters for optimal display in search results.') : 'Add a descriptive <title> tag. This is the most important on-page SEO element.',
        'points' => $title ? ($title_ok ? 10 : 6) : 0,
    ];
    $score += $title ? ($title_ok ? 10 : 6) : 0;

    // 3. Meta Description
    $max += 10;
    preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']*)/si', $html, $desc_match);
    if (empty($desc_match)) {
        preg_match('/<meta[^>]+content=["\']([^"\']*)["\'][^>]+name=["\']description["\']/si', $html, $desc_match);
    }
    $desc = $desc_match[1] ?? '';
    $desc_len = mb_strlen($desc);
    $desc_ok = $desc_len >= 120 && $desc_len <= 160;
    $checks[] = [
        'name' => 'Meta Description',
        'status' => $desc ? ($desc_ok ? 'pass' : 'warning') : 'critical',
        'value' => $desc ? mb_substr($desc, 0, 100) . '...' : 'Missing',
        'detail' => sprintf('%d characters (ideal: 120–160)', $desc_len),
        'advice' => $desc ? ($desc_ok ? '' : 'Adjust meta description to 120–160 characters.') : 'Add a compelling meta description to improve click-through rates from search results.',
        'points' => $desc ? ($desc_ok ? 10 : 5) : 0,
    ];
    $score += $desc ? ($desc_ok ? 10 : 5) : 0;

    // 4. H1 Tag
    $max += 10;
    preg_match_all('/<h1[^>]*>(.*?)<\/h1>/si', $html, $h1_matches);
    $h1_count = count($h1_matches[1] ?? []);
    $h1_text = $h1_matches[1][0] ?? '';
    $h1_clean = strip_tags($h1_text);
    $h1_ok = $h1_count === 1 && mb_strlen($h1_clean) >= 10;
    $checks[] = [
        'name' => 'H1 Heading',
        'status' => $h1_count === 1 ? 'pass' : ($h1_count === 0 ? 'critical' : 'warning'),
        'value' => $h1_count === 1 ? $h1_clean : sprintf('%d H1 tags found (should be exactly 1)', $h1_count),
        'advice' => $h1_count === 0 ? 'Add exactly one H1 heading that describes the page topic.' : ($h1_count > 1 ? 'Use only one H1 per page. Use H2–H6 for subheadings.' : ''),
        'points' => $h1_ok ? 10 : ($h1_count > 0 ? 4 : 0),
    ];
    $score += $h1_ok ? 10 : ($h1_count > 0 ? 4 : 0);

    // 5. Image Alt Tags
    $max += 10;
    preg_match_all('/<img[^>]+>/si', $html, $img_matches);
    $total_imgs = count($img_matches[0]);
    $imgs_w_alt = 0;
    foreach ($img_matches[0] as $img_tag) {
        if (preg_match('/alt=["\'][^"\']+/i', $img_tag)) {
            $imgs_w_alt++;
        }
    }
    $alt_pct = $total_imgs > 0 ? round(($imgs_w_alt / $total_imgs) * 100) : 100;
    $alt_ok = $alt_pct >= 90;
    $checks[] = [
        'name' => 'Image Alt Text',
        'status' => $alt_ok ? 'pass' : ($alt_pct >= 50 ? 'warning' : 'critical'),
        'value' => sprintf('%d/%d images have alt text (%d%%)', $imgs_w_alt, $total_imgs, $alt_pct),
        'advice' => $alt_ok ? '' : 'Add descriptive alt text to all images for accessibility and SEO.',
        'points' => $alt_ok ? 10 : (int) round($alt_pct / 10),
    ];
    $score += $alt_ok ? 10 : (int) round($alt_pct / 10);

    // 6. Viewport Meta
    $max += 10;
    $has_viewport = (bool) preg_match('/<meta[^>]+name=["\']viewport["\']/i', $html);
    $checks[] = [
        'name' => 'Mobile Viewport',
        'status' => $has_viewport ? 'pass' : 'critical',
        'value' => $has_viewport ? 'Viewport meta tag found' : 'Missing viewport meta tag',
        'advice' => $has_viewport ? '' : 'Add <meta name="viewport" content="width=device-width, initial-scale=1"> for mobile responsiveness.',
        'points' => $has_viewport ? 10 : 0,
    ];
    $score += $has_viewport ? 10 : 0;

    // 7. Open Graph Tags
    $max += 5;
    $has_og = (bool) preg_match('/<meta[^>]+property=["\']og:/i', $html);
    $checks[] = [
        'name' => 'Open Graph Tags',
        'status' => $has_og ? 'pass' : 'warning',
        'value' => $has_og ? 'OG tags found — social sharing optimized' : 'No Open Graph tags found',
        'advice' => $has_og ? '' : 'Add og:title, og:description, and og:image for rich social media previews.',
        'points' => $has_og ? 5 : 0,
    ];
    $score += $has_og ? 5 : 0;

    // 8. Canonical URL
    $max += 5;
    $has_canonical = (bool) preg_match('/<link[^>]+rel=["\']canonical["\']/i', $html);
    $checks[] = [
        'name' => 'Canonical URL',
        'status' => $has_canonical ? 'pass' : 'warning',
        'value' => $has_canonical ? 'Canonical tag found' : 'No canonical URL set',
        'advice' => $has_canonical ? '' : 'Add a canonical URL to prevent duplicate content issues.',
        'points' => $has_canonical ? 5 : 0,
    ];
    $score += $has_canonical ? 5 : 0;

    // 9. Structured Data
    $max += 5;
    $has_jsonld = (bool) preg_match('/<script[^>]+type=["\']application\/ld\+json["\']/i', $html);
    $checks[] = [
        'name' => 'Structured Data (JSON-LD)',
        'status' => $has_jsonld ? 'pass' : 'info',
        'value' => $has_jsonld ? 'JSON-LD structured data found' : 'No structured data detected',
        'advice' => $has_jsonld ? '' : 'Add JSON-LD schema markup for rich search results (snippets, FAQ, breadcrumbs).',
        'points' => $has_jsonld ? 5 : 0,
    ];
    $score += $has_jsonld ? 5 : 0;

    // 10. Content-Security Headers
    $max += 5;
    $headers_arr = is_array($headers) ? $headers : $headers->getAll();
    $has_csp = isset($headers_arr['content-security-policy']) || isset($headers_arr['x-content-type-options']);
    $checks[] = [
        'name' => 'Security Headers',
        'status' => $has_csp ? 'pass' : 'info',
        'value' => $has_csp ? 'Security headers present' : 'Limited security headers',
        'advice' => $has_csp ? '' : 'Add Content-Security-Policy and X-Content-Type-Options headers for improved security.',
        'points' => $has_csp ? 5 : 0,
    ];
    $score += $has_csp ? 5 : 0;

    // Calculate final score
    $final_score = $max > 0 ? (int) round(($score / $max) * 100) : 0;

    // Categorize checks by severity
    $critical = array_filter($checks, fn($c) => $c['status'] === 'critical');
    $warnings = array_filter($checks, fn($c) => $c['status'] === 'warning');
    $passed = array_filter($checks, fn($c) => $c['status'] === 'pass');

    // Save audit result
    $audit_id = wp_insert_post([
        'post_type' => 'site_audit',
        'post_title' => wp_parse_url($url, PHP_URL_HOST) . ' — Audit ' . wp_date('M j, Y'),
        'post_status' => 'private',
        'meta_input' => [
            '_audit_url' => $url,
            '_audit_score' => $final_score,
            '_audit_data' => wp_json_encode($checks),
            '_audit_date' => current_time('mysql'),
        ],
    ]);

    return new WP_REST_Response([
        'success' => true,
        'url' => $url,
        'score' => $final_score,
        'grade' => match (true) {
            $final_score >= 90 => 'A',
            $final_score >= 80 => 'B',
            $final_score >= 60 => 'C',
            $final_score >= 40 => 'D',
            default => 'F',
        },
        'summary' => [
            'critical' => count($critical),
            'warnings' => count($warnings),
            'passed' => count($passed),
        ],
        'checks' => array_values($checks),
        'audit_id' => $audit_id,
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  META PIXEL & TRACKING CHECKER
// ────────────────────────────────────────────────────────────────

function hoplytics_pixel_checker(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');

    $response = wp_remote_get($url, [
        'timeout' => 15,
        'user-agent' => 'Hoplytics-Pixel-Check/1.0',
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Unable to reach the website.',
        ], 400);
    }

    $html = wp_remote_retrieve_body($response);

    // Define trackers to detect
    $trackers = [
        [
            'name' => 'Meta (Facebook) Pixel',
            'icon' => '📘',
            'patterns' => ['fbq(', 'facebook.com/tr', 'connect.facebook.net/en_US/fbevents'],
            'id_regex' => '/fbq\s*\(\s*[\'"]init[\'"]\s*,\s*[\'"](\d+)[\'"]\s*\)/i',
            'guide' => '/services/social-media-marketing',
        ],
        [
            'name' => 'Google Tag Manager',
            'icon' => '🏷️',
            'patterns' => ['googletagmanager.com/gtm.js', 'gtm.start', 'GTM-'],
            'id_regex' => '/GTM-([A-Z0-9]+)/i',
            'guide' => '/insights/google-tag-manager-setup',
        ],
        [
            'name' => 'Google Analytics 4',
            'icon' => '📊',
            'patterns' => ['gtag(', 'google-analytics.com/g/collect', 'googletagmanager.com/gtag'],
            'id_regex' => '/G-([A-Z0-9]+)/i',
            'guide' => '/services/search-engine-marketing',
        ],
        [
            'name' => 'Google Ads Conversion',
            'icon' => '💰',
            'patterns' => ['googleads.g.doubleclick.net', 'gtag_report_conversion', 'AW-'],
            'id_regex' => '/AW-(\d+)/i',
            'guide' => '/services/paid-advertising',
        ],
        [
            'name' => 'LinkedIn Insight Tag',
            'icon' => '💼',
            'patterns' => ['snap.licdn.com/li.lms-analytics', '_linkedin_partner_id'],
            'id_regex' => '/_linkedin_partner_id\s*=\s*["\']?(\d+)/i',
            'guide' => '/services/social-media-marketing',
        ],
        [
            'name' => 'TikTok Pixel',
            'icon' => '🎵',
            'patterns' => ['analytics.tiktok.com', 'ttq.load'],
            'id_regex' => '/ttq\.load\s*\(\s*[\'"]([A-Z0-9]+)[\'"]\s*\)/i',
            'guide' => '/services/social-media-marketing',
        ],
        [
            'name' => 'Microsoft Clarity',
            'icon' => '🔍',
            'patterns' => ['clarity.ms/tag', 'clarity('],
            'id_regex' => '/clarity\.ms\/tag\/([a-z0-9]+)/i',
            'guide' => null,
        ],
        [
            'name' => 'Hotjar',
            'icon' => '🔥',
            'patterns' => ['static.hotjar.com', 'hj('],
            'id_regex' => '/hjid\s*:\s*(\d+)/i',
            'guide' => null,
        ],
        [
            'name' => 'Pinterest Tag',
            'icon' => '📌',
            'patterns' => ['pintrk(', 'ct.pinterest.com'],
            'id_regex' => '/pintrk\s*\(\s*[\'"]load[\'"]\s*,\s*[\'"](\d+)[\'"]\s*\)/i',
            'guide' => null,
        ],
        [
            'name' => 'Twitter/X Pixel',
            'icon' => '🐦',
            'patterns' => ['static.ads-twitter.com', 'twq('],
            'id_regex' => '/twq\s*\(\s*[\'"]init[\'"]\s*,\s*[\'"]([a-z0-9]+)[\'"]\s*\)/i',
            'guide' => null,
        ],
    ];

    $detected = [];
    $missing = [];

    foreach ($trackers as $tracker) {
        $found = false;
        $pixel_id = null;

        foreach ($tracker['patterns'] as $pattern) {
            if (stripos($html, $pattern) !== false) {
                $found = true;
                break;
            }
        }

        // Try to extract the pixel/tag ID
        if ($found && !empty($tracker['id_regex'])) {
            if (preg_match($tracker['id_regex'], $html, $id_match)) {
                $pixel_id = $id_match[1] ?? $id_match[0];
            }
        }

        $entry = [
            'name' => $tracker['name'],
            'icon' => $tracker['icon'],
            'found' => $found,
            'id' => $pixel_id,
        ];

        if (!$found && $tracker['guide']) {
            $entry['guide_url'] = $tracker['guide'];
            $entry['guide_text'] = sprintf('Learn how to set up %s', $tracker['name']);
        }

        if ($found) {
            $detected[] = $entry;
        } else {
            $missing[] = $entry;
        }
    }

    // Also check for schema/JSON-LD and sitemap
    $extras = [];
    if (preg_match('/application\/ld\+json/i', $html)) {
        $extras[] = ['name' => 'JSON-LD Schema', 'icon' => '🏗️', 'found' => true];
    }

    // Recommendations
    $recommendations = [];
    if (empty($detected)) {
        $recommendations[] = 'No tracking pixels detected! You\'re flying blind. Start with Google Analytics 4 and Meta Pixel.';
    }
    if (count($detected) < 3) {
        $recommendations[] = 'Consider adding more tracking to understand your full marketing funnel.';
    }
    $has_analytics = array_filter($detected, fn($t) => str_contains($t['name'], 'Analytics') || str_contains($t['name'], 'Tag Manager'));
    if (empty($has_analytics)) {
        $recommendations[] = 'You have no Google Analytics or GTM. You cannot measure traffic, conversions, or ROI without analytics.';
    }

    return new WP_REST_Response([
        'success' => true,
        'url' => $url,
        'total_detected' => count($detected),
        'total_missing' => count($missing),
        'detected' => $detected,
        'missing' => $missing,
        'extras' => $extras,
        'recommendations' => $recommendations,
        'score' => min(100, count($detected) * 15),
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  SEO SCORE CALCULATOR
// ────────────────────────────────────────────────────────────────

function hoplytics_seo_score(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');

    $response = wp_remote_get($url, [
        'timeout' => 15,
        'user-agent' => 'Hoplytics-SEO-Score/1.0',
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_REST_Response(['success' => false, 'message' => 'Unable to reach the website.'], 400);
    }

    $html = wp_remote_retrieve_body($response);
    $score = 0;
    $max = 0;
    $items = [];

    // Strip scripts/styles for content analysis
    $content_html = preg_replace('/<script[^>]*>.*?<\/script>/si', '', $html);
    $content_html = preg_replace('/<style[^>]*>.*?<\/style>/si', '', $content_html);
    $text_content = strip_tags($content_html);
    $word_count = str_word_count($text_content);

    // 1. Title
    $max += 15;
    preg_match('/<title[^>]*>(.*?)<\/title>/si', $html, $t);
    $title_text = strip_tags($t[1] ?? '');
    $title_len = mb_strlen($title_text);
    $title_pts = ($title_len >= 30 && $title_len <= 60) ? 15 : ($title_len > 0 ? 8 : 0);
    $score += $title_pts;
    $items[] = ['factor' => 'Title Tag', 'current' => $title_text ?: 'Missing', 'ideal' => '30–60 chars', 'score' => $title_pts, 'max' => 15];

    // 2. Meta Description
    $max += 10;
    preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']*)/si', $html, $d);
    if (empty($d))
        preg_match('/<meta[^>]+content=["\']([^"\']*)["\'][^>]+name=["\']description["\']/si', $html, $d);
    $desc_text = $d[1] ?? '';
    $desc_len = mb_strlen($desc_text);
    $desc_pts = ($desc_len >= 120 && $desc_len <= 160) ? 10 : ($desc_len > 0 ? 5 : 0);
    $score += $desc_pts;
    $items[] = ['factor' => 'Meta Description', 'current' => $desc_text ? mb_substr($desc_text, 0, 80) . '...' : 'Missing', 'ideal' => '120–160 chars', 'score' => $desc_pts, 'max' => 10];

    // 3. H1
    $max += 10;
    preg_match_all('/<h1[^>]*>(.*?)<\/h1>/si', $html, $h1s);
    $h1_count = count($h1s[1] ?? []);
    $h1_pts = $h1_count === 1 ? 10 : ($h1_count > 1 ? 4 : 0);
    $score += $h1_pts;
    $items[] = ['factor' => 'H1 Heading', 'current' => $h1_count . ' found', 'ideal' => 'Exactly 1', 'score' => $h1_pts, 'max' => 10];

    // 4. Heading Hierarchy
    $max += 10;
    $has_h2 = (bool) preg_match('/<h2/i', $html);
    $has_h3 = (bool) preg_match('/<h3/i', $html);
    $hier_pts = ($has_h2 && $has_h3) ? 10 : ($has_h2 ? 7 : 3);
    $score += $hier_pts;
    $items[] = ['factor' => 'Heading Hierarchy', 'current' => ($has_h2 ? 'H2: ✓' : 'H2: ✗') . ' ' . ($has_h3 ? 'H3: ✓' : 'H3: ✗'), 'ideal' => 'H1 → H2 → H3 nesting', 'score' => $hier_pts, 'max' => 10];

    // 5. Image Alt Tags
    $max += 10;
    preg_match_all('/<img[^>]+>/si', $html, $imgs);
    $total = count($imgs[0]);
    $alted = 0;
    foreach ($imgs[0] as $img) {
        if (preg_match('/alt=["\'][^"\']+/i', $img))
            $alted++;
    }
    $alt_pct = $total > 0 ? (int) round(($alted / $total) * 100) : 100;
    $alt_pts = (int) round(($alt_pct / 100) * 10);
    $score += $alt_pts;
    $items[] = ['factor' => 'Image Alt Text', 'current' => "$alted/$total ($alt_pct%)", 'ideal' => '100%', 'score' => $alt_pts, 'max' => 10];

    // 6. Word Count
    $max += 10;
    $wc_pts = $word_count >= 1500 ? 10 : ($word_count >= 600 ? 7 : ($word_count >= 300 ? 5 : 2));
    $score += $wc_pts;
    $items[] = ['factor' => 'Word Count', 'current' => number_format($word_count), 'ideal' => '600+ (pages), 1500+ (blog)', 'score' => $wc_pts, 'max' => 10];

    // 7. Internal Links
    $max += 10;
    $host = wp_parse_url($url, PHP_URL_HOST);
    preg_match_all('/<a[^>]+href=["\']([^"\']+)/i', $html, $links);
    $internal = 0;
    $external = 0;
    foreach ($links[1] ?? [] as $href) {
        if (str_starts_with($href, '/') || str_contains($href, (string) $host)) {
            $internal++;
        } elseif (str_starts_with($href, 'http')) {
            $external++;
        }
    }
    $link_pts = $internal >= 3 ? 10 : ($internal >= 1 ? 6 : 2);
    $score += $link_pts;
    $items[] = ['factor' => 'Internal Links', 'current' => "$internal internal, $external external", 'ideal' => '3+ internal links', 'score' => $link_pts, 'max' => 10];

    // 8. URL Structure
    $max += 5;
    $slug = wp_parse_url($url, PHP_URL_PATH) ?: '/';
    $slug_ok = !preg_match('/[_A-Z]/', $slug) && mb_strlen($slug) < 80;
    $slug_pts = $slug_ok ? 5 : 2;
    $score += $slug_pts;
    $items[] = ['factor' => 'URL Structure', 'current' => $slug, 'ideal' => 'Lowercase, hyphens, < 80 chars', 'score' => $slug_pts, 'max' => 5];

    // 9. HTTPS
    $max += 5;
    $ssl_pts = str_starts_with($url, 'https://') ? 5 : 0;
    $score += $ssl_pts;
    $items[] = ['factor' => 'HTTPS', 'current' => $ssl_pts ? 'Yes' : 'No', 'ideal' => 'HTTPS required', 'score' => $ssl_pts, 'max' => 5];

    // 10. Viewport
    $max += 5;
    $vp_pts = preg_match('/<meta[^>]+viewport/i', $html) ? 5 : 0;
    $score += $vp_pts;
    $items[] = ['factor' => 'Mobile Viewport', 'current' => $vp_pts ? 'Present' : 'Missing', 'ideal' => 'Required', 'score' => $vp_pts, 'max' => 5];

    $final = $max > 0 ? (int) round(($score / $max) * 100) : 0;

    return new WP_REST_Response([
        'success' => true,
        'url' => $url,
        'score' => $final,
        'grade' => match (true) {
            $final >= 90 => 'A',
            $final >= 80 => 'B',
            $final >= 60 => 'C',
            $final >= 40 => 'D',
            default => 'F',
        },
        'items' => $items,
        'word_count' => $word_count,
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  PAGE SPEED ANALYZER
// ────────────────────────────────────────────────────────────────

function hoplytics_speed_check(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');

    // Measure load time
    $start = microtime(true);
    $response = wp_remote_get($url, [
        'timeout' => 30,
        'user-agent' => 'Hoplytics-Speed-Check/1.0',
        'sslverify' => false,
    ]);
    $load_time = round(microtime(true) - $start, 2);

    if (is_wp_error($response)) {
        return new WP_REST_Response(['success' => false, 'message' => 'Unable to reach the website.'], 400);
    }

    $html = wp_remote_retrieve_body($response);
    $headers = wp_remote_retrieve_headers($response);
    $page_size = strlen($html);

    // Analyze resources
    preg_match_all('/<script[^>]+src=["\']([^"\']+)/i', $html, $scripts);
    preg_match_all('/<link[^>]+rel=["\']stylesheet["\'][^>]+href=["\']([^"\']+)/i', $html, $stylesheets);
    preg_match_all('/<img[^>]+src=["\']([^"\']+)/i', $html, $images);

    $script_count = count($scripts[1] ?? []);
    $css_count = count($stylesheets[1] ?? []);
    $image_count = count($images[1] ?? []);
    $total_resources = $script_count + $css_count + $image_count;

    // Performance checks
    $checks = [];
    $score = 0;
    $max = 0;

    // 1. Server Response Time (TTFB proxy)
    $max += 20;
    $ttfb_ok = $load_time < 1.0;
    $ttfb_warn = $load_time < 2.5;
    $ttfb_pts = $ttfb_ok ? 20 : ($ttfb_warn ? 12 : 5);
    $score += $ttfb_pts;
    $checks[] = [
        'name' => 'Server Response Time',
        'status' => $ttfb_ok ? 'pass' : ($ttfb_warn ? 'warning' : 'critical'),
        'value' => $load_time . 's',
        'ideal' => '< 1.0s',
        'advice' => $ttfb_ok ? '' : 'Upgrade hosting, enable server-side caching, or use a CDN to reduce response time.',
        'points' => $ttfb_pts,
    ];

    // 2. Page Size
    $max += 15;
    $size_kb = round($page_size / 1024);
    $size_ok = $size_kb < 500;
    $size_warn = $size_kb < 2000;
    $size_pts = $size_ok ? 15 : ($size_warn ? 9 : 3);
    $score += $size_pts;
    $checks[] = [
        'name' => 'Page Size (HTML)',
        'status' => $size_ok ? 'pass' : ($size_warn ? 'warning' : 'critical'),
        'value' => $size_kb . ' KB',
        'ideal' => '< 500 KB',
        'advice' => $size_ok ? '' : 'Reduce page size by minifying HTML, enabling compression, and lazy loading off-screen content.',
        'points' => $size_pts,
    ];

    // 3. Number of Scripts
    $max += 15;
    $js_ok = $script_count <= 5;
    $js_warn = $script_count <= 15;
    $js_pts = $js_ok ? 15 : ($js_warn ? 8 : 3);
    $score += $js_pts;
    $checks[] = [
        'name' => 'JavaScript Files',
        'status' => $js_ok ? 'pass' : ($js_warn ? 'warning' : 'critical'),
        'value' => $script_count . ' scripts',
        'ideal' => '≤ 5 scripts',
        'advice' => $js_ok ? '' : 'Combine or defer JavaScript files. Remove unused scripts to reduce render-blocking.',
        'points' => $js_pts,
    ];

    // 4. CSS Files
    $max += 10;
    $css_ok = $css_count <= 3;
    $css_warn = $css_count <= 8;
    $css_pts = $css_ok ? 10 : ($css_warn ? 6 : 2);
    $score += $css_pts;
    $checks[] = [
        'name' => 'CSS Stylesheets',
        'status' => $css_ok ? 'pass' : ($css_warn ? 'warning' : 'critical'),
        'value' => $css_count . ' stylesheets',
        'ideal' => '≤ 3 stylesheets',
        'advice' => $css_ok ? '' : 'Combine CSS files and inline critical CSS for above-the-fold content.',
        'points' => $css_pts,
    ];

    // 5. Image Count
    $max += 10;
    $img_ok = $image_count <= 10;
    $img_warn = $image_count <= 30;
    $img_pts = $img_ok ? 10 : ($img_warn ? 6 : 2);
    $score += $img_pts;
    $checks[] = [
        'name' => 'Images',
        'status' => $img_ok ? 'pass' : ($img_warn ? 'warning' : 'critical'),
        'value' => $image_count . ' images',
        'ideal' => '≤ 10 above-the-fold',
        'advice' => $img_ok ? '' : 'Lazy load off-screen images. Use WebP/AVIF format and compress images.',
        'points' => $img_pts,
    ];

    // 6. Compression (gzip/brotli)
    $max += 10;
    $headers_arr = is_array($headers) ? $headers : $headers->getAll();
    $encoding = $headers_arr['content-encoding'] ?? '';
    $compressed = str_contains(strtolower((string) $encoding), 'gzip') || str_contains(strtolower((string) $encoding), 'br');
    $comp_pts = $compressed ? 10 : 0;
    $score += $comp_pts;
    $checks[] = [
        'name' => 'Compression',
        'status' => $compressed ? 'pass' : 'critical',
        'value' => $compressed ? 'Enabled (' . $encoding . ')' : 'Not detected',
        'ideal' => 'Gzip or Brotli',
        'advice' => $compressed ? '' : 'Enable Gzip or Brotli compression on your server. This can reduce page size by 70%+.',
        'points' => $comp_pts,
    ];

    // 7. Render-blocking resources
    $max += 10;
    $blocking_css = preg_match_all('/<link[^>]+rel=["\']stylesheet["\'][^>]*>/i', $html);
    $async_js = preg_match_all('/<script[^>]+(async|defer)/i', $html);
    $blocking_ok = $blocking_css <= 2 && $async_js > 0;
    $blocking_pts = $blocking_ok ? 10 : ($blocking_css <= 5 ? 6 : 2);
    $score += $blocking_pts;
    $checks[] = [
        'name' => 'Render-Blocking Resources',
        'status' => $blocking_ok ? 'pass' : 'warning',
        'value' => $blocking_css . ' blocking CSS, ' . ($script_count - $async_js) . ' blocking JS',
        'ideal' => 'Minimize render-blocking',
        'advice' => $blocking_ok ? '' : 'Use async/defer for scripts. Inline critical CSS and lazy-load the rest.',
        'points' => $blocking_pts,
    ];

    // 8. Caching headers
    $max += 10;
    $cache_ctrl = $headers_arr['cache-control'] ?? '';
    $has_cache = !empty($cache_ctrl) && !str_contains(strtolower((string) $cache_ctrl), 'no-cache');
    $cache_pts = $has_cache ? 10 : 0;
    $score += $cache_pts;
    $checks[] = [
        'name' => 'Browser Caching',
        'status' => $has_cache ? 'pass' : 'warning',
        'value' => $has_cache ? 'Enabled' : 'Not optimized',
        'ideal' => 'Cache-Control headers set',
        'advice' => $has_cache ? '' : 'Set Cache-Control headers for static assets to reduce repeat load times.',
        'points' => $cache_pts,
    ];

    $final_score = $max > 0 ? (int) round(($score / $max) * 100) : 0;

    // Performance grade with emoji
    $grade_data = match (true) {
        $final_score >= 90 => ['grade' => 'A', 'emoji' => '🚀', 'label' => 'Excellent'],
        $final_score >= 70 => ['grade' => 'B', 'emoji' => '✅', 'label' => 'Good'],
        $final_score >= 50 => ['grade' => 'C', 'emoji' => '⚠️', 'label' => 'Needs Work'],
        $final_score >= 30 => ['grade' => 'D', 'emoji' => '🐌', 'label' => 'Slow'],
        default => ['grade' => 'F', 'emoji' => '🔴', 'label' => 'Critical'],
    };

    return new WP_REST_Response([
        'success' => true,
        'url' => $url,
        'score' => $final_score,
        'grade' => $grade_data['grade'],
        'emoji' => $grade_data['emoji'],
        'label' => $grade_data['label'],
        'load_time' => $load_time,
        'page_size' => $size_kb,
        'resources' => [
            'scripts' => $script_count,
            'stylesheets' => $css_count,
            'images' => $image_count,
            'total' => $total_resources,
        ],
        'checks' => $checks,
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  SOCIAL MEDIA PRESENCE CHECKER
// ────────────────────────────────────────────────────────────────

function hoplytics_social_check(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');

    $response = wp_remote_get($url, [
        'timeout' => 15,
        'user-agent' => 'Hoplytics-Social-Check/1.0',
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_REST_Response(['success' => false, 'message' => 'Unable to reach the website.'], 400);
    }

    $html = wp_remote_retrieve_body($response);

    // Social platforms to detect
    $platforms = [
        [
            'name' => 'Facebook',
            'icon' => '📘',
            'patterns' => ['facebook.com/', 'fb.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?(?:facebook|fb)\.com\/[a-zA-Z0-9._-]+/i',
        ],
        [
            'name' => 'Instagram',
            'icon' => '📸',
            'patterns' => ['instagram.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?instagram\.com\/[a-zA-Z0-9._]+/i',
        ],
        [
            'name' => 'Twitter / X',
            'icon' => '🐦',
            'patterns' => ['twitter.com/', 'x.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?(?:twitter|x)\.com\/[a-zA-Z0-9_]+/i',
        ],
        [
            'name' => 'LinkedIn',
            'icon' => '💼',
            'patterns' => ['linkedin.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?linkedin\.com\/(?:company|in)\/[a-zA-Z0-9._-]+/i',
        ],
        [
            'name' => 'YouTube',
            'icon' => '🎬',
            'patterns' => ['youtube.com/', 'youtu.be/'],
            'url_regex' => '/https?:\/\/(?:www\.)?youtube\.com\/(?:c\/|channel\/|@)?[a-zA-Z0-9._-]+/i',
        ],
        [
            'name' => 'TikTok',
            'icon' => '🎵',
            'patterns' => ['tiktok.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?tiktok\.com\/@[a-zA-Z0-9._]+/i',
        ],
        [
            'name' => 'Pinterest',
            'icon' => '📌',
            'patterns' => ['pinterest.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?pinterest\.com\/[a-zA-Z0-9._]+/i',
        ],
        [
            'name' => 'GitHub',
            'icon' => '🐙',
            'patterns' => ['github.com/'],
            'url_regex' => '/https?:\/\/(?:www\.)?github\.com\/[a-zA-Z0-9._-]+/i',
        ],
    ];

    $found = [];
    $missing = [];

    foreach ($platforms as $platform) {
        $detected = false;
        $profile_url = null;

        foreach ($platform['patterns'] as $pattern) {
            if (stripos($html, $pattern) !== false) {
                $detected = true;
                break;
            }
        }

        if ($detected && !empty($platform['url_regex'])) {
            if (preg_match($platform['url_regex'], $html, $url_match)) {
                $profile_url = $url_match[0];
            }
        }

        $entry = [
            'name' => $platform['name'],
            'icon' => $platform['icon'],
            'found' => $detected,
            'url' => $profile_url,
        ];

        if ($detected) {
            $found[] = $entry;
        } else {
            $missing[] = $entry;
        }
    }

    // Additional checks
    $extras = [];

    // RSS Feed
    $has_rss = (bool) preg_match('/<link[^>]+type=["\']application\/rss\+xml["\']/i', $html);
    $extras[] = ['name' => 'RSS Feed', 'icon' => '📡', 'found' => $has_rss];

    // Newsletter / Email signup
    $has_newsletter = (bool) preg_match('/newsletter|subscribe|mailchimp|convertkit|email.?signup/i', $html);
    $extras[] = ['name' => 'Newsletter Signup', 'icon' => '📧', 'found' => $has_newsletter];

    // Blog link
    $has_blog = (bool) preg_match('/\/blog|\/insights|\/articles|\/news/i', $html);
    $extras[] = ['name' => 'Blog / Content Hub', 'icon' => '✍️', 'found' => $has_blog];

    // Score
    $total_possible = count($platforms) + count($extras);
    $total_found = count($found) + count(array_filter($extras, fn($e) => $e['found']));
    $score = $total_possible > 0 ? (int) round(($total_found / $total_possible) * 100) : 0;

    // Recommendations
    $recommendations = [];
    if (count($found) < 3) {
        $recommendations[] = 'You have fewer than 3 social profiles linked. Expand your presence to reach more audiences.';
    }
    if (!$has_newsletter) {
        $recommendations[] = 'No email newsletter signup detected. Email marketing averages 36x ROI — add a signup form.';
    }
    if (!$has_blog) {
        $recommendations[] = 'No blog or content hub detected. Publishing 2-4 articles per month can increase organic traffic by 200%+.';
    }
    $facebook_found = array_filter($found, fn($f) => $f['name'] === 'Facebook');
    $ig_found = array_filter($found, fn($f) => $f['name'] === 'Instagram');
    if (empty($facebook_found) && empty($ig_found)) {
        $recommendations[] = 'Neither Facebook nor Instagram detected. These are the two most-used social platforms for businesses.';
    }

    return new WP_REST_Response([
        'success' => true,
        'url' => $url,
        'score' => $score,
        'platforms_found' => count($found),
        'platforms_missing' => count($missing),
        'found' => $found,
        'missing' => $missing,
        'extras' => $extras,
        'recommendations' => $recommendations,
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  MARKETING ROI CALCULATOR
// ────────────────────────────────────────────────────────────────

function hoplytics_roi_calculator(WP_REST_Request $request): WP_REST_Response
{
    $spend = (float) $request->get_param('monthly_spend');
    $revenue = (float) $request->get_param('monthly_revenue');
    $conv_rate = (float) $request->get_param('conversion_rate');
    $deal_value = (float) $request->get_param('avg_deal_value');
    $traffic = (int) $request->get_param('monthly_traffic');
    $industry = $request->get_param('industry');

    // Industry benchmarks
    $benchmarks = [
        'ecommerce' => ['avg_conv' => 2.8, 'avg_roas' => 4.0, 'avg_cpa' => 45],
        'saas' => ['avg_conv' => 3.5, 'avg_roas' => 5.0, 'avg_cpa' => 150],
        'agency' => ['avg_conv' => 2.5, 'avg_roas' => 6.0, 'avg_cpa' => 100],
        'local' => ['avg_conv' => 4.0, 'avg_roas' => 3.5, 'avg_cpa' => 35],
        'healthcare' => ['avg_conv' => 3.2, 'avg_roas' => 4.5, 'avg_cpa' => 80],
        'realestate' => ['avg_conv' => 1.8, 'avg_roas' => 7.0, 'avg_cpa' => 120],
        'general' => ['avg_conv' => 2.5, 'avg_roas' => 4.0, 'avg_cpa' => 60],
    ];

    $bench = $benchmarks[$industry] ?? $benchmarks['general'];

    // Calculations
    $current_roas = $spend > 0 ? round($revenue / $spend, 2) : 0;
    $current_roi = $spend > 0 ? round((($revenue - $spend) / $spend) * 100) : 0;

    // Projected with Hoplytics improvements
    $improved_conv_rate = $conv_rate * 1.35; // 35% improvement
    $improved_traffic = (int) round($traffic * 1.50); // 50% traffic growth  
    $projected_leads = (int) round(($improved_traffic * $improved_conv_rate) / 100);
    $projected_revenue = round($projected_leads * $deal_value);
    $projected_roas = $spend > 0 ? round($projected_revenue / $spend, 2) : 0;
    $projected_roi = $spend > 0 ? round((($projected_revenue - $spend) / $spend) * 100) : 0;

    // Current metrics
    $current_leads = $traffic > 0 ? (int) round(($traffic * $conv_rate) / 100) : 0;

    // Breakeven
    $breakeven_leads = $deal_value > 0 ? (int) ceil($spend / $deal_value) : 0;

    // CPA
    $current_cpa = $current_leads > 0 ? round($spend / $current_leads) : 0;
    $projected_cpa = $projected_leads > 0 ? round($spend / $projected_leads) : 0;

    // 12-month projection
    $annual_current_rev = round($revenue * 12);
    $annual_projected_rev = round($projected_revenue * 12);
    $annual_gain = $annual_projected_rev - $annual_current_rev;

    return new WP_REST_Response([
        'success' => true,
        'current' => [
            'monthly_spend' => $spend,
            'monthly_revenue' => $revenue,
            'roas' => $current_roas,
            'roi_percent' => $current_roi,
            'leads' => $current_leads,
            'cpa' => $current_cpa,
            'conversion_rate' => $conv_rate,
        ],
        'projected' => [
            'monthly_revenue' => $projected_revenue,
            'roas' => $projected_roas,
            'roi_percent' => $projected_roi,
            'leads' => $projected_leads,
            'cpa' => $projected_cpa,
            'conversion_rate' => round($improved_conv_rate, 2),
            'traffic' => $improved_traffic,
        ],
        'annual' => [
            'current_rev' => $annual_current_rev,
            'projected_rev' => $annual_projected_rev,
            'gain' => $annual_gain,
        ],
        'breakeven_leads' => $breakeven_leads,
        'benchmark' => $bench,
        'insights' => array_filter([
            $current_roas < $bench['avg_roas']
            ? sprintf('Your ROAS (%.1fx) is below the %s industry average (%.1fx). There\'s room to optimize.', $current_roas, $industry, $bench['avg_roas'])
            : sprintf('Your ROAS (%.1fx) exceeds the %s industry average (%.1fx). Great performance!', $current_roas, $industry, $bench['avg_roas']),
            $current_cpa > $bench['avg_cpa']
            ? sprintf('Your CPA ($%d) is above the industry benchmark ($%d). We can help lower it.', $current_cpa, $bench['avg_cpa'])
            : null,
            $conv_rate < $bench['avg_conv']
            ? sprintf('Your conversion rate (%.1f%%) is below the %.1f%% industry average. CRO could unlock significant revenue.', $conv_rate, $bench['avg_conv'])
            : null,
            $annual_gain > 0
            ? sprintf('With Hoplytics optimization, you could generate an additional $%s in revenue over 12 months.', number_format($annual_gain))
            : null,
        ]),
    ], 200);
}

// ────────────────────────────────────────────────────────────────
//  PRICING ESTIMATOR
// ────────────────────────────────────────────────────────────────

function hoplytics_pricing_estimate(WP_REST_Request $request): WP_REST_Response
{
    $services = $request->get_param('services');
    $business_size = $request->get_param('business_size');
    $goals = $request->get_param('goals');
    $timeline = $request->get_param('timeline');

    // Service pricing tiers (monthly ranges)
    $pricing = [
        'seo' => ['label' => 'SEO Services', 'min' => 1500, 'max' => 5000, 'icon' => '🔍'],
        'ppc' => ['label' => 'Paid Advertising (PPC)', 'min' => 1000, 'max' => 5000, 'icon' => '🎯'],
        'social' => ['label' => 'Social Media Marketing', 'min' => 1000, 'max' => 4000, 'icon' => '📱'],
        'content' => ['label' => 'Content Marketing', 'min' => 1500, 'max' => 6000, 'icon' => '✍️'],
        'webdev' => ['label' => 'Web Development', 'min' => 3000, 'max' => 15000, 'icon' => '🌐'],
        'automation' => ['label' => 'Marketing Automation', 'min' => 1500, 'max' => 8000, 'icon' => '🤖'],
    ];

    // Business size multipliers
    $size_multiplier = match ($business_size) {
        'startup' => 0.75,
        'small' => 1.0,
        'medium' => 1.5,
        'enterprise' => 2.5,
        default => 1.0,
    };

    // Timeline multiplier (rush = premium)
    $timeline_multiplier = match ($timeline) {
        'urgent' => 1.3,
        'fast' => 1.15,
        'standard' => 1.0,
        'flexible' => 0.9,
        default => 1.0,
    };

    // Goal complexity bonus
    $goal_bonus = 1.0;
    if (in_array('lead_generation', $goals, true))
        $goal_bonus += 0.1;
    if (in_array('brand_awareness', $goals, true))
        $goal_bonus += 0.05;
    if (in_array('ecommerce_sales', $goals, true))
        $goal_bonus += 0.15;
    if (in_array('local_dominance', $goals, true))
        $goal_bonus += 0.05;

    $line_items = [];
    $total_min = 0;
    $total_max = 0;

    foreach ($services as $svc_key) {
        $svc_key = sanitize_text_field($svc_key);
        if (!isset($pricing[$svc_key]))
            continue;

        $svc = $pricing[$svc_key];
        $min = (int) round($svc['min'] * $size_multiplier * $timeline_multiplier * $goal_bonus);
        $max = (int) round($svc['max'] * $size_multiplier * $timeline_multiplier * $goal_bonus);

        $line_items[] = [
            'key' => $svc_key,
            'label' => $svc['label'],
            'icon' => $svc['icon'],
            'min' => $min,
            'max' => $max,
        ];

        $total_min += $min;
        $total_max += $max;
    }

    // Bundle discount for 3+ services
    $discount = 0;
    if (count($line_items) >= 3) {
        $discount = 10;
        $total_min = (int) round($total_min * 0.9);
        $total_max = (int) round($total_max * 0.9);
    } elseif (count($line_items) >= 5) {
        $discount = 15;
        $total_min = (int) round($total_min * 0.85);
        $total_max = (int) round($total_max * 0.85);
    }

    // What's included in the estimate
    $included = [
        'Dedicated Account Manager',
        'Monthly Strategy Calls',
        'Custom Reporting Dashboard',
        'Competitor Monitoring',
    ];

    if (count($services) >= 2) {
        $included[] = 'Cross-Channel Integration';
        $included[] = 'Unified Analytics Setup';
    }

    if (in_array('seo', $services, true) && in_array('content', $services, true)) {
        $included[] = 'SEO + Content Synergy Strategy';
    }

    if (in_array('ppc', $services, true)) {
        $included[] = 'Ad Spend Management (excluded from fee)';
    }

    return new WP_REST_Response([
        'success' => true,
        'line_items' => $line_items,
        'total_min' => $total_min,
        'total_max' => $total_max,
        'discount' => $discount,
        'business_size' => $business_size,
        'timeline' => $timeline,
        'included' => $included,
        'note' => 'This is an estimate. Book a free strategy call for a custom proposal tailored to your specific goals.',
        'cta_url' => '/get-started',
    ], 200);
}
