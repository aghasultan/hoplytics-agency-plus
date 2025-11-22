<?php
/**
 * Template part for displaying posts in a grid/card layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hoplytics
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card post-card'); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="post-card-thumbnail-link">
            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'post-card-image' ) ); ?>
        </a>
    <?php else : ?>
        <a href="<?php the_permalink(); ?>" class="post-card-thumbnail-link no-image">
            <span>No Image</span>
        </a>
    <?php endif; ?>

    <div class="post-card-content">
        <div class="entry-meta">
            <?php echo get_the_date(); ?>
        </div>

        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>

        <div class="entry-summary">
            <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
        </div>

        <div class="post-card-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-link">Read more &rarr;</a>
        </div>
    </div>
</article>
