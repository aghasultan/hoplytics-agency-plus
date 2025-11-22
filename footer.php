<?php
/**
 * The template for displaying the footer
 *
 * @package Hoplytics
 */
?>

	<footer id="colophon" class="site-footer">
        <div class="container">
            <div class="grid grid-4">
                <div class="footer-brand">
                    <h3 class="footer-brand-title"><?php bloginfo( 'name' ); ?></h3>
                    <p class="text-sm text-muted"><?php bloginfo( 'description' ); ?></p>
                </div>

                <div class="footer-links">
                    <h4><?php esc_html_e('Company', 'hoplytics'); ?></h4>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        )
                    );
                    ?>
                </div>

                <div class="footer-services">
                    <h4><?php esc_html_e('Services', 'hoplytics'); ?></h4>
                    <ul>
                        <!-- Dynamic list of services could go here -->
                        <li><a href="/services/seo">SEO & Content</a></li>
                        <li><a href="/services/paid-media">Paid Media</a></li>
                        <li><a href="/services/cro">CRO & Analytics</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4><?php esc_html_e('Contact', 'hoplytics'); ?></h4>
                    <p>hello@hoplytics.com</p>
                    <p>+1 (555) 123-4567</p>
                </div>
            </div>

            <div class="site-info text-center mt-8 pt-8 border-t border-gray-700 text-sm text-muted">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'hoplytics' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'hoplytics' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
                <?php
                // White label footer is handled by filter, but standard credit here as fallback
                printf( esc_html__( 'Theme: %1$s by %2$s.', 'hoplytics' ), 'Hoplytics', '<a href="https://hoplytics.com">Hoplytics Team</a>' );
                ?>
            </div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
