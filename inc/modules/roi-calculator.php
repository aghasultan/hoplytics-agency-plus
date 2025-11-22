<?php
/**
 * ROI Calculator Module
 *
 * @package Hoplytics
 */

declare(strict_types=1);

/**
 * Shortcode to display ROI Calculator
 */
function hoplytics_roi_calculator_shortcode() {
    // Enqueue the script specifically for this module
    wp_enqueue_script( 'hoplytics-roi-calculator', get_template_directory_uri() . '/assets/js/roi-calculator.js', array('chart-js'), '1.0.0', true );

    ob_start();
    ?>
    <div class="roi-calculator-wrapper card">
        <h3 class="text-center"><?php _e( 'Marketing ROI Calculator', 'hoplytics' ); ?></h3>
        <div class="roi-grid grid-2">
            <div class="roi-inputs">
                <div class="form-group">
                    <label><?php _e( 'Monthly Budget ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-budget" value="5000" min="0">
                </div>
                <div class="form-group">
                    <label><?php _e( 'Average Cost Per Click ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-cpc" value="2.50" step="0.1">
                </div>
                <div class="form-group">
                    <label><?php _e( 'Conversion Rate (%)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-conversion" value="3.5" step="0.1">
                </div>
                <div class="form-group">
                    <label><?php _e( 'Average Order Value ($)', 'hoplytics' ); ?></label>
                    <input type="number" id="roi-aov" value="150" min="0">
                </div>
                <button id="roi-calculate-btn" class="btn btn-primary w-100"><?php _e( 'Calculate Potential Revenue', 'hoplytics' ); ?></button>
            </div>
            <div class="roi-results text-center">
                <canvas id="roiChart"></canvas>
                <div id="roi-text-results" style="margin-top: 1rem; display: none;">
                    <p><?php _e( 'Estimated Revenue:', 'hoplytics' ); ?> <strong class="h3" id="roi-revenue">$0</strong></p>
                    <p><?php _e( 'Projected ROAS:', 'hoplytics' ); ?> <strong class="h3" id="roi-roas">0x</strong></p>
                </div>
            </div>
        </div>
        <!-- Optional Gate -->
        <div class="roi-gate" id="roi-gate" style="display: none;">
            <h4><?php _e( 'Get the Full Report', 'hoplytics' ); ?></h4>
            <input type="email" placeholder="Enter your email address">
            <button class="btn btn-secondary"><?php _e( 'Email Me the Data', 'hoplytics' ); ?></button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'roi_calculator', 'hoplytics_roi_calculator_shortcode' );
