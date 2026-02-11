<?php
/**
 * Hoplytics Theme Customizer.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hoplytics_customize_register(WP_Customize_Manager $wp_customize): void
{
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector' => '.site-title a',
                'render_callback' => 'hoplytics_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector' => '.site-description',
                'render_callback' => 'hoplytics_customize_partial_blogdescription',
            )
        );
    }

    // ==============================================================
    // Style Kits
    // ==============================================================
    $wp_customize->add_section('hoplytics_style_kits', array(
        'title' => __('Style Kits', 'hoplytics'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hoplytics_style_kit', array(
        'default' => StyleKit::TechFuturist->value,
        'transport' => 'refresh',
        'sanitize_callback' => StyleKit::sanitize(...),
    ));

    $wp_customize->add_control('hoplytics_style_kit', array(
        'label' => __('Choose Style Kit', 'hoplytics'),
        'section' => 'hoplytics_style_kits',
        'type' => 'select',
        'choices' => StyleKit::choices(),
    ));

    // ==============================================================
    // Header Options
    // ==============================================================
    $wp_customize->add_section('hoplytics_header_options', array(
        'title' => __('Header Options', 'hoplytics'),
        'priority' => 35,
    ));

    // Header CTA Text
    $wp_customize->add_setting('header_cta_text', array(
        'default' => 'Get a Proposal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_cta_text', array(
        'label' => __('Header Button Text', 'hoplytics'),
        'section' => 'hoplytics_header_options',
        'type' => 'text',
    ));

    // Header CTA URL
    $wp_customize->add_setting('header_cta_url', array(
        'default' => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_cta_url', array(
        'label' => __('Header Button URL', 'hoplytics'),
        'section' => 'hoplytics_header_options',
        'type' => 'text',
    ));

    // ==============================================================
    // Front Page Hero
    // ==============================================================
    $wp_customize->add_section('hoplytics_hero_section', array(
        'title' => __('Front Page Hero', 'hoplytics'),
        'priority' => 40,
    ));

    // Headline
    $wp_customize->add_setting('hero_headline', array(
        'default' => 'Turn Your Traffic Into Revenue',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_headline', array(
        'label' => __('Headline', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'text',
    ));

    // Subheadline
    $wp_customize->add_setting('hero_subheadline', array(
        'default' => 'We are the growth agency that focuses on what matters: ROI, ROAS, and Bottom Line.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_subheadline', array(
        'label' => __('Subheadline', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'textarea',
    ));

    // Button 1
    $wp_customize->add_setting('hero_btn_1_text', array(
        'default' => 'Get Free Audit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_btn_1_text', array(
        'label' => __('Primary Button Text', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_btn_1_url', array(
        'default' => '#audit',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_btn_1_url', array(
        'label' => __('Primary Button URL', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'text',
    ));

    // Button 2
    $wp_customize->add_setting('hero_btn_2_text', array(
        'default' => 'View Work',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_btn_2_text', array(
        'label' => __('Secondary Button Text', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_btn_2_url', array(
        'default' => '#portfolio',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_btn_2_url', array(
        'label' => __('Secondary Button URL', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'type' => 'text',
    ));

    // Visual/Image
    $wp_customize->add_setting('hero_visual_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_visual_image', array(
        'label' => __('Hero Visual Image (Optional)', 'hoplytics'),
        'section' => 'hoplytics_hero_section',
        'mime_type' => 'image',
    )));

    // ==============================================================
    // Front Page "Trusted By" Section
    // ==============================================================
    $wp_customize->add_section('hoplytics_trusted_by', array(
        'title' => __('Trusted By Section', 'hoplytics'),
        'priority' => 45,
    ));

    $wp_customize->add_setting('trusted_by_title', array(
        'default' => 'Trusted by High-Growth Companies',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('trusted_by_title', array(
        'label' => __('Section Title', 'hoplytics'),
        'section' => 'hoplytics_trusted_by',
        'type' => 'text',
    ));

    // 4 Slots for Logo Images (Simple implementation)
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("trusted_by_logo_$i", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "trusted_by_logo_$i", array(
            'label' => sprintf(__('Logo %d', 'hoplytics'), $i),
            'section' => 'hoplytics_trusted_by',
            'mime_type' => 'image',
        )));
    }

    // ==============================================================
    // Footer Options
    // ==============================================================
    $wp_customize->add_section('hoplytics_footer_options', array(
        'title' => __('Footer Options', 'hoplytics'),
        'priority' => 120,
    ));

    // Tagline
    $wp_customize->add_setting('footer_tagline', array(
        'default' => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_tagline', array(
        'label' => __('Footer Tagline', 'hoplytics'),
        'section' => 'hoplytics_footer_options',
        'type' => 'textarea',
    ));

    // Contact Info
    $wp_customize->add_setting('footer_contact_email', array(
        'default' => 'hello@hoplytics.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('footer_contact_email', array(
        'label' => __('Contact Email', 'hoplytics'),
        'section' => 'hoplytics_footer_options',
        'type' => 'email',
    ));

    $wp_customize->add_setting('footer_contact_phone', array(
        'default' => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_contact_phone', array(
        'label' => __('Contact Phone', 'hoplytics'),
        'section' => 'hoplytics_footer_options',
        'type' => 'text',
    ));
}
add_action('customize_register', 'hoplytics_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hoplytics_customize_partial_blogname(): void
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hoplytics_customize_partial_blogdescription(): void
{
    bloginfo('description');
}

// hoplytics_sanitize_select() removed — replaced by StyleKit::sanitize() enum method.
