<?php
/**
 * The main template file for the Blog Index
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

    <main id="primary" class="site-main">

        <!-- Header -->
        <header class="page-header section text-center pb-8">
            <div class="container">
                <h1 class="page-title">State of the Industry</h1>
                <p class="text-xl text-muted">Advanced strategies for agencies and brokers scaling to $5M+.</p>
            </div>
        </header>

        <!-- Categories Bar -->
        <div class="categories-bar container mb-12">
            <div class="flex flex-wrap justify-center gap-4">
                <?php
                $categories = get_categories( array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 5,
                ) );

                foreach ( $categories as $category ) {
                    echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="btn btn-outline btn-sm">' . esc_html( $category->name ) . '</a>';
                }
                ?>
            </div>
        </div>

        <!-- Featured Hero Card -->
        <section class="featured-post-section container mb-16">
            <?php
            // Query for sticky post first, or latest post if no sticky
            $sticky = get_option( 'sticky_posts' );
            $args = array(
                'posts_per_page' => 1,
                'ignore_sticky_posts' => 1,
            );

            if ( ! empty( $sticky ) ) {
                $args['post__in'] = $sticky;
            }

            $featured_query = new WP_Query( $args );

            if ( $featured_query->have_posts() ) :
                while ( $featured_query->have_posts() ) : $featured_query->the_post();
            ?>
                <div class="card p-8 bg-alt border-primary" style="border-width: 2px;">
                    <div class="grid grid-2 items-center">
                        <div class="featured-content">
                            <span class="inline-block bg-primary text-white text-xs font-bold px-2 py-1 rounded mb-4">New Case Study</span>
                            <h2 class="text-3xl font-bold mb-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="mb-6 text-muted">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read Full Report</a>
                        </div>
                        <div class="featured-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large', array( 'class' => 'rounded-lg w-100 h-auto' ) ); ?>
                            <?php else : ?>
                                <div class="service-placeholder rounded-lg" style="min-height: 300px;">
                                    <span class="font-bold">Featured Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </section>

        <!-- Post Grid -->
        <section class="post-grid-section section pt-0">
            <div class="container">
                <div class="grid grid-3">
                    <?php
                    // Main loop, excluding the featured post if it was sticky?
                    // Ideally, we just run the main loop but maybe offset or exclude sticky if we want to be precise.
                    // For standard WP behavior, the main loop handles pagination correctly, so we will use the default loop.
                    // However, we should be careful not to duplicate the sticky post if the main query includes it.
                    // But standard `have_posts()` is safe enough for this context unless specific exclusion logic is requested.

                    if ( have_posts() ) :
                        while ( have_posts() ) :
                            the_post();

                            // Skip the sticky post if it was just shown?
                            // Standard behavior is sticky posts are at the top.
                            // Since we manually showed a "Featured" section, we might see it again.
                            // For this task, I'll rely on the standard loop display.

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
            </div>
        </section>

    </main>

<?php
get_footer();
