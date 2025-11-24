<?php
/**
 * ROI Calculator Module
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode to display ROI Calculator
 */
function hoplytics_roi_calculator_shortcode() {
    // Enqueue the script specifically for this module
    // Note: chart-js dependency removed as new logic is pure JS calculation
    wp_enqueue_script( 'hoplytics-roi-calculator', get_template_directory_uri() . '/assets/js/roi-calculator.js', array(), HOPLYTICS_VERSION, true );

    ob_start();
    get_template_part('template-parts/tool', 'roi-calculator');
    return ob_get_clean();
}
add_shortcode( 'roi_calculator', 'hoplytics_roi_calculator_shortcode' );
