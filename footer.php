<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Agency_Plus
 */

?>
<?php
// Restored Logic: Close container if opened in header (inner pages)
if ( ! is_front_page() && ! is_page_template( 'elementor_header_footer' ) && ! is_page_template( 'templates/skeleton.php' ) ) { ?>
    </div><!-- .inner-wrapper -->
    </div><!-- .container -->
	<?php
} ?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <!-- New Footer Layout -->
        <div class="grid grid-3" style="margin-bottom: 3rem; text-align: left;">
            <!-- Brand Column -->
            <div>
                <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Hoplytics</h3>
                <p style="color: #94a3b8; line-height: 1.6;">Modern digital marketing for forward-thinking agencies. We help you scale with confidence.</p>
            </div>

            <!-- Links Column -->
            <div>
                <h4 style="color: white; margin-bottom: 1rem;">Company</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="/about">About Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#services">Services</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="/blog">Blog</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Contact / CTA Column -->
            <div>
                <h4 style="color: white; margin-bottom: 1rem;">Get in Touch</h4>
                <p style="color: #94a3b8; margin-bottom: 1rem;">Questions? We'd love to hear from you.</p>
                <a href="mailto:hello@hoplytics.com" style="color: white; text-decoration: underline;">hello@hoplytics.com</a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="site-info">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <div>
                    &copy; <?php echo date( 'Y' ); ?> Hoplytics. All rights reserved.
                </div>

                <?php if ( has_nav_menu( 'social' ) ) : ?>
                    <div class="footer-social-links">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'social',
                            'container'      => false,
                            'menu_class'     => 'flex gap-4',
                            'depth'          => 1,
                        ) );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
