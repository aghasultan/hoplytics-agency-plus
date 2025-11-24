<?php
/**
 * The template for displaying all single project posts
 *
 * @package Hoplytics
 */

get_header();
?>

	<main id="primary" class="site-main container section">

		<?php
		while ( have_posts() ) :
			the_post();

            // Get Related Service
            $service_id = get_post_meta( get_the_ID(), '_related_service_id', true );
            $tech_stack = get_the_terms( get_the_ID(), 'tech_stack' );
            $industry   = get_the_terms( get_the_ID(), 'industry' );

            // Schema Markup
            $schema = array(
                '@context' => 'https://schema.org',
                '@type'    => 'Article',
                'headline' => get_the_title(),
                'image'    => has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : '',
                'datePublished' => get_the_date('c'),
                'dateModified'  => get_the_modified_date('c'),
                'author'   => array(
                    '@type' => 'Organization',
                    'name'  => get_bloginfo('name'),
                    'url'   => home_url()
                ),
                'publisher' => array(
                    '@type' => 'Organization',
                    'name'  => get_bloginfo('name'),
                    'logo'  => array(
                        '@type' => 'ImageObject',
                        'url'   => hoplytics_get_logo_url()
                    )
                ),
                'articleBody' => wp_strip_all_tags( get_the_content() ),
                'mainEntityOfPage' => array(
                    '@type' => 'WebPage',
                    '@id'   => get_permalink()
                )
            );
		?>
            <script type="application/ld+json">
                <?php echo json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ); ?>
            </script>

            <div class="grid grid-3" style="grid-template-columns: 2fr 1fr;">
                <!-- Main Content -->
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header mb-8">
                        <?php the_title( '<h1 class="entry-title mb-4">', '</h1>' ); ?>
                        <?php if(has_post_thumbnail()) { the_post_thumbnail('full', array('class' => 'rounded-lg shadow-lg mb-8')); } ?>
                    </header>

                    <div class="entry-content prose">
                        <?php the_content(); ?>
                    </div>
                </article>

                <!-- Sidebar: At a Glance -->
                <aside class="project-sidebar sticky top-24 h-fit">
                    <div class="card bg-alt">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2"><?php esc_html_e('At a Glance', 'hoplytics'); ?></h3>

                        <div class="mb-4">
                            <h4 class="text-sm text-muted uppercase"><?php esc_html_e('Client Industry', 'hoplytics'); ?></h4>
                            <?php
                            if ( $industry && ! is_wp_error( $industry ) ) {
                                foreach ( $industry as $term ) {
                                    echo '<span class="badge bg-white border px-2 py-1 text-xs rounded mr-1">' . esc_html( $term->name ) . '</span>';
                                }
                            } else {
                                echo '<span>N/A</span>';
                            }
                            ?>
                        </div>

                        <div class="mb-4">
                            <h4 class="text-sm text-muted uppercase"><?php esc_html_e('Service Provided', 'hoplytics'); ?></h4>
                            <?php
                            if ( $service_id ) {
                                echo '<a href="' . get_permalink( $service_id ) . '" class="font-bold">' . get_the_title( $service_id ) . '</a>';
                            } else {
                                echo '<span>N/A</span>';
                            }
                            ?>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-sm text-muted uppercase"><?php esc_html_e('Tech Stack', 'hoplytics'); ?></h4>
                            <div class="flex flex-wrap gap-2 mt-1">
                            <?php
                            if ( $tech_stack && ! is_wp_error( $tech_stack ) ) {
                                foreach ( $tech_stack as $term ) {
                                    echo '<span class="badge bg-gray-200 text-xs px-2 py-1 rounded">' . esc_html( $term->name ) . '</span>';
                                }
                            }
                            ?>
                            </div>
                        </div>

                        <a href="#contact" class="btn btn-primary w-100 text-center"><?php esc_html_e('Start Similar Project', 'hoplytics'); ?></a>
                    </div>
                </aside>
            </div>

		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
