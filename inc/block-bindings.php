<?php
/**
 * Block Bindings API — custom field bindings for CPT meta.
 *
 * Allows blocks to bind directly to post meta values using the
 * WordPress Block Bindings API (WP 6.5+).
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register the block bindings source and post meta fields.
 */
function hoplytics_register_block_bindings(): void
{

    // Register binding source
    register_block_bindings_source('hoplytics/meta', [
        'label' => __('Hoplytics Meta', 'hoplytics'),
        'get_value_callback' => 'hoplytics_block_binding_callback',
        'uses_context' => ['postId', 'postType'],
    ]);

    // Register meta fields for REST / block bindings visibility
    register_post_meta('project', '_related_service_id', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'integer',
        'default' => 0,
        'auth_callback' => fn(): bool => current_user_can('edit_posts'),
    ]);

    register_post_meta('testimonial', '_related_service_id', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'integer',
        'default' => 0,
        'auth_callback' => fn(): bool => current_user_can('edit_posts'),
    ]);

    register_post_meta('career', 'location', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'default' => '',
        'auth_callback' => fn(): bool => current_user_can('edit_posts'),
    ]);

    register_post_meta('career', 'job_type', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'default' => 'Full-time',
        'auth_callback' => fn(): bool => current_user_can('edit_posts'),
    ]);
}
add_action('init', 'hoplytics_register_block_bindings');

/**
 * Callback for the `hoplytics/meta` binding source.
 *
 * @param array    $source_args  Binding source arguments (must include 'key').
 * @param WP_Block $block        The block instance.
 * @return string                 The meta value as a display string.
 */
function hoplytics_block_binding_callback(array $source_args, WP_Block $block): string
{
    $key = $source_args['key'] ?? '';
    if (empty($key)) {
        return '';
    }

    $post_id = $block->context['postId'] ?? get_the_ID();
    if (!$post_id) {
        return '';
    }

    $value = get_post_meta($post_id, $key, true);

    // Special handling: resolve service ID to service title
    if ($key === '_related_service_id' && is_numeric($value) && (int) $value > 0) {
        $service = get_post((int) $value);
        return $service ? $service->post_title : '';
    }

    return (string) $value;
}
