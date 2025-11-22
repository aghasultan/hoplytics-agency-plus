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
        <?php if ( has_custom_logo() ) { the_custom_logo(); } else { echo '<h1 class="site-title">'. get_bloginfo( 'name' ) .'</h1>'; } ?>
    </header>

    <main id="primary" class="site-main">
        <div class="container section">
            <div class="grid grid-2 items-center">
                <div class="landing-content">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
                <div class="landing-form card bg-alt">
                    <h3 class="text-center mb-4"><?php esc_html_e('Claim Offer', 'hoplytics'); ?></h3>
                    <?php echo do_shortcode('[seo_audit]'); // Example hook, or a gravity form ?>
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
