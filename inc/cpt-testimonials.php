<?php
/**
 * Testimonial Custom Post Type
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

/**
 * Register Testimonials CPT
 */
function hoplytics_register_testimonial_cpt() {
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name' => __( 'Testimonials', 'hoplytics' ),
            'singular_name' => __( 'Testimonial', 'hoplytics' ),
            'add_new_item' => __( 'Add Testimonial', 'hoplytics' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array( 'title', 'editor', 'thumbnail' ), // Title = Client Name, Editor = Quote
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'hoplytics_register_testimonial_cpt' );
