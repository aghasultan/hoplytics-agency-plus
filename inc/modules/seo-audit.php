<?php
/**
 * SEO Audit Module
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * SEO Audit Shortcode Output
 */
function hoplytics_seo_audit_shortcode() {
    ob_start();

    // Check for success message
    if ( isset( $_GET['seo_audit_submitted'] ) && 'true' === $_GET['seo_audit_submitted'] ) {
        ?>
        <div class="seo-audit-wrapper card bg-alt">
            <div class="text-center">
                <h3 class="text-success"><?php _e( 'Audit Requested!', 'hoplytics' ); ?></h3>
                <p><?php _e( 'We received your request. Your PDF report will be emailed to you within 24 hours.', 'hoplytics' ); ?></p>
                <a href="<?php echo esc_url( remove_query_arg( 'seo_audit_submitted' ) ); ?>" class="btn btn-sm btn-link mt-4"><?php _e( 'Analyze Another Site', 'hoplytics' ); ?></a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    ?>
    <div class="seo-audit-wrapper card bg-alt">
        <div class="text-center">
            <h3><?php _e( 'Free SEO Website Audit', 'hoplytics' ); ?></h3>
            <p><?php _e( 'Enter your URL below to see how you stack up against competitors.', 'hoplytics' ); ?></p>
        </div>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="seo-audit-form flex gap-4" style="margin-top: 1.5rem; flex-wrap: wrap;">
            <input type="hidden" name="action" value="hoplytics_seo_audit">
            <?php wp_nonce_field( 'seo_audit_action', 'seo_audit_nonce' ); ?>

            <input type="url" name="seo_url" placeholder="https://yourwebsite.com" required style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <input type="email" name="seo_email" placeholder="Your Email" required style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <button type="submit" class="btn btn-primary"><?php _e( 'Analyze Now', 'hoplytics' ); ?></button>
        </form>
        <p class="text-xs text-center mt-2 text-muted"><?php _e( 'We will email your PDF report within 24 hours.', 'hoplytics' ); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'seo_audit', 'hoplytics_seo_audit_shortcode' );

/**
 * Handle SEO Audit Form Submission
 */
function hoplytics_handle_seo_audit_form() {
    if ( ! isset( $_POST['seo_audit_nonce'] ) || ! wp_verify_nonce( $_POST['seo_audit_nonce'], 'seo_audit_action' ) ) {
        wp_die( esc_html__( 'Security check failed.', 'hoplytics' ) );
    }

    // Sanitize inputs
    $url   = esc_url_raw( $_POST['seo_url'] ?? '' );
    $email = sanitize_email( $_POST['seo_email'] ?? '' );

    if ( empty( $url ) || empty( $email ) ) {
        wp_die( esc_html__( 'Please fill in all required fields.', 'hoplytics' ) );
    }

    // Prepare email
    $to      = get_option( 'admin_email' );
    $subject = __( 'New SEO Audit Request', 'hoplytics' );
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    $message  = '<h2>' . esc_html__( 'New SEO Audit Request', 'hoplytics' ) . '</h2>';
    $message .= '<p><strong>' . esc_html__( 'Website URL:', 'hoplytics' ) . '</strong> ' . esc_html( $url ) . '</p>';
    $message .= '<p><strong>' . esc_html__( 'Email:', 'hoplytics' ) . '</strong> ' . esc_html( $email ) . '</p>';
    $message .= '<p><small>' . esc_html__( 'Sent from Hoplytics SEO Audit Module', 'hoplytics' ) . '</small></p>';

    // Send email
    wp_mail( $to, $subject, $message, $headers );

    // Redirect back to referring page with success parameter
    // Use wp_get_referer() or fallback to home_url()
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url();
    $redirect_url = add_query_arg( 'seo_audit_submitted', 'true', $redirect_url );

    wp_redirect( $redirect_url );
    exit;
}
add_action( 'admin_post_hoplytics_seo_audit', 'hoplytics_handle_seo_audit_form' );
add_action( 'admin_post_nopriv_hoplytics_seo_audit', 'hoplytics_handle_seo_audit_form' );
