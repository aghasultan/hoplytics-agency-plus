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
    wp_enqueue_script( 'hoplytics-roi-calculator', get_template_directory_uri() . '/assets/js/roi-calculator.js', array('chart-js'), HOPLYTICS_VERSION, true );

    $uid = wp_unique_id( 'roi-' );

    ob_start();
    ?>
    <div class="roi-calculator-wrapper card">
        <h3 class="text-center"><?php _e( 'Marketing ROI Calculator', 'hoplytics' ); ?></h3>
        <div class="roi-grid grid-2">
            <div class="roi-inputs">
                <div class="form-group">
                    <label for="roi-budget-<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Monthly Budget ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-budget-<?php echo esc_attr( $uid ); ?>" class="roi-budget" value="<?php echo esc_attr( 5000 ); ?>" min="0">
                </div>
                <div class="form-group">
                    <label for="roi-cpc-<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Average Cost Per Click ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-cpc-<?php echo esc_attr( $uid ); ?>" class="roi-cpc" value="<?php echo esc_attr( 2.50 ); ?>" step="0.1">
                </div>
                <div class="form-group">
                    <label for="roi-conversion-<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Conversion Rate (%)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-conversion-<?php echo esc_attr( $uid ); ?>" class="roi-conversion" value="<?php echo esc_attr( 3.5 ); ?>" step="0.1">
                </div>
                <div class="form-group">
                    <label for="roi-aov-<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Average Order Value ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-aov-<?php echo esc_attr( $uid ); ?>" class="roi-aov" value="<?php echo esc_attr( 150 ); ?>" min="0">
                </div>
                <!-- Button Removed for Real-Time Calculation -->
            </div>
            <div class="roi-results text-center">
                <canvas class="roi-chart-canvas"></canvas>
                <div class="roi-text-results" style="display: none;">
                    <p><?php esc_html_e( 'Estimated Revenue:', 'hoplytics' ); ?> <strong class="h3 roi-revenue">$0</strong></p>
                    <p><?php esc_html_e( 'Projected ROAS:', 'hoplytics' ); ?> <strong class="h3 roi-roas">0x</strong></p>
                </div>
            </div>
        </div>
        <!-- Optional Gate -->
        <div class="roi-gate" style="display: none;">
            <h4><?php _e( 'Get the Full Report', 'hoplytics' ); ?></h4>
            <input type="email" placeholder="Enter your email address">
            <button class="btn btn-secondary"><?php _e( 'Email Me the Data', 'hoplytics' ); ?></button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'roi_calculator', 'hoplytics_roi_calculator_shortcode' );
