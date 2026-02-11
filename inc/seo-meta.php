<?php
/**
 * SEO Meta Tags — Per-page meta descriptions, canonical URLs, and robots directives.
 *
 * This module adds essential <head> meta tags that are NOT handled by
 * structured-data.php (which handles OG/Twitter/JSON-LD).
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * ─── Per-Page Meta Descriptions ───────────────────────────────────────
 *
 * Priority hierarchy:
 * 1. Custom field `_hoplytics_meta_description` (if set per post/page)
 * 2. Post/page excerpt (if available)
 * 3. Page-specific defaults (for known pages)
 * 4. Site tagline (last fallback)
 */
function hoplytics_meta_description(): void
{
    $desc = '';

    if (is_front_page()) {
        $desc = 'Hoplytics is a performance-driven digital marketing agency. We build SEO, paid advertising, social media, and content marketing systems that generate revenue — predictably and at scale.';
    } elseif (is_singular()) {
        // Check for custom meta description first
        $custom = get_post_meta(get_the_ID(), '_hoplytics_meta_description', true);
        if (!empty($custom)) {
            $desc = $custom;
        } elseif (has_excerpt()) {
            $desc = get_the_excerpt();
        } else {
            $desc = wp_trim_words(wp_strip_all_tags(get_the_content()), 30, '…');
        }
    } elseif (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        $desc = hoplytics_get_page_meta_description($slug);
    } elseif (is_post_type_archive('case_study')) {
        $desc = 'Real results from real clients. See how Hoplytics has helped businesses grow revenue through SEO, paid advertising, and social media marketing.';
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $desc = !empty($term->description)
            ? $term->description
            : sprintf('Browse %s articles and insights from Hoplytics.', single_term_title('', false));
    } elseif (is_home()) {
        $desc = 'Marketing insights, strategies, and case studies from Hoplytics. Data-driven articles on SEO, paid ads, social media, and content marketing.';
    } elseif (is_search()) {
        $desc = sprintf('Search results for "%s" on Hoplytics.', get_search_query());
    } elseif (is_404()) {
        $desc = 'Page not found. Browse our services, free tools, or blog for what you need.';
    }

    // Final fallback
    if (empty($desc)) {
        $desc = get_bloginfo('description');
    }

    // Sanitise and output
    $desc = wp_strip_all_tags($desc);
    $desc = preg_replace('/\s+/', ' ', $desc); // collapse whitespace
    $desc = mb_substr($desc, 0, 160); // Google typically shows ~155-160 chars

    printf(
        '<meta name="description" content="%s">' . "\n",
        esc_attr(trim($desc))
    );
}
add_action('wp_head', 'hoplytics_meta_description', 3);

/**
 * Default meta descriptions for known page slugs.
 */
function hoplytics_get_page_meta_description(string $slug): string
{
    $defaults = [
        'services' => 'Full-service digital marketing: SEO, paid ads, social media, and content marketing. We build growth machines that generate revenue at scale.',
        'about' => 'Hoplytics is a performance-driven agency founded on data, transparency, and results. 140+ clients served, $12M+ revenue generated, 4.2x average ROAS.',
        'free-tools' => 'Free professional-grade marketing tools. Run a website audit, check tracking pixels, analyze SEO scores, test page speed, and more — no signup required.',
        'get-started' => 'Book a free 30-minute strategy session with Hoplytics. We\'ll audit your marketing and show you exactly where the growth opportunities are.',
        'social-media-marketing' => 'Stop posting into the void. Hoplytics builds social media strategies that convert followers into revenue with paid campaigns, content, and community management.',
        'search-engine-marketing' => 'Get in front of high-intent buyers with precision-targeted Google Ads, Shopping campaigns, and display retargeting managed by Hoplytics.',
        'search-engine-optimization' => 'Rank higher, get found, and own page one. Hoplytics handles technical SEO, content strategy, link building, and local optimization.',
        'content-marketing-services' => 'Content that ranks, converts, and builds trust. Hoplytics creates blog strategies, lead magnets, email sequences, and content distribution systems.',
        'case-studies' => 'Real results from real clients. See how Hoplytics has delivered 340% lead growth, $127K social revenue, and 42 page-one keyword rankings.',
        'insights' => 'Marketing insights and strategies from the Hoplytics team. Data-driven articles on SEO, paid advertising, social media, and growth marketing.',
        'privacy-policy' => 'Hoplytics privacy policy. How we collect, use, and protect your personal information.',
    ];

    return $defaults[$slug] ?? '';
}

/**
 * ─── Canonical URLs ───────────────────────────────────────────────────
 *
 * WordPress outputs `rel="canonical"` since 4.6 via `rel_canonical()`.
 * We just ensure it's not doubled and add it for edge cases.
 */
function hoplytics_canonical_url(): void
{
    // WordPress core handles singular pages. We handle archives and taxonomy.
    if (is_singular()) {
        return; // WP core handles this
    }

    $url = '';

    if (is_front_page()) {
        $url = home_url('/');
    } elseif (is_home()) {
        $url = get_permalink(get_option('page_for_posts'));
    } elseif (is_post_type_archive()) {
        $url = get_post_type_archive_link(get_queried_object()->name ?? '');
    } elseif (is_category() || is_tag() || is_tax()) {
        $url = get_term_link(get_queried_object());
    }

    if (!empty($url) && !is_wp_error($url)) {
        printf('<link rel="canonical" href="%s">' . "\n", esc_url($url));
    }
}
add_action('wp_head', 'hoplytics_canonical_url', 2);

/**
 * ─── Robots Meta ──────────────────────────────────────────────────────
 *
 * Prevent utility/internal pages from being indexed.
 */
function hoplytics_robots_meta(): void
{
    $noindex = false;

    // Don't index search results, 404, paginated archives beyond page 1
    if (is_search() || is_404()) {
        $noindex = true;
    }

    // Don't index paginated content beyond page 1
    if (is_paged()) {
        $noindex = true;
    }

    // Don't index tag archives (usually thin content)
    if (is_tag()) {
        $noindex = true;
    }

    // Check for per-post noindex flag
    if (is_singular()) {
        $custom_robots = get_post_meta(get_the_ID(), '_hoplytics_noindex', true);
        if ($custom_robots === '1') {
            $noindex = true;
        }
    }

    if ($noindex) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }
}
add_action('wp_head', 'hoplytics_robots_meta', 1);

/**
 * ─── Meta Description Admin Field ─────────────────────────────────────
 *
 * Add a meta description field to the post/page editor.
 */
function hoplytics_add_meta_description_box(): void
{
    $screens = ['post', 'page', 'case_study'];

    foreach ($screens as $screen) {
        add_meta_box(
            'hoplytics_meta_description_box',
            __('SEO Meta Description', 'hoplytics'),
            'hoplytics_meta_description_box_html',
            $screen,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'hoplytics_add_meta_description_box');

/**
 * Meta description box HTML.
 */
function hoplytics_meta_description_box_html(\WP_Post $post): void
{
    $value = get_post_meta($post->ID, '_hoplytics_meta_description', true);
    $noindex = get_post_meta($post->ID, '_hoplytics_noindex', true);
    wp_nonce_field('hoplytics_meta_desc_nonce', 'hoplytics_meta_desc_nonce_field');
    ?>
    <div style="margin-bottom: 12px;">
        <label for="hoplytics-meta-desc" style="font-weight: 600; display: block; margin-bottom: 4px;">
            <?php esc_html_e('Meta Description', 'hoplytics'); ?>
        </label>
        <textarea id="hoplytics-meta-desc" name="_hoplytics_meta_description" rows="3" style="width: 100%; max-width: 100%;"
            maxlength="160"
            placeholder="<?php esc_attr_e('Custom meta description (max 160 chars). Leave blank to auto-generate from excerpt.', 'hoplytics'); ?>"><?php echo esc_textarea($value); ?></textarea>
        <p class="description">
            <?php
            $len = mb_strlen($value ?: '');
            printf(
                '<span id="hoplytics-meta-char-count" style="color: %s;">%d</span>/160 characters',
                $len > 160 ? '#EF4444' : ($len > 140 ? '#F59E0B' : '#10B981'),
                $len
            );
            ?>
        </p>
    </div>
    <div>
        <label>
            <input type="checkbox" name="_hoplytics_noindex" value="1" <?php checked($noindex, '1'); ?>>
            <?php esc_html_e('Exclude from search engines (noindex)', 'hoplytics'); ?>
        </label>
    </div>
    <?php
}

/**
 * Save meta description field.
 */
function hoplytics_save_meta_description(int $post_id): void
{
    if (!isset($_POST['hoplytics_meta_desc_nonce_field'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['hoplytics_meta_desc_nonce_field'], 'hoplytics_meta_desc_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Meta description
    if (isset($_POST['_hoplytics_meta_description'])) {
        $desc = sanitize_text_field($_POST['_hoplytics_meta_description']);
        update_post_meta($post_id, '_hoplytics_meta_description', $desc);
    }

    // Noindex
    if (isset($_POST['_hoplytics_noindex'])) {
        update_post_meta($post_id, '_hoplytics_noindex', '1');
    } else {
        delete_post_meta($post_id, '_hoplytics_noindex');
    }
}
add_action('save_post', 'hoplytics_save_meta_description');
