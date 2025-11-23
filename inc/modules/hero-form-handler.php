<?php
/**
 * Hero Lead Form Handler
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle Hero Lead Form Submission
 */
function hoplytics_handle_hero_lead_form() {
    if ( ! isset( $_POST['hero_nonce'] ) || ! wp_verify_nonce( $_POST['hero_nonce'], 'hero_lead_form' ) ) {
        wp_die( esc_html__( 'Security check failed.', 'hoplytics' ) );
    }

    // Sanitize inputs
    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $website = esc_url_raw( $_POST['website'] ?? '' );
    $service = sanitize_text_field( $_POST['service'] ?? '' );

    if ( empty( $name ) || empty( $email ) ) {
        wp_die( esc_html__( 'Please fill in all required fields.', 'hoplytics' ) );
    }

    // In a real application, you would send an email or save to DB here.
    // For this theme, we simulate success.

    // Redirect back to home with success parameter
    wp_redirect( add_query_arg( 'hero_lead_submitted', 'true', home_url( '/' ) ) );
    exit;
}
add_action( 'admin_post_hoplytics_hero_lead', 'hoplytics_handle_hero_lead_form' );
add_action( 'admin_post_nopriv_hoplytics_hero_lead', 'hoplytics_handle_hero_lead_form' );
