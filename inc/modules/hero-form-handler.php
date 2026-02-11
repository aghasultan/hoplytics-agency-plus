<?php
/**
 * Hero Lead Form Handler
 *
 * @package Hoplytics
 */

defined('ABSPATH') || exit;

/**
 * Handle Hero Lead Form Submission
 */
function hoplytics_handle_hero_lead_form(): void
{
    if (!isset($_POST['hero_nonce']) || !wp_verify_nonce($_POST['hero_nonce'], 'hero_lead_form')) {
        wp_die(esc_html__('Security check failed.', 'hoplytics'));
    }

    // Sanitize inputs
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $website = esc_url_raw($_POST['website'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');

    if (empty($name) || empty($email)) {
        wp_die(esc_html__('Please fill in all required fields.', 'hoplytics'));
    }

    // Prepare email
    $to = get_option('admin_email');
    $subject = sprintf(__('New Hero Lead: %s', 'hoplytics'), $name);
    $headers = array('Content-Type: text/html; charset=UTF-8');

    $message = '<h2>' . esc_html__('New Growth Plan Request', 'hoplytics') . '</h2>';
    $message .= '<p><strong>' . esc_html__('Name:', 'hoplytics') . '</strong> ' . esc_html($name) . '</p>';
    $message .= '<p><strong>' . esc_html__('Email:', 'hoplytics') . '</strong> ' . esc_html($email) . '</p>';
    $message .= '<p><strong>' . esc_html__('Website:', 'hoplytics') . '</strong> ' . esc_html($website) . '</p>';
    $message .= '<p><strong>' . esc_html__('Service Interest:', 'hoplytics') . '</strong> ' . esc_html($service) . '</p>';
    $message .= '<p><small>' . esc_html__('Sent from Hoplytics Hero Form', 'hoplytics') . '</small></p>';

    // Send email
    wp_mail($to, $subject, $message, $headers);

    // Redirect back to home with success parameter
    wp_redirect(add_query_arg('hero_lead_submitted', 'true', home_url('/')));
    exit;
}
add_action('admin_post_hoplytics_hero_lead', 'hoplytics_handle_hero_lead_form');
add_action('admin_post_nopriv_hoplytics_hero_lead', 'hoplytics_handle_hero_lead_form');
