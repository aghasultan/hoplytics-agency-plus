<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Agency_Plus
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5FRMVNKHB0"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-5FRMVNKHB0');
    </script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'agency-plus' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container flex items-center justify-between h-full">
            <!-- Branding -->
			<div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
				    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php endif; ?>
			</div>

            <!-- Mobile Menu Toggle -->
            <button id="menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'agency-plus' ); ?></span>
            </button>

            <!-- Navigation -->
			<nav id="site-navigation" class="main-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
				) );
				?>
			</nav>

            <!-- Desktop CTA (Hidden on mobile via CSS if needed, or part of the menu) -->
            <div class="header-actions hidden-mobile">
                <?php
                // If WooCommerce cart is needed, we can add it back here cleanly.
                if ( class_exists( 'WooCommerce' ) && agency_plus_get_option( 'show_cart_icon' ) ) {
                    $count = WC()->cart->get_cart_contents_count();
                    if ( $count > 0 ) {
                        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="cart-link">Cart (' . esc_html( $count ) . ')</a>';
                    }
                }
                ?>
                 <a href="/contact" class="btn btn-primary btn-sm" style="margin-left: 1rem;">Get Started</a>
            </div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
<?php
// Restored Logic: Open container for inner pages to prevent full-width breakdown
// But skip for front page since it handles its own sections.
if ( ! is_front_page() && ! is_page_template( 'elementor_header_footer' ) && ! is_page_template( 'templates/skeleton.php' ) ) { ?>
    <div class="container">
        <div class="inner-wrapper">
	<?php
}
