<?php
/**
 * Custom Block Styles — register additional style variants for core blocks.
 *
 * These appear in the block editor sidebar under "Styles" tab.
 *
 * @package Hoplytics
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

function hoplytics_register_block_styles(): void
{

    // --- Buttons ---

    register_block_style('core/button', [
        'name' => 'gradient',
        'label' => __('Gradient', 'hoplytics'),
    ]);

    register_block_style('core/button', [
        'name' => 'glow',
        'label' => __('Glow', 'hoplytics'),
    ]);

    register_block_style('core/button', [
        'name' => 'pill',
        'label' => __('Pill', 'hoplytics'),
    ]);

    // --- Group (Cards) ---

    register_block_style('core/group', [
        'name' => 'card',
        'label' => __('Card', 'hoplytics'),
    ]);

    register_block_style('core/group', [
        'name' => 'glass',
        'label' => __('Glassmorphism', 'hoplytics'),
    ]);

    register_block_style('core/group', [
        'name' => 'bordered',
        'label' => __('Bordered', 'hoplytics'),
    ]);

    register_block_style('core/group', [
        'name' => 'elevated',
        'label' => __('Elevated', 'hoplytics'),
    ]);

    // --- Image ---

    register_block_style('core/image', [
        'name' => 'rounded-shadow',
        'label' => __('Rounded Shadow', 'hoplytics'),
    ]);

    register_block_style('core/image', [
        'name' => 'frame',
        'label' => __('Frame', 'hoplytics'),
    ]);

    // --- Quote ---

    register_block_style('core/quote', [
        'name' => 'testimonial',
        'label' => __('Testimonial', 'hoplytics'),
    ]);

    register_block_style('core/quote', [
        'name' => 'highlight',
        'label' => __('Highlight', 'hoplytics'),
    ]);

    // --- Columns ---

    register_block_style('core/columns', [
        'name' => 'card-grid',
        'label' => __('Card Grid', 'hoplytics'),
    ]);

    // --- Separator ---

    register_block_style('core/separator', [
        'name' => 'gradient-line',
        'label' => __('Gradient Line', 'hoplytics'),
    ]);

    // --- Cover ---

    register_block_style('core/cover', [
        'name' => 'hero',
        'label' => __('Hero Banner', 'hoplytics'),
    ]);

    register_block_style('core/cover', [
        'name' => 'cta-banner',
        'label' => __('CTA Banner', 'hoplytics'),
    ]);
}
add_action('init', 'hoplytics_register_block_styles');

/**
 * Enqueue editor CSS for block styles preview.
 */
function hoplytics_editor_block_styles(): void
{
    wp_enqueue_style(
        'hoplytics-block-styles',
        get_template_directory_uri() . '/assets/css/block-styles.css',
        [],
        HOPLYTICS_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'hoplytics_editor_block_styles');
