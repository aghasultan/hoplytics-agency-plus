<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hoplytics_body_classes(array $classes): array
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	// Add Style Kit Class
	$style_kit = get_theme_mod('hoplytics_style_kit', 'tech-futurist');
	if ($style_kit) {
		$classes[] = 'style-kit-' . esc_attr($style_kit);
	}

	return $classes;
}
add_filter('body_class', 'hoplytics_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function hoplytics_pingback_header(): void
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'hoplytics_pingback_header');
