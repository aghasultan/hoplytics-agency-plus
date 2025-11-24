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
                    <!-- Left Column: Copy -->
                    <div class="hero-content">
                        <h1>Stop Buying Shared Leads. Start Owning the Market.</h1>
                        <p class="text-lg">We build exclusive "Client Acquisition Systems" for Life Insurance Brokers to add $50k/mo in commissions, without cold calling.</p>
                        <div class="trust-indicator mt-4">
                            <p class="text-sm text-muted"><strong>Trusted by 140+ Brokers in North America.</strong></p>
                        </div>
                    </div>

                    <!-- Right Column: Application Form -->
                    <div class="hero-form-wrapper">
                        <div class="card p-8 bg-alt shadow-lg" id="contact">
                            <h2 class="text-2xl font-bold mb-2">Get Your Free Growth Audit.</h2>
                            <p class="text-muted mb-6">See exactly how we can scale your revenue in 90 days.</p>

                            <form class="hero-application-form">
                                <div class="form-group mb-4">
                                    <label for="website-url" class="block text-sm font-medium mb-1">Website URL</label>
                                    <input type="url" id="website-url" name="website_url" placeholder="https://youragency.com" required>
                                </div>

                                <div class="form-group mb-6">
                                    <label for="ad-budget" class="block text-sm font-medium mb-1">Monthly Ad Budget</label>
                                    <select id="ad-budget" name="ad_budget" required>
                                        <option value="" disabled selected>Select your budget...</option>
                                        <option value="1k-3k">$1,000 - $3,000</option>
                                        <option value="3k-5k">$3,000 - $5,000</option>
                                        <option value="5k+">$5,000+</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-4">Claim My Strategy Session</button>

                                <p class="text-xs text-center text-muted">No credit card required. 100% free audit.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem / Agitation Section -->
        <section class="problem-section section bg-alt">
            <div class="container">
                <div class="max-w-xs mx-auto text-center" style="max-width: 800px;">
                    <h2>Your Current Lead Source Is Burning Cash.</h2>
                    <p class="text-lg">Most brokers rely on "shared leads" where they compete with 10 other agents for the same prospect. It's a race to the bottom. We fix this by building private marketing assets that YOU own—not renting leads from a vendor.</p>
                </div>
            </div>
        </section>

        <!-- ROI Calculator Section -->
        <section class="roi-section section">
            <div class="container text-center">
                <h2>The Math of High-Ticket Marketing.</h2>
                <p class="text-lg mb-8">Plug in your numbers to see the revenue you are missing.</p>

                <!-- ROI Tool Template Part -->
                <div class="roi-calculator-container mx-auto" style="max-width: 900px;">
                    <?php get_template_part( 'template-parts/tool-roi-calculator' ); ?>
                </div>
            </div>
        </section>

        <!-- Social Proof Section -->
        <section class="social-proof section bg-alt">
            <div class="container text-center">
                <h2>Trusted by the Top 1% of Producers.</h2>
                <div class="logo-grid grid grid-5 items-center justify-center mt-8">
                    <!-- Client Logos -->
                    <div class="logo-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/epic-resource-group.webp" alt="Epic Resource Group" loading="lazy">
                    </div>
                    <div class="logo-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/gameday-mens-health.svg" alt="Gameday Men's Health" loading="lazy">
                    </div>
                    <div class="logo-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/man-with-a-pram.avif" alt="Man with a Pram" loading="lazy">
                    </div>
                    <div class="logo-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/title-vertical.svg" alt="Title Vertical" loading="lazy">
                    </div>
                    <div class="logo-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/peres-siding.avif" alt="Peres Siding" loading="lazy">
                    </div>
                </div>
            </div>
        </section>

    </main><!-- #main -->

<?php
get_footer();
