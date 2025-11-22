<?php
declare(strict_types=1);
/**
 * Hoplytics functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hoplytics
 */

if ( ! function_exists( 'hoplytics_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function hoplytics_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'hoplytics' ),
			'social' => esc_html__( 'Social', 'hoplytics' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'hoplytics_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		/**
		 * Add support for core custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add woocommerce support, lightbox and thumbnail slider.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		$gallery_zoom = hoplytics_get_option( 'enable_gallery_zoom' );

		if ( 1 == $gallery_zoom ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
	}
endif;
add_action( 'after_setup_theme', 'hoplytics_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
function hoplytics_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hoplytics_content_width', 800 );
}

add_action( 'after_setup_theme', 'hoplytics_content_width', 0 );

/**
 * Register widget area.
 */
function hoplytics_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hoplytics' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hoplytics' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i = 1; $i <= 4; $i ++ ) {
		register_sidebar( array(
			/* translators: 1: Widget number. */
			'name'          => sprintf( esc_html__( 'Footer %d', 'hoplytics' ), $i ),
			'id'            => 'footer-' . $i,
			'before_widget' => '<div id="%1$s" class="widget footer-widgets %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}

add_action( 'widgets_init', 'hoplytics_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function hoplytics_scripts() {

	// Fonts: Inter (Google Fonts)
	wp_enqueue_style( 'hoplytics-fonts-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap', array(), null );

	// Main Stylesheet
	wp_enqueue_style( 'hoplytics-style', get_stylesheet_uri() );

    // Dark Mode Styles
    wp_enqueue_style( 'hoplytics-dark-mode', get_template_directory_uri() . '/assets/css/dark-mode.css', array(), '1.0.0' );

	// Main JS (handles mobile menu)
	wp_enqueue_script( 'hoplytics-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );

	// Three.js (CDN)
    wp_enqueue_script( 'three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), '0.128.0', true );

    // Immersive Scripts
    wp_enqueue_script( 'hoplytics-three-hero', get_template_directory_uri() . '/assets/js/three-hero.js', array('three-js'), '1.0.0', true );
    wp_enqueue_script( 'hoplytics-cursor', get_template_directory_uri() . '/assets/js/cursor.js', array(), '1.0.0', true );
    wp_enqueue_script( 'hoplytics-scroll-effects', get_template_directory_uri() . '/assets/js/scroll-effects.js', array(), '1.0.0', true );

    // Dynamic Features
    wp_enqueue_script( 'hoplytics-dynamic-mode', get_template_directory_uri() . '/assets/js/dynamic-mode.js', array(), '1.0.0', true );
    wp_enqueue_script( 'hoplytics-instant-load', get_template_directory_uri() . '/assets/js/instant-load.js', array(), '1.0.0', true );
    wp_enqueue_script( 'hoplytics-dev-tools', get_template_directory_uri() . '/assets/js/dev-tools.js', array(), '1.0.0', true );

	// Keep Skip Link Focus Fix for accessibility
	wp_enqueue_script( 'hoplytics-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hoplytics_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Customizer core functions.
 */
require get_template_directory() . '/inc/customizer/core.php';

/**
 * Helper functions.
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Health Check.
 */
require get_template_directory() . '/inc/health-check.php';

/**
 * TGM Plugin activation.
 */
require_once trailingslashit( get_template_directory() ) . '/inc/class-tgm-plugin-activation.php';

// Load woo-commerce overrides.
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woo-overrides.php';
}

/**
 * Theme Info functions.
 */
require get_template_directory() . '/inc/theme-info.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
