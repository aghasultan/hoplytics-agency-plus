<?php
/**
 * Template Part: ROI Calculator Tool
 *
 * @package Hoplytics
 */

$uid = wp_unique_id( 'roi-' );
?>
<div class="roi-calculator-wrapper card p-8 border rounded-lg shadow-lg bg-surface">
    <div class="mb-8">
        <span class="text-sm font-bold text-success uppercase tracking-widest mb-2 block"><?php esc_html_e( '06 ROI Estimator', 'hoplytics' ); ?></span>
        <h2 class="text-3xl font-bold mb-3"><?php esc_html_e( 'Forecast Your Growth', 'hoplytics' ); ?></h2>
        <p class="text-muted"><?php esc_html_e( 'Adjust the sliders to see how optimized ad spend compounds into profit.', 'hoplytics' ); ?></p>
    </div>

    <div class="roi-calculator-inner bg-alt p-6 rounded-lg border border-gray-200">
        <!-- Inputs -->
        <div class="roi-inputs mb-8 space-y-8">
            <!-- Ad Spend Slider -->
            <div class="form-group">
                <div class="flex justify-between items-end mb-4">
                    <label for="roi-spend-<?php echo esc_attr( $uid ); ?>" class="text-lg font-bold">
                        <?php esc_html_e( 'Monthly Ad Spend', 'hoplytics' ); ?>
                    </label>
                    <span class="roi-value-display font-bold text-success bg-green-100 px-3 py-1 rounded text-lg" data-target="roi-spend-<?php echo esc_attr( $uid ); ?>">$5,000</span>
                </div>
                <div class="range-wrapper">
                    <input type="range"
                           id="roi-spend-<?php echo esc_attr( $uid ); ?>"
                           class="roi-spend w-full"
                           min="1000"
                           max="50000"
                           step="500"
                           value="5000">
                </div>
            </div>

            <!-- ROAS Slider -->
            <div class="form-group">
                <div class="flex justify-between items-end mb-4">
                    <label for="roi-roas-<?php echo esc_attr( $uid ); ?>" class="text-lg font-bold">
                        <?php esc_html_e( 'Target ROAS (Return)', 'hoplytics' ); ?>
                    </label>
                    <span class="roi-value-display font-bold text-success bg-green-100 px-3 py-1 rounded text-lg" data-target="roi-roas-<?php echo esc_attr( $uid ); ?>">3.0x</span>
                </div>
                <div class="range-wrapper">
                    <input type="range"
                           id="roi-roas-<?php echo esc_attr( $uid ); ?>"
                           class="roi-roas w-full"
                           min="1.0"
                           max="10.0"
                           step="0.1"
                           value="3.0">
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-2 gap-4">
            <!-- Revenue Output -->
            <div class="roi-result-card bg-white p-6 rounded-lg text-center border border-gray-200 shadow-sm flex flex-col justify-center">
                <h4 class="text-xs font-bold text-muted uppercase tracking-widest mb-3"><?php esc_html_e( 'Estimated Revenue', 'hoplytics' ); ?></h4>
                <div class="roi-revenue text-4xl font-extrabold text-black mb-0">$15,000</div>
            </div>

            <!-- Profit Output -->
            <div class="roi-result-card bg-green-50 p-6 rounded-lg text-center border border-green-100 shadow-sm flex flex-col justify-center">
                <h4 class="text-xs font-bold text-muted uppercase tracking-widest mb-3"><?php esc_html_e( 'Est. Gross Profit', 'hoplytics' ); ?></h4>
                <div class="roi-profit text-4xl font-extrabold text-success mb-2">$10,000</div>
                <p class="text-xs text-muted"><?php esc_html_e( '(Revenue - Ad Spend)', 'hoplytics' ); ?></p>
            </div>
        </div>
    </div>
</div>
