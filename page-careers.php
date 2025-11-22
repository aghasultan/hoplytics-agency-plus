<?php
/**
 * Template Name: Careers Page
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">
        <div class="grid grid-2 items-center mb-16">
            <div>
                <h1><?php esc_html_e('Join the Future of Growth', 'hoplytics'); ?></h1>
                <div class="prose mb-8">
                    <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
                </div>
                <a href="#openings" class="btn btn-primary"><?php esc_html_e('View Openings', 'hoplytics'); ?></a>
            </div>
            <div class="bg-alt p-8 rounded-lg">
                <h3 class="mb-4"><?php esc_html_e('Why Work Here?', 'hoplytics'); ?></h3>
                <ul class="list-disc pl-4 space-y-2">
                    <li><?php esc_html_e('Remote-First Culture', 'hoplytics'); ?></li>
                    <li><?php esc_html_e('Competitive Salary + Profit Share', 'hoplytics'); ?></li>
                    <li><?php esc_html_e('Latest Tech Stack (No legacy WP)', 'hoplytics'); ?></li>
                    <li><?php esc_html_e('Annual Retreats', 'hoplytics'); ?></li>
                </ul>
            </div>
        </div>

        <section id="openings">
            <h2 class="text-center mb-8"><?php esc_html_e('Current Openings', 'hoplytics'); ?></h2>
            <div class="max-w-3xl mx-auto space-y-4">
            <?php
            $jobs = new WP_Query( array(
                'post_type' => 'career',
                'posts_per_page' => -1
            ));

            if ( $jobs->have_posts() ) :
                while ( $jobs->have_posts() ) : $jobs->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="block card hover:border-primary transition-colors">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold m-0 text-primary"><?php the_title(); ?></h3>
                                <?php
                                $loc = get_post_meta( get_the_ID(), 'location', true );
                                $type = get_post_meta( get_the_ID(), 'job_type', true ); // e.g. Full-time
                                ?>
                                <span class="text-sm text-muted"><?php echo $loc ? esc_html($loc) : 'Remote'; ?> &bull; <?php echo $type ? esc_html($type) : 'Full-Time'; ?></span>
                            </div>
                            <span class="btn btn-sm btn-outline"><?php esc_html_e('Apply &rarr;', 'hoplytics'); ?></span>
                        </div>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p class="text-center text-muted">No openings right now. Check back later!</p>';
            endif;
            ?>
            </div>
        </section>

	</main>

<?php
get_footer();
