<?php
/**
 * ROI Calculator Module
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Register the ROI Calculator Block.
 */
function hoplytics_roi_calculator_block_init() {
	register_block_type( get_template_directory() . '/blocks/roi-calculator' );
}
add_action( 'init', 'hoplytics_roi_calculator_block_init' );
