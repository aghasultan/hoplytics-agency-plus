<?php
/**
 * JSON-LD Structured Data — Organization, Service, FAQPage, BreadcrumbList.
 *
 * Outputs relevant schema.org JSON-LD on every page for rich search results.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Output Organization schema on every page.
 */
function hoplytics_jsonld_organization(): void
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Hoplytics',
        'url' => home_url('/'),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'description' => 'Data-driven digital marketing agency specializing in SEO, paid advertising, social media, content marketing, web development, and marketing automation.',
        'sameAs' => array_filter([
            get_theme_mod('hoplytics_facebook', 'https://facebook.com/hoplytics'),
            get_theme_mod('hoplytics_instagram', 'https://instagram.com/hoplytics'),
            get_theme_mod('hoplytics_linkedin', 'https://linkedin.com/company/hoplytics'),
            get_theme_mod('hoplytics_twitter', 'https://twitter.com/hoplytics'),
            get_theme_mod('hoplytics_youtube', ''),
        ]),
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'email' => get_option('admin_email'),
            'url' => home_url('/get-started'),
        ],
    ];

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );
}
add_action('wp_head', 'hoplytics_jsonld_organization', 5);

/**
 * Output BreadcrumbList schema on non-front pages.
 */
function hoplytics_jsonld_breadcrumbs(): void
{
    if (is_front_page())
        return;

    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => home_url('/'),
        ]
    ];

    $pos = 2;

    if (is_singular()) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => get_the_title(),
            'item' => get_permalink(),
        ];
    } elseif (is_archive()) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => get_the_archive_title(),
            'item' => get_pagenum_link(1),
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );
}
add_action('wp_head', 'hoplytics_jsonld_breadcrumbs', 6);

/**
 * Output Article schema on blog posts.
 */
function hoplytics_jsonld_article(): void
{
    if (!is_singular('post'))
        return;

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt(),
        'url' => get_permalink(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => [
            '@type' => 'Person',
            'name' => get_the_author(),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Hoplytics',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/assets/images/logo.png',
            ],
        ],
    ];

    if (has_post_thumbnail()) {
        $schema['image'] = get_the_post_thumbnail_url(null, 'full');
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );
}
add_action('wp_head', 'hoplytics_jsonld_article', 7);

/**
 * Output Open Graph and Twitter Card meta tags.
 */
function hoplytics_og_meta(): void
{
    $title = is_singular() ? get_the_title() : get_bloginfo('name');
    $desc = is_singular() ? get_the_excerpt() : get_bloginfo('description');
    $url = is_singular() ? get_permalink() : home_url('/');
    $type = is_singular('post') ? 'article' : 'website';
    $image = '';

    if (is_singular() && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(null, 'full');
    } else {
        $image = get_template_directory_uri() . '/assets/images/og-default.png';
    }

    echo '<meta property="og:type" content="' . esc_attr($type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr(wp_trim_words($desc, 30)) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    echo '<meta property="og:site_name" content="Hoplytics">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr(wp_trim_words($desc, 30)) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
}
add_action('wp_head', 'hoplytics_og_meta', 4);
