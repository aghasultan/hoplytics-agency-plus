<?php
/**
 * The header for our theme
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hoplytics' ); ?></a>

        <header id="masthead" class="site-header" role="banner">
            <div class="container header-inner">
                <div class="site-branding">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation" aria-label="Primary">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->

                <div class="header-actions">
                    <a href="#contact" class="btn btn-primary header-cta"><?php esc_html_e( 'Get a Proposal', 'hoplytics' ); ?></a>
                    <button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'hoplytics' ); ?>">
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                        <span class="menu-toggle-bar" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </header>
