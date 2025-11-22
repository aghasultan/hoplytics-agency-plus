<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Agency_Plus
 */

get_header();
?>

    <div class="container">
        <div class="inner-wrapper">

            <header class="page-header page-header-centered">
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
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
