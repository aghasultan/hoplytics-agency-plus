<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Agency_Plus
 */

get_header();
?>

    <div class="container">
        <div class="inner-wrapper has-sidebar">

            <!-- Main Content Column -->
            <div id="primary" class="content-area">
                <main id="main" class="site-main">

                    <?php
                    while ( have_posts() ) :
                        the_post();

                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <!-- Post Header -->
                            <header class="entry-header single-post-header">
                                <div class="entry-meta single-post-meta">
                                    <?php echo get_the_date(); ?> &middot; <?php the_category(', '); ?>
                                </div>
                                <?php the_title( '<h1 class="entry-title single-post-title">', '</h1>' ); ?>

                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="post-thumbnail single-post-thumbnail">
                                        <?php the_post_thumbnail( 'full' ); ?>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <!-- Post Content -->
                            <div class="entry-content single-entry-content">
                                <?php
                                the_content();

                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'agency-plus' ),
                                    'after'  => '</div>',
                                ) );
                                ?>
                            </div>

                            <!-- Post Footer -->
                            <footer class="entry-footer single-post-footer">
                                <?php
                                the_tags( '<div class="tags-links"><span style="font-weight:600;">Tags:</span> ', ', ', '</div>' );
                                ?>

                                <!-- Post Navigation -->
                                <?php
                                the_post_navigation( array(
                                    'prev_text' => '<span class="nav-subtitle">Previous:</span> <span class="nav-title">%title</span>',
                                    'next_text' => '<span class="nav-subtitle nav-next">Next:</span> <span class="nav-title">%title</span>',
                                ) );
                                ?>
                            </footer>

                        </article>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->

            <!-- Sidebar Column -->
            <aside id="secondary" class="widget-area">
                <?php get_sidebar(); ?>
            </aside><!-- #secondary -->

        </div><!-- .inner-wrapper -->
    </div><!-- .container -->

<?php
get_footer();
