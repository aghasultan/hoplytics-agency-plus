<?php
/**
 * The front page template file
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main">

        <!-- Hero Section -->
        <section class="hero-section section">
            <div class="container">
                <div class="grid grid-2 items-center">
                    <div class="hero-content">
                        <h1><?php echo esc_html( get_theme_mod('hero_headline', 'Turn Your Traffic Into Revenue') ); ?></h1>
                        <p class="text-lg text-muted"><?php echo esc_html( get_theme_mod('hero_subheadline', 'We are the growth agency that focuses on what matters: ROI, ROAS, and Bottom Line.') ); ?></p>
                        <div class="flex gap-4 mt-4 flex-wrap">
                            <?php
                            $btn1_text = get_theme_mod('hero_btn_1_text', 'Get Free Audit');
                            $btn1_url = get_theme_mod('hero_btn_1_url', '#audit');
                            if ( $btn1_text ) : ?>
                                <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-primary"><?php echo esc_html($btn1_text); ?></a>
                            <?php endif; ?>

                            <?php
                            $btn2_text = get_theme_mod('hero_btn_2_text', 'View Work');
                            $btn2_url = get_theme_mod('hero_btn_2_url', '#portfolio');
                            if ( $btn2_text ) : ?>
                                <a href="<?php echo esc_url($btn2_url); ?>" class="btn btn-outline"><?php echo esc_html($btn2_text); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <?php
                        $hero_image_id = get_theme_mod('hero_visual_image');
                        if ( $hero_image_id ) {
                            echo wp_get_attachment_image( $hero_image_id, 'large', false, array('class' => 'rounded shadow-lg') );
                        } else {
                            // High-Converting Hero Lead Form Component
                            get_template_part( 'template-parts/components/hero-lead-form' );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Social Proof Bar -->
        <?php get_template_part( 'template-parts/cro/social-proof-bar' ); ?>

        <!-- Pain-Agitate-Solution -->
        <?php get_template_part( 'template-parts/cro/pain-agitate-solution' ); ?>

        <!-- Services Grid -->
        <section id="services" class="section">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e( 'Our Expertise', 'hoplytics' ); ?></h2>
                <div class="grid grid-3">
                    <?php
                    $services = new WP_Query( array(
                        'post_type' => 'service',
                        'posts_per_page' => 3,
                    ));

                    if ( $services->have_posts() ) :
                        while ( $services->have_posts() ) : $services->the_post();
                            get_template_part( 'template-parts/content', 'card' );
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback for empty state
                        echo '<div class="card"><h3 class="text-center">Services Coming Soon</h3></div>';
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Comparison Table -->
        <?php get_template_part( 'template-parts/cro/comparison-table' ); ?>

        <!-- ROI Calculator -->
        <section id="roi-calc" class="section bg-alt">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e( 'Calculate Your Potential', 'hoplytics' ); ?></h2>
                <?php echo do_shortcode( '[roi_calculator]' ); ?>
            </div>
        </section>

        <!-- Lead Magnet -->
        <section class="section">
            <div class="container">
                <?php
                get_template_part( 'template-parts/cro/lead-magnet-gate', null, array(
                    'title' => 'The 2024 Growth Playbook',
                    'button_text' => 'Get Instant Access'
                ));
                ?>
            </div>
        </section>

	</main><!-- #main -->

<?php
get_footer();
