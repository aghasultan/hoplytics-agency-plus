<?php
/**
 * Hoplytics functions and definitions
 *
 * @package Hoplytics
 */

declare(strict_types=1);

if ( ! defined( 'HOPLYTICS_VERSION' ) ) {
	// Define theme version
	define( 'HOPLYTICS_VERSION', '3.0.0' );
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
require get_template_directory() . '/inc/cpt.php';

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
