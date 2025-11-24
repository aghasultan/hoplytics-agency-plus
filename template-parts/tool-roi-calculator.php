<?php
/**
 * Template Part: ROI Calculator Tool
 *
 * @package Hoplytics
 */

$uid = wp_unique_id( 'roi-' );
?>
<div class="roi-calculator-wrapper card p-8 border rounded-lg shadow-lg bg-surface">
    <h3 class="text-2xl font-bold mb-6 text-center text-primary"><?php _e( 'ROI Calculator', 'hoplytics' ); ?></h3>

    <div class="grid grid-2 gap-8">
        <div class="roi-inputs space-y-4">
            <div class="form-group">
                <label for="roi-traffic-<?php echo esc_attr( $uid ); ?>" class="block text-sm font-medium mb-1">
                    <?php esc_html_e( 'Monthly Traffic (Visitors)', 'hoplytics' ); ?>
                </label>
                <input type="number" id="roi-traffic-<?php echo esc_attr( $uid ); ?>" class="roi-traffic form-input w-full p-2 border rounded" value="5000" min="0">
            </div>

            <div class="form-group">
                <label for="roi-conversion-<?php echo esc_attr( $uid ); ?>" class="block text-sm font-medium mb-1">
                    <?php esc_html_e( 'Conversion Rate (%)', 'hoplytics' ); ?>
                </label>
                <input type="number" id="roi-conversion-<?php echo esc_attr( $uid ); ?>" class="roi-conversion form-input w-full p-2 border rounded" value="2.5" step="0.1">
            </div>

            <div class="form-group">
                <label for="roi-clv-<?php echo esc_attr( $uid ); ?>" class="block text-sm font-medium mb-1">
                    <?php esc_html_e( 'Customer Lifetime Value ($)', 'hoplytics' ); ?>
                </label>
                <input type="number" id="roi-clv-<?php echo esc_attr( $uid ); ?>" class="roi-clv form-input w-full p-2 border rounded" value="1500" min="0">
            </div>
        </div>

        <div class="roi-results flex flex-col items-center justify-center p-6 bg-alt rounded-lg text-center">
            <h4 class="text-lg uppercase tracking-widest text-muted mb-2"><?php esc_html_e( 'Projected Revenue', 'hoplytics' ); ?></h4>
            <div class="roi-revenue text-4xl font-extrabold text-success mb-4">$0</div>
            <p class="text-sm text-muted opacity-75"><?php esc_html_e( 'Based on your inputs', 'hoplytics' ); ?></p>
        </div>
    </div>
</div>
