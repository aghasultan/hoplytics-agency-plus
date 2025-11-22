<?php
/**
 * The template for displaying Project Archives
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">
        <header class="page-header text-center mb-12">
            <h1 class="page-title"><?php esc_html_e('Our Work', 'hoplytics'); ?></h1>
            <p class="text-muted"><?php esc_html_e('Case studies and success stories from our clients.', 'hoplytics'); ?></p>
        </header>

        <!-- Taxonomy Filter (Simple JS implementation would go here) -->
        <div class="filter-bar flex justify-center gap-4 mb-8">
            <a href="<?php echo get_post_type_archive_link('project'); ?>" class="btn btn-sm btn-primary">All</a>
            <?php
            $terms = get_terms( array('taxonomy' => 'industry', 'hide_empty' => true) );
            foreach($terms as $term) {
                echo '<a href="' . get_term_link($term) . '" class="btn btn-sm btn-outline">' . esc_html($term->name) . '</a>';
            }
            ?>
        </div>

        <div class="grid grid-2">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
                // Use custom loop item or card
                ?>
                <article class="card p-0 overflow-hidden">
                    <?php if(has_post_thumbnail()) {
                        echo '<a href="'.get_permalink().'">';
                        the_post_thumbnail('card-large', array('class' => 'w-100 h-64 object-cover'));
                        echo '</a>';
                    } ?>
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="mb-4"><?php the_excerpt(); ?></div>
                        <a href="<?php the_permalink(); ?>" class="text-primary font-bold hover:underline">View Case Study &rarr;</a>
                    </div>
                </article>
                <?php
			endwhile;
            the_posts_navigation();
		else :
            echo '<p class="text-center col-span-3">No projects found.</p>';
		endif;
		?>
        </div>

	</main>

<?php
get_footer();
