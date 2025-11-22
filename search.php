<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Hoplytics
 */

get_header();
?>

    <div class="container">
        <div class="inner-wrapper">

            <header class="page-header page-header-centered">
                <h1 class="page-title">
                    <?php
                    /* translators: %s: search query. */
                    printf( esc_html__( 'Search Results for: %s', 'hoplytics' ), '<span>' . get_search_query() . '</span>' );
                    ?>
                </h1>
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
