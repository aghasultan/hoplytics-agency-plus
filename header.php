<?php
/**
 * The header for our theme
 *
 * @package Hoplytics
 */

defined('ABSPATH') || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php get_template_part('template-parts/scarcity-bar'); ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text"
            href="#primary"><?php esc_html_e('Skip to content', 'hoplytics'); ?></a>

        <header id="masthead" class="site-header" role="banner">
            <div class="container header-inner">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a class="site-logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <img src="<?php echo esc_url(hoplytics_get_logo_url()); ?>" alt="<?php bloginfo('name'); ?>"
                                class="custom-logo" width="180" height="50">
                        </a>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation"
                    aria-label="<?php esc_attr_e('Primary', 'hoplytics'); ?>">
                    <?php
                    if (has_nav_menu('menu-1')) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id' => 'primary-menu',
                                'container' => false,
                                'fallback_cb' => false,
                            )
                        );
                    } else {
                        // High-End Mega Menu Fallback (State of the Art Demo)
                        ?>
                        <ul id="primary-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="menu-item-has-children">
                                <a href="<?php echo esc_url(home_url('/services/')); ?>">Services</a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo esc_url(home_url('/social-media-marketing/')); ?>">Social
                                            Media Marketing</a></li>
                                    <li><a href="<?php echo esc_url(home_url('/search-engine-marketing/')); ?>">Search
                                            Engine Marketing</a></li>
                                    <li><a href="<?php echo esc_url(home_url('/search-engine-optimization/')); ?>">Search
                                            Engine Optimization</a></li>
                                    <li><a href="<?php echo esc_url(home_url('/content-marketing-services/')); ?>">Content
                                            Marketing</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
                            <li><a href="<?php echo esc_url(home_url('/free-tools/')); ?>">Free Tools</a></li>
                            <li><a href="<?php echo esc_url(home_url('/case-studies/')); ?>">Case Studies</a></li>
                            <li><a href="<?php echo esc_url(home_url('/insights/')); ?>">Insights</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </nav><!-- #site-navigation -->

                <div class="header-actions">
                    <?php
                    $cta_text = get_theme_mod('header_cta_text', __('Get a Proposal', 'hoplytics'));
                    $cta_url = get_theme_mod('header_cta_url', '#contact');
                    if (!empty($cta_text)):
                        ?>
                        <a href="<?php echo esc_url($cta_url); ?>"
                            class="btn btn-primary header-cta"><?php echo esc_html($cta_text); ?></a>
                    <?php endif; ?>

                    <button class="menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false"
                        aria-label="<?php echo esc_attr__('Toggle navigation', 'hoplytics'); ?>">
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </header>