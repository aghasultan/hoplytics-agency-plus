<?php
/**
 * Hoplytics Content Seeder
 *
 * Automatically generates high-converting service pages and blog content.
 * Trigger via URL: /wp-admin/?seed_hoplytics_content=true
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Main Seeder Function
 */
function hoplytics_run_seeder() {
    // Security Check
    if ( ! isset( $_GET['seed_hoplytics_content'] ) || $_GET['seed_hoplytics_content'] !== 'true' ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized access.' );
    }

    // 1. Seed Service Pages
    $services = [
        'Social Media Marketing' => [
            'slug' => 'social-media-marketing',
            'icon' => 'dashicons-share',
            'content' => hoplytics_get_social_content(),
            'excerpt' => 'Build a loyal community and drive engagement with data-driven social strategies.',
        ],
        'Search Engine Marketing' => [
            'slug' => 'search-engine-marketing',
            'icon' => 'dashicons-chart-area',
            'content' => hoplytics_get_sem_content(),
            'excerpt' => 'Maximize ROI with precision PPC campaigns and ad spend optimization.',
        ],
        'Search Engine Optimization' => [
            'slug' => 'search-engine-optimization',
            'icon' => 'dashicons-search',
            'content' => hoplytics_get_seo_content(),
            'excerpt' => 'Dominate search rankings and drive organic traffic that converts.',
        ],
        'Content Marketing Services' => [
            'slug' => 'content-marketing-services',
            'icon' => 'dashicons-format-aside',
            'content' => hoplytics_get_content_marketing_content(),
            'excerpt' => 'Tell your story with high-impact content that educates and converts.',
        ],
    ];

    foreach ( $services as $title => $data ) {
        // We actually want to force the slug if we can, but wp_insert_post takes 'post_name' for slug.
        // We'll update the helper to support slug or just pass it in content if needed,
        // but hoplytics_create_page_if_missing checks by TITLE.
        // If we want to ensure the SLUG matches our new templates, we should pass it.
        hoplytics_create_page_if_missing( $title, $data['content'], 'service', $data['excerpt'], $data['slug'] ?? '' );
    }

    // 2. Seed Insights Page (Blog)
    $insights_page = hoplytics_create_page_if_missing( 'Insights', '', 'page' );
    if ( $insights_page ) {
        update_option( 'page_for_posts', $insights_page );
    }

    // 3. Seed Dummy Blog Posts
    hoplytics_seed_blog_posts();

    // Redirect to prevent re-submission
    wp_redirect( admin_url( 'edit.php?post_type=page&seeded=true' ) );
    exit;
}
add_action( 'admin_init', 'hoplytics_run_seeder' );

/**
 * Helper: Create Page/Post if missing
 */
function hoplytics_create_page_if_missing( $title, $content, $type = 'page', $excerpt = '', $slug = '' ) {
    // Check by title first
    $existing = get_page_by_title( $title, OBJECT, $type );

    if ( $existing ) {
        // If the page exists but the slug doesn't match the desired slug, update it.
        // This ensures old pages (e.g., 'seo') get moved to new URLs (e.g., 'search-engine-optimization').
        if ( ! empty( $slug ) && $existing->post_name !== $slug ) {
            wp_update_post( array(
                'ID'        => $existing->ID,
                'post_name' => $slug,
            ) );
        }
        return $existing->ID;
    }

    // Also check by slug if provided, to avoid duplicates if title changed
    if ( ! empty( $slug ) ) {
        $existing_by_slug = get_page_by_path( $slug, OBJECT, $type );
        if ( $existing_by_slug ) {
            return $existing_by_slug->ID;
        }
    }

    $post_data = array(
        'post_title'    => $title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_type'     => $type,
        'post_excerpt'  => $excerpt,
        'post_author'   => get_current_user_id(),
    );

    if ( ! empty( $slug ) ) {
        $post_data['post_name'] = $slug;
    }

    return wp_insert_post( $post_data );
}

/**
 * Helper: Seed Blog Posts
 */
function hoplytics_seed_blog_posts() {
    $posts = [
        [
            'title' => 'The Future of SEO: AI and Semantic Search',
            'content' => '<p>Search engines are evolving. With the rise of AI-driven results, keyword stuffing is dead. It is all about semantic relevance and user intent...</p>',
            'cat' => 'Strategy',
        ],
        [
            'title' => '5 Metrics That Actually Matter for ROI',
            'content' => '<p>Vanity metrics like "likes" can be misleading. In this guide, we break down the financial metrics that actually drive business growth...</p>',
            'cat' => 'Analytics',
        ],
        [
            'title' => 'Why Your Content Marketing Strategy Is Failing',
            'content' => '<p>Consistency is key, but relevance is king. Discover the common pitfalls brands make when scaling their content operations...</p>',
            'cat' => 'Marketing',
        ],
    ];

    foreach ( $posts as $p ) {
        if ( ! get_page_by_title( $p['title'], OBJECT, 'post' ) ) {
            $id = wp_insert_post([
                'post_title' => $p['title'],
                'post_content' => $p['content'],
                'post_status' => 'publish',
                'post_type' => 'post',
            ]);
            wp_set_object_terms( $id, $p['cat'], 'category', true );
        }
    }
}

/* ==========================================================================
   #Content Generators (HTML)
   ========================================================================== */

function hoplytics_get_social_content() {
    return '
    <div class="section bg-alt">
        <div class="container text-center">
            <h3>Turn Followers into Customers</h3>
            <p>Social media is more than just posting. It’s about building a community that trusts your brand. Our data-driven approach ensures every like, comment, and share contributes to your bottom line.</p>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="grid grid-3">
                <div class="card">
                    <h4>Strategy Development</h4>
                    <p>Custom roadmaps tailored to your audience demographics and behaviors.</p>
                </div>
                <div class="card">
                    <h4>Community Management</h4>
                    <p>Real-time engagement to foster loyalty and brand advocacy.</p>
                </div>
                <div class="card">
                    <h4>Paid Social Ads</h4>
                    <p>High-conversion campaigns on LinkedIn, Instagram, and TikTok.</p>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="/contact" class="btn">Start Your Campaign</a>
            </div>
        </div>
    </div>';
}

function hoplytics_get_sem_content() {
    return '
    <div class="section bg-alt">
        <div class="container text-center">
            <h3>Precision Targeting. Maximum ROI.</h3>
            <p>Stop wasting budget on clicks that don\'t convert. We utilize advanced bidding strategies and audience segmentation to put your brand in front of high-intent buyers.</p>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="grid grid-2">
                <div class="card">
                    <h4>Google Ads (PPC)</h4>
                    <p>Capture demand at the exact moment customers are searching for your solution.</p>
                </div>
                <div class="card">
                    <h4>Retargeting</h4>
                    <p>Re-engage visitors who left your site and turn them into paying customers.</p>
                </div>
            </div>
        </div>
    </div>';
}

function hoplytics_get_seo_content() {
    return '
    <div class="section bg-alt">
        <div class="container text-center">
            <h3>Rank Higher. Grow Faster.</h3>
            <p>Organic search is the sustainable engine of growth. We combine technical excellence with content authority to dominate the SERPs.</p>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="grid grid-3">
                <div class="card">
                    <h4>Technical SEO</h4>
                    <p>Site speed, mobile optimization, and schema markup to ensure perfect indexing.</p>
                </div>
                <div class="card">
                    <h4>On-Page Optimization</h4>
                    <p>Keyword research and content structure that speaks to both bots and humans.</p>
                </div>
                <div class="card">
                    <h4>Link Building</h4>
                    <p>High-authority backlinks to boost your domain trust and credibility.</p>
                </div>
            </div>
        </div>
    </div>';
}

function hoplytics_get_content_marketing_content() {
    return '
    <div class="section bg-alt">
        <div class="container text-center">
            <h3>Content That Converts</h3>
            <p>We create educational, entertaining, and authoritative content that guides your prospects through the buyer\'s journey.</p>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="grid grid-2">
                <div class="card">
                    <h4>Blog Strategy</h4>
                    <p>SEO-driven articles that answer your customers\' most pressing questions.</p>
                </div>
                <div class="card">
                    <h4>Whitepapers & Ebooks</h4>
                    <p>In-depth resources to generate leads and establish thought leadership.</p>
                </div>
            </div>
        </div>
    </div>';
}
