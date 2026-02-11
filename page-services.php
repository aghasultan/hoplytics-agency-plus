<?php
/**
 * Template Name: Services Hub
 * Slug: services
 *
 * The services landing page that links to all individual service pages.
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
                    style="text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Full-Service
                    Digital Marketing</p>
                <h1>Everything You Need to <span class="gradient-text">Dominate Online</span>.</h1>
                <p class="text-lg" style="max-width: 600px; margin: 1.5rem auto 2rem;">We don't just run ads. We build
                    complete client acquisition systems — so every dollar you spend works harder than the last.</p>
                <div class="social-proof-bar" style="max-width: 600px; margin: 0 auto; border: none;" data-animate>
                    <div class="proof-stat">
                        <span class="stat-value">140+</span>
                        <span class="stat-label">Clients</span>
                    </div>
                    <div class="proof-stat">
                        <span class="stat-value">4.2x</span>
                        <span class="stat-label">Avg ROAS</span>
                    </div>
                    <div class="proof-stat">
                        <span class="stat-value">$12M+</span>
                        <span class="stat-label">Revenue Generated</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Services Grid -->
    <section class="services-grid-section section bg-alt">
        <div class="container">
            <div class="text-center mb-12" data-animate>
                <h2>Our Services</h2>
                <p class="text-lg text-muted" style="max-width: 600px; margin: 1rem auto 0;">Each service integrates
                    into a unified growth engine — not siloed campaigns.</p>
            </div>

            <div class="grid grid-2" style="gap: 2rem;" data-stagger>

                <!-- Search Engine Optimization -->
                <div class="card p-8" style="border-top: 3px solid var(--color-accent);">
                    <div class="mb-4" style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 56px; height: 56px; border-radius: var(--radius-md); background: var(--color-primary-dim); display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold" style="margin: 0;">Search Engine Optimization</h3>
                    </div>
                    <p class="text-muted mb-4">Rank higher. Get found. Own page one for the keywords your ideal clients
                        are searching right now. We handle technical SEO, content, backlinks, and local optimization.
                    </p>
                    <ul
                        style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-accent);">✓</span> Technical Audits</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-accent);">✓</span> Keyword Strategy</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-accent);">✓</span> Link Building</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-accent);">✓</span> Local SEO</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/search-engine-optimization/')); ?>"
                        class="btn btn-secondary">Learn More →</a>
                </div>

                <!-- Search Engine Marketing -->
                <div class="card p-8" style="border-top: 3px solid var(--color-primary);">
                    <div class="mb-4" style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 56px; height: 56px; border-radius: var(--radius-md); background: var(--color-primary-dim); display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold" style="margin: 0;">Search Engine Marketing</h3>
                    </div>
                    <p class="text-muted mb-4">Get in front of high-intent buyers the moment they're searching. We
                        manage Google Ads, Shopping campaigns, and display retargeting with surgical precision.</p>
                    <ul
                        style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-primary);">✓</span> Google Ads</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-primary);">✓</span> Shopping Campaigns</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-primary);">✓</span> Remarketing</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-primary);">✓</span> Conversion Tracking</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/search-engine-marketing/')); ?>"
                        class="btn btn-secondary">Learn More →</a>
                </div>

                <!-- Social Media Marketing -->
                <div class="card p-8" style="border-top: 3px solid var(--color-secondary);">
                    <div class="mb-4" style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 56px; height: 56px; border-radius: var(--radius-md); background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-secondary)"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold" style="margin: 0;">Social Media Marketing</h3>
                    </div>
                    <p class="text-muted mb-4">Stop posting into the void. We build authority content, run paid social
                        campaigns, and engineer communities that convert followers into revenue.</p>
                    <ul
                        style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-secondary);">✓</span> Content Strategy</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-secondary);">✓</span> Facebook & Instagram Ads</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-secondary);">✓</span> Community Management</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-secondary);">✓</span> Influencer Outreach</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/social-media-marketing/')); ?>"
                        class="btn btn-secondary">Learn More →</a>
                </div>

                <!-- Content Marketing -->
                <div class="card p-8" style="border-top: 3px solid var(--color-warning);">
                    <div class="mb-4" style="display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 56px; height: 56px; border-radius: var(--radius-md); background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning)"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold" style="margin: 0;">Content Marketing</h3>
                    </div>
                    <p class="text-muted mb-4">Content that ranks, converts, and builds trust. From blog posts to lead
                        magnets, we create assets that work for you 24/7 — even while you sleep.</p>
                    <ul
                        style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-warning);">✓</span> Blog Strategy</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-warning);">✓</span> Lead Magnets</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-warning);">✓</span> Email Sequences</li>
                        <li style="font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"><span
                                style="color: var(--color-warning);">✓</span> Content Distribution</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/content-marketing-services/')); ?>"
                        class="btn btn-secondary">Learn More →</a>
                </div>

            </div>
        </div>
    </section>

    <!-- How We Work -->
    <section class="process-section section">
        <div class="container">
            <div class="text-center mb-12" data-animate>
                <h2>How We Work</h2>
                <p class="text-lg text-muted" style="max-width: 550px; margin: 1rem auto 0;">A proven 4-step process
                    that turns marketing spend into predictable revenue.</p>
            </div>

            <div class="grid grid-4" data-stagger>
                <!-- Step 1 -->
                <div class="card p-6 text-center" style="position: relative;">
                    <div
                        style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--gradient-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; margin: 0 auto 1rem;">
                        1</div>
                    <h4 class="font-bold mb-2">Discovery Audit</h4>
                    <p class="text-sm text-muted">We dissect your business, competitors, and market to find the fastest
                        path to revenue.</p>
                </div>
                <!-- Step 2 -->
                <div class="card p-6 text-center">
                    <div
                        style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--gradient-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; margin: 0 auto 1rem;">
                        2</div>
                    <h4 class="font-bold mb-2">Custom Strategy</h4>
                    <p class="text-sm text-muted">We build a bespoke playbook — channels, budgets, creatives, and KPIs
                        tailored to your goals.</p>
                </div>
                <!-- Step 3 -->
                <div class="card p-6 text-center">
                    <div
                        style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--gradient-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; margin: 0 auto 1rem;">
                        3</div>
                    <h4 class="font-bold mb-2">Launch & Optimize</h4>
                    <p class="text-sm text-muted">Campaigns go live. We monitor, test, and iterate daily to maximize
                        every dollar spent.</p>
                </div>
                <!-- Step 4 -->
                <div class="card p-6 text-center">
                    <div
                        style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--gradient-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; margin: 0 auto 1rem;">
                        4</div>
                    <h4 class="font-bold mb-2">Scale & Report</h4>
                    <p class="text-sm text-muted">Transparent monthly reports with actionable insights. If it's working,
                        we pour gasoline on it.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Free Tools CTA -->
    <section class="section bg-alt">
        <div class="container">
            <div class="card p-8 text-center"
                style="background: var(--gradient-hero); border: 1px solid var(--color-border);" data-animate>
                <h2><span class="gradient-text">Free Diagnostic Tools</span></h2>
                <p class="text-lg text-muted mb-4" style="max-width: 500px; margin-left: auto; margin-right: auto;">Not
                    ready to talk? Run a free audit on your website, SEO, tracking pixels, and social presence — no
                    signup required.</p>
                <a href="<?php echo esc_url(home_url('/free-tools/')); ?>" class="btn btn-primary btn-lg">Explore
                    Free Tools →</a>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="section">
        <div class="container text-center" data-animate>
            <h2>Ready to Stop Guessing and Start Growing?</h2>
            <p class="text-lg text-muted mb-8" style="max-width: 550px; margin-left: auto; margin-right: auto;">Book a
                free strategy session. We'll audit your current setup and show you exactly where the money is.</p>
            <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn btn-primary btn-lg">Get Your Free
                Growth Audit →</a>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
