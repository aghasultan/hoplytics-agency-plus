<?php
/**
 * ROI Calculator Block Template.
 */

// Generate a unique ID for this block instance to link labels and inputs
$unique_id = wp_unique_id( 'roi-' );
?>
<div <?php echo get_block_wrapper_attributes(array('class' => 'wp-block-hoplytics-roi-calculator')); ?>>
    <div class="roi-calculator-form">
        <!-- Monthly Ad Spend -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr( $unique_id . '-ad-spend-range' ); ?>">Monthly Ad Spend</label>
            <div class="range-input-wrapper">
                <input type="range" id="<?php echo esc_attr( $unique_id . '-ad-spend-range' ); ?>" class="roi-ad-spend-range" min="1000" max="50000" step="500" value="5000">
                <div class="number-input-wrapper">
                    <span class="currency-symbol">$</span>
                    <input type="number" id="<?php echo esc_attr( $unique_id . '-ad-spend-number' ); ?>" class="roi-ad-spend-number" min="1000" max="50000" step="500" value="5000">
                </div>
            </div>
        </div>

        <!-- Close Rate -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr( $unique_id . '-close-rate-range' ); ?>">Close Rate</label>
            <div class="range-input-wrapper">
                <input type="range" id="<?php echo esc_attr( $unique_id . '-close-rate-range' ); ?>" class="roi-close-rate-range" min="1" max="100" step="1" value="20">
                <div class="number-input-wrapper">
                    <input type="number" id="<?php echo esc_attr( $unique_id . '-close-rate-number' ); ?>" class="roi-close-rate-number" min="1" max="100" step="1" value="20">
                    <span class="percentage-symbol">%</span>
                </div>
            </div>
        </div>

        <!-- Average Deal Value -->
        <div class="roi-input-group">
            <label for="<?php echo esc_attr( $unique_id . '-deal-value' ); ?>">Average Deal Value</label>
            <div class="number-input-wrapper">
                <span class="currency-symbol">$</span>
                <input type="number" id="<?php echo esc_attr( $unique_id . '-deal-value' ); ?>" class="roi-deal-value" min="0" step="100" value="1000">
            </div>
        </div>
    </div>

    <!-- Output -->
    <div class="roi-calculator-result">
        <span class="roi-label">Estimated Revenue</span>
        <span class="roi-revenue-display">$20,000</span>
    </div>
</div>
