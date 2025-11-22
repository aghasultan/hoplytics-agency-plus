<?php
/**
 * SEO Audit Module
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

function hoplytics_seo_audit_shortcode() {
    ob_start();
    ?>
    <div class="seo-audit-wrapper card bg-alt">
        <div class="text-center">
            <h3><?php _e( 'Free SEO Website Audit', 'hoplytics' ); ?></h3>
            <p><?php _e( 'Enter your URL below to see how you stack up against competitors.', 'hoplytics' ); ?></p>
        </div>
        <form class="seo-audit-form flex gap-4" style="margin-top: 1.5rem; flex-wrap: wrap;">
            <input type="url" placeholder="https://yourwebsite.com" required style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <input type="email" placeholder="Your Email" required style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <button type="submit" class="btn btn-primary"><?php _e( 'Analyze Now', 'hoplytics' ); ?></button>
        </form>
        <p class="text-xs text-center mt-2 text-muted"><?php _e( 'We will email your PDF report within 24 hours.', 'hoplytics' ); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'seo_audit', 'hoplytics_seo_audit_shortcode' );
