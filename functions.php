<?php
/**
 * Hoplytics functions and definitions
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HOPLYTICS_VERSION' ) ) {
	// Define theme version
	define( 'HOPLYTICS_VERSION', '3.0.0' );
}

/**
 * Helper to get the site logo URL (Customizer or Fallback).
 *
 * @return string The URL of the logo image.
 */
function hoplytics_get_logo_url(): string {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        if ( is_array( $image ) ) {
            return $image[0];
        }
    }
    // Fallback
	return get_template_directory_uri() . '/assets/images/logo-horizontal.png';
}

/**
 * Deprecated: Helper to get the local logo URL.
 * Kept for backward compatibility if needed, but aliases to new function.
 *
 * @return string
 */
function hoplytics_get_local_logo_url(): string {
    return hoplytics_get_logo_url();
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * White Labeling features.
 */
require get_template_directory() . '/inc/white-label.php';

/**
 * Customizer & Style Kits.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Post Types & Taxonomies.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Testimonial CPT.
 */
require get_template_directory() . '/inc/cpt-testimonials.php';

/**
 * SEO & Schema.
 */
require get_template_directory() . '/inc/seo.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * CRO Modules (Calculators, Forms).
 */
require get_template_directory() . '/inc/modules/roi-calculator.php';
require get_template_directory() . '/inc/modules/seo-audit.php';
require get_template_directory() . '/inc/modules/hero-form-handler.php';
require get_template_directory() . '/inc/modules/device-frame.php';
require get_template_directory() . '/inc/modules/demo-content-seeder.php';
