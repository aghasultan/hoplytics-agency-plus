<?php
/**
 * Template Name: Team Page
 *
 * @package Hoplytics
 */

get_header();
?>

        <main id="primary" class="site-main container section">
        <section class="about-hero text-center mb-12">
            <h1>We Are Not a Generalist Agency.</h1>
            <p class="prose max-w-3xl mx-auto">We specialize in high-ticket lead generation for life insurance brokers and financial advisors because generalists get average results. Specialists win—consistently.</p>
        </section>

        <section class="values mb-12">
            <h2 class="text-center mb-4">Our Operating Values</h2>
            <ul class="list-disc max-w-2xl mx-auto">
                <li>Data over Feelings — every decision backed by measurable signals.</li>
                <li>Revenue over Vanity Metrics — no fluff, just booked appointments and closed premiums.</li>
            </ul>
        </section>

        <section class="team-grid">
            <h2 class="text-center mb-8">Meet the Specialists Behind Hoplytics</h2>
            <div class="grid grid-4">
                <?php
                $team_query = new WP_Query( array(
                    'post_type' => 'team_member',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ( $team_query->have_posts() ) :
                    while ( $team_query->have_posts() ) : $team_query->the_post();
                        ?>
                        <div class="team-member card text-center">
                            <div class="avatar-wrapper rounded-full overflow-hidden w-32 h-32 mx-auto mb-4 border-2 border-primary">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('avatar', array('class' => 'w-100 h-100 object-cover'));
                                } else {
                                    echo '<img src="https://via.placeholder.com/200" class="w-100 h-100 object-cover">';
                                }
                                ?>
                            </div>
                            <h3 class="text-lg font-bold mb-1"><?php the_title(); ?></h3>
                            <?php
                            $department = get_the_terms( get_the_ID(), 'department' );
                            if( $department ) {
                                echo '<p class="text-xs text-muted uppercase tracking-wide mb-2">' . esc_html($department[0]->name) . '</p>';
                            }
                            ?>
                            <div class="text-sm"><?php the_excerpt(); ?></div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>

        </main>

<?php
get_footer();
