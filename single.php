<?php
/**
 * The template for displaying all single posts
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">

        <div class="inner-wrapper-centered">
		<?php
		while ( have_posts() ) :
			the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-8 text-center">
                    <?php the_title( '<h1 class="entry-title mb-4 text-4xl font-bold">', '</h1>' ); ?>
                    <div class="entry-meta text-muted">
                        <?php echo get_the_date(); ?> &bull; <?php the_author(); ?>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail mb-8 rounded-lg overflow-hidden shadow-lg">
                    <?php the_post_thumbnail( 'full', array( 'class' => 'w-100 h-auto' ) ); ?>
                </div>
                <?php endif; ?>

                <div class="entry-content prose max-w-none">
                    <?php
                    the_content();

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hoplytics' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

                <footer class="entry-footer mt-12 pt-8 border-t border-gray-200">
                    <?php
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( esc_html__( ', ', 'hoplytics' ) );
                    if ( $categories_list ) {
                        /* translators: 1: list of categories. */
                        printf( '<span class="cat-links block mb-2">' . esc_html__( 'Posted in %1$s', 'hoplytics' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }

                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'hoplytics' ) );
                    if ( $tags_list ) {
                        /* translators: 1: list of tags. */
                        printf( '<span class="tags-links block">' . esc_html__( 'Tagged %1$s', 'hoplytics' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

            // Navigation
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'hoplytics' ) . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'hoplytics' ) . '</span> <span class="nav-title">%title</span>',
                )
            );

		endwhile; // End of the loop.
		?>
        </div>

	</main><!-- #main -->

<?php
get_footer();
