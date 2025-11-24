<?php
/**
 * Template Part: Testimonial Grid
 * Displays 3 latest testimonials in a grid.
 */

$testimonials = new WP_Query( array(
    'post_type'      => 'testimonial',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
));

if ( $testimonials->have_posts() ) : ?>
    <div class="testimonial-grid-wrapper container my-12">
        <div class="testimonial-grid grid grid-3 gap-8">
            <?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
                <div class="testimonial-card card p-6 border rounded-lg shadow-sm h-full flex flex-col relative bg-white">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="testimonial-image mb-4">
                            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded-full w-16 h-16 object-cover' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="testimonial-content italic text-muted mb-4 flex-grow">
                        "<?php echo wp_strip_all_tags( get_the_content() ); ?>"
                    </div>

                    <div class="testimonial-author mt-auto">
                        <h4 class="text-sm font-bold uppercase tracking-wider mb-0 text-primary">
                            <?php the_title(); ?>
                        </h4>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
