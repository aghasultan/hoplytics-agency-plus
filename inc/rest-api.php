<?php
/**
 * REST API endpoints for AJAX form submissions.
 *
 * Replaces admin-post.php handlers with modern REST endpoints.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register REST API routes.
 */
function hoplytics_register_rest_routes(): void
{

    register_rest_route('hoplytics/v1', '/lead', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'hoplytics_rest_handle_lead',
        'permission_callback' => '__return_true',
        'args' => [
            'name' => ['type' => 'string', 'required' => true, 'sanitize_callback' => 'sanitize_text_field'],
            'email' => ['type' => 'string', 'required' => true, 'sanitize_callback' => 'sanitize_email', 'validate_callback' => 'is_email'],
            'website' => ['type' => 'string', 'required' => false, 'sanitize_callback' => 'esc_url_raw'],
            'service' => ['type' => 'string', 'required' => false, 'sanitize_callback' => 'sanitize_text_field'],
            'budget' => ['type' => 'string', 'required' => false, 'sanitize_callback' => 'sanitize_text_field'],
        ],
    ]);

    register_rest_route('hoplytics/v1', '/seo-audit', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'hoplytics_rest_handle_seo_audit',
        'permission_callback' => '__return_true',
        'args' => [
            'url' => ['type' => 'string', 'required' => true, 'sanitize_callback' => 'esc_url_raw'],
            'email' => ['type' => 'string', 'required' => true, 'sanitize_callback' => 'sanitize_email', 'validate_callback' => 'is_email'],
        ],
    ]);
}
add_action('rest_api_init', 'hoplytics_register_rest_routes');

/**
 * Handle lead form submission via REST.
 */
function hoplytics_rest_handle_lead(WP_REST_Request $request): WP_REST_Response
{
    $name = $request->get_param('name');
    $email = $request->get_param('email');
    $website = $request->get_param('website') ?? '';
    $service = $request->get_param('service') ?? '';
    $budget = $request->get_param('budget') ?? '';

    $admin_email = get_option('admin_email');

    $subject = sprintf('[%s] New Lead: %s', get_bloginfo('name'), $name);
    $body = sprintf(
        "Name: %s\nEmail: %s\nWebsite: %s\nService: %s\nBudget: %s\n\nSubmitted: %s",
        $name,
        $email,
        $website,
        $service,
        $budget,
        wp_date('Y-m-d H:i:s')
    );

    $headers = ['Content-Type: text/plain; charset=UTF-8', "Reply-To: {$name} <{$email}>"];

    $sent = wp_mail($admin_email, $subject, $body, $headers);

    if (!$sent) {
        return new WP_REST_Response(
            ['success' => false, 'message' => __('Something went wrong. Please try again.', 'hoplytics')],
            500
        );
    }

    return new WP_REST_Response(
        ['success' => true, 'message' => __('Thank you! We\'ll be in touch within 24 hours.', 'hoplytics')],
        200
    );
}

/**
 * Handle SEO audit form submission via REST.
 */
function hoplytics_rest_handle_seo_audit(WP_REST_Request $request): WP_REST_Response
{
    $url = $request->get_param('url');
    $email = $request->get_param('email');

    $admin_email = get_option('admin_email');

    $subject = sprintf('[%s] SEO Audit Request', get_bloginfo('name'));
    $body = sprintf(
        "URL: %s\nEmail: %s\n\nSubmitted: %s",
        $url,
        $email,
        wp_date('Y-m-d H:i:s')
    );

    $headers = ['Content-Type: text/plain; charset=UTF-8', "Reply-To: <{$email}>"];

    $sent = wp_mail($admin_email, $subject, $body, $headers);

    if (!$sent) {
        return new WP_REST_Response(
            ['success' => false, 'message' => __('Something went wrong. Please try again.', 'hoplytics')],
            500
        );
    }

    return new WP_REST_Response(
        ['success' => true, 'message' => __('Audit received! Check your inbox within 48 hours.', 'hoplytics')],
        200
    );
}
