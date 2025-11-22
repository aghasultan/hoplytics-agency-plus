<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hoplytics
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <!-- New Footer Layout -->
        <div class="grid grid-3 footer-top-grid">
            <!-- Brand Column -->
            <div>
                <h3 class="footer-brand-title">Hoplytics</h3>
                <p class="footer-brand-desc">Modern digital marketing for forward-thinking agencies. We help you scale with confidence.</p>
            </div>

            <!-- Links Column -->
            <div>
                <h4 class="footer-col-title">Company</h4>
                <ul class="footer-links">
                    <li class="footer-link-item"><a href="/about">About Us</a></li>
                    <li class="footer-link-item"><a href="#services">Services</a></li>
                    <li class="footer-link-item"><a href="/blog">Blog</a></li>
                    <li class="footer-link-item"><a href="/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Contact / CTA Column -->
            <div>
                <h4 class="footer-col-title">Get in Touch</h4>
                <p class="footer-contact-text">Questions? We'd love to hear from you.</p>
                <a href="mailto:hello@hoplytics.com" class="footer-email-link">hello@hoplytics.com</a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="site-info">
            <div class="flex justify-between items-center footer-bottom-flex">
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

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('<?php echo esc_url( get_template_directory_uri() . '/service-worker.js' ); ?>')
        .then(registration => {
          console.log('SW registered: ', registration);
        })
        .catch(registrationError => {
          console.log('SW registration failed: ', registrationError);
        });
    });
  }
</script>

</body>
</html>
