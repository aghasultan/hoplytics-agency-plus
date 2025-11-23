<?php
/**
 * The template for displaying the footer
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;
?>

	<footer id="colophon" class="site-footer">
        <div class="container">
            <div class="grid grid-4">
                <div class="footer-brand">
                    <?php
                    if ( has_custom_logo() ) {
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        if ( is_array( $logo ) ) {
                            echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="footer-logo-link">';
                            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="footer-logo" width="150" style="margin-bottom: 1rem;">';
                            echo '</a>';
                        }
                    } else {
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link">
                            <img src="<?php echo esc_url( hoplytics_get_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo" width="150" style="margin-bottom: 1rem;">
                        </a>
                        <?php
                    }
                    ?>
                    <p class="text-sm text-muted"><?php echo esc_html( get_theme_mod('footer_tagline', get_bloginfo( 'description' )) ); ?></p>
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
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </div>

                <div class="footer-services">
                    <h4><?php esc_html_e('Services', 'hoplytics'); ?></h4>
                    <?php
                    if ( has_nav_menu( 'footer-services' ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-services',
                                'menu_id'        => 'footer-services-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            )
                        );
                    } else {
                         // Default static fallback until they set a menu
                        ?>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'SEO & Content', 'hoplytics' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Paid Media', 'hoplytics' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'CRO & Analytics', 'hoplytics' ); ?></a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <div class="footer-contact">
                    <h4><?php esc_html_e('Contact', 'hoplytics'); ?></h4>
                    <?php
                    $email = get_theme_mod('footer_contact_email', 'hello@hoplytics.com');
                    $phone = get_theme_mod('footer_contact_phone', '+1 (555) 123-4567');
                    ?>
                    <?php if($email): ?><p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html( $email ); ?></a></p><?php endif; ?>
                    <?php if($phone): ?><p><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html( $phone ); ?></a></p><?php endif; ?>
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
