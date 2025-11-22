<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hoplytics
 */

get_header();
?>

    <div class="container">
        <div class="inner-wrapper">

            <header class="page-header page-header-centered">
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                <?php else : ?>
                    <h1 class="page-title"><?php esc_html_e( 'Latest Insights', 'hoplytics' ); ?></h1>
                <?php endif; ?>
                <p class="page-subtitle">Thoughts on digital marketing, SEO, and growth.</p>
            </header>

            <!-- Grid Layout for Posts -->
            <div id="primary" class="content-area w-full">
                <main id="main" class="site-main">

                    <?php if ( have_posts() ) : ?>
                        <div class="post-grid">
                            <?php
                            /* Start the Loop */
                            while ( have_posts() ) :
                                the_post();
                                get_template_part( 'template-parts/content', 'card' );
                            endwhile;
                            ?>
                        </div><!-- .post-grid -->

                        <?php
                        the_posts_pagination( array(
                            'prev_text' => '&larr; Previous',
                            'next_text' => 'Next &rarr;',
                        ) );

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->

        </div><!-- .inner-wrapper -->
    </div><!-- .container -->

<?php
get_footer();
