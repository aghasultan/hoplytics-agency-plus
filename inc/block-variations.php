<?php
/**
 * Block Variations — pre-configured block combos for common agency patterns.
 *
 * @package Hoplytics
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register block variations via the block editor.
 */
function hoplytics_register_block_variations(): void
{
    wp_enqueue_script(
        'hoplytics-block-variations',
        get_template_directory_uri() . '/assets/js/block-variations.js',
        ['wp-blocks', 'wp-dom-ready', 'wp-element'],
        HOPLYTICS_VERSION,
        true
    );
}
add_action('enqueue_block_editor_assets', 'hoplytics_register_block_variations');
