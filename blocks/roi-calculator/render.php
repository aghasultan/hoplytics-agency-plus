<?php
/**
 * ROI Calculator Block Template.
 * Uses the WordPress Interactivity API for reactive state.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

$unique_id = wp_unique_id('roi-');

// Initial state for Interactivity API context
$context = [
    'adSpend' => 5000,
    'closeRate' => 20,
    'dealValue' => 1000,
    'cplConstant' => 50,
    'revenue' => '$20,000',
];
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'wp-block-hoplytics-roi-calculator']); ?>
    data-wp-interactive="hoplytics/roi-calculator" <?php echo wp_interactivity_data_wp_context($context); ?>>
    <div class="roi-calculator-form">

        <!-- Monthly Ad Spend -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr($unique_id . '-ad-spend-range'); ?>">Monthly Ad Spend</label>
            <div class="range-input-wrapper">
                <input type="range" id="<?php echo esc_attr($unique_id . '-ad-spend-range'); ?>"
                    class="roi-ad-spend-range" min="1000" max="50000" step="500" data-wp-bind--value="context.adSpend"
                    data-wp-on--input="actions.updateAdSpend">
                <div class="number-input-wrapper">
                    <span class="currency-symbol">$</span>
                    <input type="number" id="<?php echo esc_attr($unique_id . '-ad-spend-number'); ?>"
                        class="roi-ad-spend-number" min="1000" max="50000" step="500"
                        data-wp-bind--value="context.adSpend" data-wp-on--input="actions.updateAdSpend">
                </div>
            </div>
        </div>

        <!-- Close Rate -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr($unique_id . '-close-rate-range'); ?>">Close Rate</label>
            <div class="range-input-wrapper">
                <input type="range" id="<?php echo esc_attr($unique_id . '-close-rate-range'); ?>"
                    class="roi-close-rate-range" min="1" max="100" step="1" data-wp-bind--value="context.closeRate"
                    data-wp-on--input="actions.updateCloseRate">
                <div class="number-input-wrapper">
                    <input type="number" id="<?php echo esc_attr($unique_id . '-close-rate-number'); ?>"
                        class="roi-close-rate-number" min="1" max="100" step="1" data-wp-bind--value="context.closeRate"
                        data-wp-on--input="actions.updateCloseRate">
                    <span class="percentage-symbol">%</span>
                </div>
            </div>
        </div>

        <!-- Average Deal Value -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr($unique_id . '-deal-value'); ?>">Average Deal Value</label>
            <div class="number-input-wrapper">
                <span class="currency-symbol">$</span>
                <input type="number" id="<?php echo esc_attr($unique_id . '-deal-value'); ?>" class="roi-deal-value"
                    min="0" step="100" data-wp-bind--value="context.dealValue"
                    data-wp-on--input="actions.updateDealValue">
            </div>
        </div>

    </div>

    <!-- Output -->
    <div class="roi-calculator-result">
        <span class="roi-label">Estimated Revenue</span>
        <span class="roi-revenue-display" data-wp-text="context.revenue">$20,000</span>
    </div>
</div>