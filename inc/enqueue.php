<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

/**
 * Enqueue scripts and styles.
 */
function hoplytics_scripts() {
    // Google Fonts (Inter, Orbitron, Rajdhani, Space Grotesk, DM Sans)
    wp_enqueue_style( 'hoplytics-google-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Inter:wght@400;600;700&family=Orbitron:wght@700&family=Rajdhani:wght@400;600&family=Space+Grotesk:wght@400;700&display=swap', array(), null );

    // Main Theme Styles (CSS Variables + Layout)
    wp_enqueue_style( 'hoplytics-variables', get_template_directory_uri() . '/assets/css/variables.css', array(), HOPLYTICS_VERSION );
    wp_enqueue_style( 'hoplytics-main', get_template_directory_uri() . '/assets/css/main.css', array('hoplytics-variables'), HOPLYTICS_VERSION );

    // Main Theme Script (Mobile Menu, Interactions)
        wp_enqueue_script( 'hoplytics-main', get_template_directory_uri() . '/assets/js/main.js', array(), HOPLYTICS_VERSION, true );

    // Conditional Loading: Chart.js for ROI Calculator or specific visualizations
    // We only load this if the ROI calculator is on the page or if we are on a page using charts
    wp_register_script( 'chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), '4.4.0', true );

    $should_load_chart = is_page_template( 'page-landing.php' ) || is_singular( 'project' ) || is_front_page();

    $post = get_post();

    if ( $post instanceof WP_Post ) {
        if ( has_shortcode( $post->post_content, 'roi_calculator' ) || has_block( 'hoplytics/roi-calculator', $post ) ) {
            $should_load_chart = true;
        }
    }

    if ( $should_load_chart ) {
        wp_enqueue_script( 'chart-js' );
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hoplytics_scripts' );

/**
 * Preload critical assets.
 */
function hoplytics_preload_fonts() {
    // Preload key fonts or critical CSS if needed
}
add_action( 'wp_head', 'hoplytics_preload_fonts', 1 );
