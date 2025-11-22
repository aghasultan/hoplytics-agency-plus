<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">
        <header class="page-header text-center mb-12">
            <h1 class="page-title">
                <?php
                if ( is_home() && ! is_front_page() ) {
                    single_post_title();
                } else {
                    esc_html_e( 'Latest Insights', 'hoplytics' );
                }
                ?>
            </h1>
            <p class="text-muted"><?php esc_html_e( 'Strategies and tactics for modern growth.', 'hoplytics' ); ?></p>
        </header>

        <div class="grid grid-3">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;

            echo '<div class="col-span-3 mt-8 flex justify-center">';
            the_posts_navigation();
            echo '</div>';

		else :
            echo '<div class="card col-span-3"><p class="text-center">No posts found.</p></div>';
		endif;
		?>
        </div>

	</main>

<?php
get_footer();
