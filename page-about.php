<?php
/**
 * Template Name: About Us
 * Slug: about
 *
 * The About page — company story, values, and trust signals.
 *
 * @package Hoplytics
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="hero-section section">
        <div class="container">
            <div class="hero-content mx-auto text-center" style="max-width: 800px;">
                <p class="text-sm text-muted"
                    style="text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">About Hoplytics</p>
                <h1>We Build <span class="gradient-text">Growth Machines</span> for Ambitious Businesses.</h1>
                <p class="text-lg" style="max-width: 600px; margin: 1.5rem auto 0;">Hoplytics is a performance-driven
                    digital marketing agency. We don't do vanity metrics — we build systems that generate revenue,
                    predictably and at scale.</p>
            </div>
        </div>
    </section>

    <!-- Mission / Story -->
    <section class="section bg-alt">
        <div class="container">
            <div class="grid grid-2 items-center" style="gap: 4rem;" data-animate>
                <div>
                    <p class="text-sm"
                        style="color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 0.5rem;">
                        Our Story</p>
                    <h2>Born From Frustration With Status-Quo Marketing.</h2>
                    <p class="text-muted" style="margin-top: 1.5rem;">We founded Hoplytics after seeing too many
                        businesses burn through ad budgets with nothing to show for it. Agencies that promise the world,
                        deliver a PDF report, and vanish.</p>
                    <p class="text-muted">Our approach is different: we operate as an extension of your team. Every
                        campaign is tied to a revenue outcome. Every dollar is tracked. Every strategy is tested and
                        iterated — because "good enough" doesn't pay the bills.</p>
                </div>
                <div class="card p-8"
                    style="text-align: center; background: var(--gradient-hero); border: 1px solid var(--color-border);">
                    <div class="social-proof-bar"
                        style="flex-direction: column; gap: 2rem; border: none; margin: 0; padding: 0;">
                        <div class="proof-stat">
                            <span class="stat-value" style="font-size: 3rem;">140+</span>
                            <span class="stat-label">Clients Served</span>
                        </div>
                        <div class="proof-stat">
                            <span class="stat-value" style="font-size: 3rem;">$12M+</span>
                            <span class="stat-label">Revenue Generated</span>
                        </div>
                        <div class="proof-stat">
                            <span class="stat-value" style="font-size: 3rem;">4.2x</span>
                            <span class="stat-label">Average ROAS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-12" data-animate>
                <h2>What We Stand For</h2>
                <p class="text-lg text-muted" style="max-width: 550px; margin: 1rem auto 0;">Five principles that guide
                    every campaign, decision, and client relationship.</p>
            </div>

            <div class="grid grid-3" style="gap: 2rem;" data-stagger>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">📊</div>
                    <h4 class="font-bold mb-2">Data Over Opinions</h4>
                    <p class="text-sm text-muted">Every decision is backed by data. We test, measure, and iterate —
                        hunches don't drive strategy, numbers do.</p>
                </div>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🎯</div>
                    <h4 class="font-bold mb-2">Revenue First</h4>
                    <p class="text-sm text-muted">Impressions mean nothing if they don't convert. We optimize for the
                        metrics that actually grow your business.</p>
                </div>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🔍</div>
                    <h4 class="font-bold mb-2">Radical Transparency</h4>
                    <p class="text-sm text-muted">Full access to dashboards, ad accounts, and real-time data. No
                        gatekeeping, no fluff reports.</p>
                </div>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">⚡</div>
                    <h4 class="font-bold mb-2">Execution Speed</h4>
                    <p class="text-sm text-muted">We ship fast and iterate faster. While others are still strategizing,
                        we're already testing and optimizing.</p>
                </div>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🤝</div>
                    <h4 class="font-bold mb-2">True Partnership</h4>
                    <p class="text-sm text-muted">We embed into your team, learn your business deeply, and treat your
                        revenue targets as our own.</p>
                </div>
                <div class="card p-6">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🛡️</div>
                    <h4 class="font-bold mb-2">No Lock-in Contracts</h4>
                    <p class="text-sm text-muted">We earn your business every month. If we're not delivering, you can
                        walk — no penalty, no drama.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What Makes Us Different -->
    <section class="section bg-alt">
        <div class="container">
            <div class="text-center mb-12" data-animate>
                <h2>Why Clients Choose <span class="gradient-text">Hoplytics</span></h2>
            </div>

            <div class="grid grid-2" style="gap: 2rem;" data-stagger>
                <!-- Old Way vs Our Way -->
                <div class="card p-8" style="border-top: 4px solid #EF4444;">
                    <h3 class="text-xl font-bold mb-4" style="color: #EF4444;">❌ The Typical Agency</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: #EF4444; font-weight: 600;">✕</span> Vanity metrics in monthly PDFs
                        </li>
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: #EF4444; font-weight: 600;">✕</span> 12-month lock-in contracts
                        </li>
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: #EF4444; font-weight: 600;">✕</span> Junior account managers
                        </li>
                        <li
                            style="padding: 0.75rem 0; font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: #EF4444; font-weight: 600;">✕</span> Cookie-cutter strategies
                        </li>
                    </ul>
                </div>

                <div class="card p-8" style="border-top: 4px solid var(--color-accent);">
                    <h3 class="text-xl font-bold mb-4" style="color: var(--color-accent);">✅ The Hoplytics Way</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: var(--color-accent); font-weight: 600;">✓</span> Real-time dashboards
                            with revenue attribution
                        </li>
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: var(--color-accent); font-weight: 600;">✓</span> Month-to-month — earn
                            your trust
                        </li>
                        <li
                            style="padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: var(--color-accent); font-weight: 600;">✓</span> Senior strategists on
                            every account
                        </li>
                        <li
                            style="padding: 0.75rem 0; font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
                            <span style="color: var(--color-accent); font-weight: 600;">✓</span> Custom systems built
                            for YOUR business
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-8" data-animate>
                <h2>What We Do</h2>
            </div>
            <div class="grid grid-4" style="gap: 1rem;" data-stagger>
                <a href="<?php echo esc_url(home_url('/search-engine-optimization/')); ?>"
                    class="card p-6 text-center" style="text-decoration: none;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔍</div>
                    <h4 class="font-bold" style="font-size: 0.95rem;">SEO</h4>
                </a>
                <a href="<?php echo esc_url(home_url('/search-engine-marketing/')); ?>" class="card p-6 text-center"
                    style="text-decoration: none;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                    <h4 class="font-bold" style="font-size: 0.95rem;">Paid Ads</h4>
                </a>
                <a href="<?php echo esc_url(home_url('/social-media-marketing/')); ?>" class="card p-6 text-center"
                    style="text-decoration: none;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📱</div>
                    <h4 class="font-bold" style="font-size: 0.95rem;">Social Media</h4>
                </a>
                <a href="<?php echo esc_url(home_url('/content-marketing-services/')); ?>"
                    class="card p-6 text-center" style="text-decoration: none;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">✍️</div>
                    <h4 class="font-bold" style="font-size: 0.95rem;">Content</h4>
                </a>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="section bg-alt">
        <div class="container text-center" data-animate>
            <h2>Let's Build Something That Pays For Itself.</h2>
            <p class="text-lg text-muted mb-8" style="max-width: 550px; margin-left: auto; margin-right: auto;">Book a
                free 30-minute strategy session. We'll audit your current marketing and show you the gaps — no strings
                attached.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn btn-primary btn-lg">Book Your
                    Free Strategy Call →</a>
                <a href="<?php echo esc_url(home_url('/case-studies/')); ?>" class="btn btn-secondary btn-lg">See
                    Our Results</a>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
