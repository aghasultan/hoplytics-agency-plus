<?php
/**
 * Template Name: PPC Landing Page
 * Description: A stripped-down template for paid traffic with no navigation.
 *
 * @package Hoplytics
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    <style>
        /* Hide Header/Footer for this template strictly */
        .site-header, .site-footer { display: none !important; }
        .landing-header { padding: 2rem 0; border-bottom: 1px solid var(--color-border); text-align: center; }
    </style>
</head>
<body <?php body_class(); ?>>

<div id="page" class="site">
    <!-- Simplified Header -->
    <header class="landing-header container">
        <a class="site-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url( hoplytics_get_local_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo" width="180">
        </a>
    </header>

    <main id="primary" class="site-main">
        <div class="container section">
            <div class="grid grid-2 items-center">
                <div class="landing-content">
                    <h1>Apply to Work With Us</h1>
                    <p>We only work with 3 new partners per month. Please fill out the form to see if you qualify.</p>
                </div>
                <div class="landing-form card bg-alt">
                    <h2 class="text-center mb-4">Your Strategy Session Awaits</h2>
                    <?php echo do_shortcode('[seo_audit]'); ?>
                </div>
            </div>
        </div>

        <!-- Trust Indicators -->
        <?php get_template_part( 'template-parts/cro/social-proof-bar' ); ?>

    </main>

    <footer class="text-center py-8 text-sm text-muted">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <a href="/privacy">Privacy Policy</a></p>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
