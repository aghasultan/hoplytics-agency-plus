<?php
/**
 * The template for displaying Service Archives
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">
        <header class="page-header text-center mb-12">
            <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
            <div class="archive-description max-w-2xl mx-auto text-muted">
                <?php the_archive_description(); ?>
            </div>
        </header>

        <div class="grid grid-3">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;

            the_posts_navigation();

		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
        </div>

	</main>

<?php
get_footer();
