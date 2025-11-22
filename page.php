<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Agency_Plus
 */

get_header();
?>

    <div class="container">
        <!-- Standard Page Layout: No Sidebar, Centered Content -->
        <div class="inner-wrapper inner-wrapper-centered">

            <div id="primary" class="content-area w-full">
                <main id="main" class="site-main">

                    <?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content', 'page' );

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->

        </div><!-- .inner-wrapper -->
    </div><!-- .container -->

<?php
get_footer();
