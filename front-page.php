<?php
/**
 * The front page template file
 *
 * @package Hoplytics
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

        <main id="primary" class="site-main">

        <!-- Hero Section -->
        <section class="hero-section section">
            <div class="container">
                <div class="grid grid-2 items-center">
                    <div class="hero-content">
                        <div class="hero-bg-container"></div>
                        <h1>High-Value Client Acquisition for Lead Generation for Insurance &amp; High-Ticket Marketing</h1>
                        <h2 class="text-lg text-muted">Add $500k ARR with a predictable pipeline—no recycled leads, no guesswork.</h2>
                        <div class="flex gap-4 mt-4 flex-wrap">
                            <a href="#growth-audit" class="btn btn-primary">Get My Free Growth Audit</a>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <?php
                        $hero_image_id = get_theme_mod('hero_visual_image');
                        if ( $hero_image_id ) {
                            echo wp_get_attachment_image( $hero_image_id, 'large', false, array('class' => 'rounded shadow-lg') );
                        } else {
                            get_template_part( 'template-parts/components/hero-lead-form' );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem / Agitation -->
        <section class="pain-section section bg-alt" id="growth-audit">
            <div class="container grid grid-2 items-center">
                <div>
                    <h2>Still Buying Recycled Leads or Wasting Money on Ads?</h2>
                    <p>You deserve conversations with decision-makers, not tire-kickers. Stop bleeding cash on low-intent leads, slow follow-ups, and ad spend that never converts into premium policies.</p>
                    <p>When you partner with Hoplytics, every dollar is engineered to attract ready-to-buy prospects who respect your time and your expertise.</p>
                </div>
                <div class="card">
                    <?php get_template_part( 'template-parts/cro/lead-magnet-gate', null, array( 'title' => 'Your Free Growth Audit', 'button_text' => 'Claim My Session' ) ); ?>
                </div>
            </div>
        </section>

        <!-- ROI Calculator -->
        <section class="roi-section section">
            <div class="container text-center">
                <h2>Calculate Your Potential Revenue</h2>
                <div class="roi-calculator-placeholder">
                    <!-- ROI Calculator will be embedded here -->
                </div>
            </div>
        </section>

        <!-- Social Proof -->
        <section class="social-proof section bg-alt">
            <div class="container text-center">
                <h2>Trusted by Top Brokers</h2>
                <div class="logo-grid grid grid-4 mt-6">
                    <!-- Logo grid placeholder -->
                </div>
            </div>
        </section>

        </main><!-- #main -->

<?php
get_footer();
