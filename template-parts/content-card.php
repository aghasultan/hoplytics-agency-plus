<article id="post-<?php the_ID(); ?>" <?php post_class('card h-full flex flex-col'); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumbnail mb-4 rounded overflow-hidden">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'card-small', array( 'class' => 'w-100 h-auto object-cover' ) ); ?>
		</a>
	</div>
	<?php endif; ?>

	<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title text-2xl font-bold">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title text-xl font-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta text-sm text-muted mb-2">
				<?php echo get_the_date(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content flex-grow">
		<?php
		the_excerpt();
		?>
	</div><!-- .entry-content -->

    <?php if ( ! is_singular() ) : ?>
	<footer class="entry-footer mt-4 pt-4 border-t border-gray-200">
        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm w-100 text-center">
            <?php esc_html_e('Read More', 'hoplytics'); ?>
        </a>
	</footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
