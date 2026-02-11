<?php
/**
 * Mobile Navigation Block — Interactivity API.
 *
 * Replaces the legacy main.js IIFE with reactive directives.
 *
 * @package Hoplytics
 */

declare(strict_types=1);
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'mobile-nav-toggle-wrapper']); ?>
    data-wp-interactive="hoplytics/mobile-nav"
    data-wp-context='{"isOpen": false}'
    >
    <button class="menu-toggle" type="button" aria-controls="site-navigation"
        data-wp-bind--aria-expanded="context.isOpen" data-wp-on--click="actions.toggle"
        aria-label="<?php echo esc_attr__('Toggle navigation', 'hoplytics'); ?>">
        <span class="menu-toggle-bar" aria-hidden="true"></span>
        <span class="menu-toggle-bar" aria-hidden="true"></span>
        <span class="menu-toggle-bar" aria-hidden="true"></span>
    </button>
</div>