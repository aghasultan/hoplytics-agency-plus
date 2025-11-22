<?php
/**
 * Agency Plus Theme Customizer.
 *
 * @package Agency_Plus
 */

/**
 * Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function agency_plus_customize_register( $wp_customize ) {

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'            => '.site-title a',
			'container_inclusive' => false,
			'render_callback'     => 'agency_plus_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'            => '.site-description',
			'container_inclusive' => false,
			'render_callback'     => 'agency_plus_customize_partial_blogdescription',
		) );
	}

	// Load controls.
	require_once trailingslashit( get_template_directory() ) . '/inc/customizer/controls.php';

	// Sanitization.
	require_once trailingslashit( get_template_directory() ) . '/inc/customizer/sanitize.php';

	// Load options.
	require_once trailingslashit( get_template_directory() ) . '/inc/customizer/options/options.php';

	$wp_customize->register_section_type( 'Agency_Plus_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Agency_Plus_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Agency Plus Pro', 'agency-plus' ),
				'pro_text' => esc_html__( 'Buy Pro', 'agency-plus' ),
				'pro_url'  => 'https://ithemer.com/themes/agency-plus-pro/',
				'priority'  => 1,
			)
		)
	);

}
add_action( 'customize_register', 'agency_plus_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function agency_plus_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function agency_plus_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Register customizer controls scripts.
 *
 * @since 2.0.0
 */
function agency_plus_customize_scripts() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'agency-plus-controls', get_template_directory_uri() . '/inc/customizer/js/controls' . $min . '.js', array( 'jquery', 'customize-controls' ), '1.0.3', true );
	wp_enqueue_style( 'agency-plus-controls-style', get_template_directory_uri() . '/inc/customizer/css/controls' . $min . '.css', array(), '1.0.3' );
}

add_action( 'customize_controls_enqueue_scripts', 'agency_plus_customize_scripts', 0 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function agency_plus_customize_preview_js() {
	wp_enqueue_script( 'agency-plus-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'agency_plus_customize_preview_js' );