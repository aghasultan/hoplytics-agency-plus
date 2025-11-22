<?php
/**
 * Hoplytics Theme Customizer.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hoplytics_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'hoplytics_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'hoplytics_customize_partial_blogdescription',
			)
		);
	}

    // Style Kits Section
    $wp_customize->add_section( 'hoplytics_style_kits', array(
        'title'    => __( 'Style Kits', 'hoplytics' ),
        'priority' => 30,
    ) );

    // Style Kit Setting
    $wp_customize->add_setting( 'hoplytics_style_kit', array(
        'default'   => 'tech-futurist',
        'transport' => 'refresh',
        'sanitize_callback' => 'hoplytics_sanitize_select',
    ) );

    // Style Kit Control
    $wp_customize->add_control( 'hoplytics_style_kit', array(
        'label'      => __( 'Choose Style Kit', 'hoplytics' ),
        'section'    => 'hoplytics_style_kits',
        'type'       => 'select',
        'choices'    => array(
            'tech-futurist'       => __( 'Tech-Futurist (Dark, Neon)', 'hoplytics' ),
            'corporate-stabilizer'=> __( 'Corporate-Stabilizer (Clean, Muted)', 'hoplytics' ),
            'creative-disruptor'  => __( 'Creative-Disruptor (Bold, Kinetic)', 'hoplytics' ),
        ),
    ) );
}
add_action( 'customize_register', 'hoplytics_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hoplytics_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hoplytics_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Sanitize select choices
 */
function hoplytics_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
