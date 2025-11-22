<?php
/**
 * The front page template file
 *
 * @package Agency_Plus
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section bg-alt">
    <div class="container">
        <div class="hero-content">
            <h1>Transform Your Digital Presence with Hoplytics</h1>
            <p>We build high-converting marketing strategies and modern websites for SaaS and agencies. Scale faster with data-driven growth.</p>
            <div class="hero-buttons">
                <a href="/contact" class="btn btn-primary">Book a Discovery Call</a>
                <a href="#services" class="btn btn-secondary">View Our Services</a>
            </div>
        </div>
        <div class="hero-image">
            <!-- Placeholder SVG Illustration -->
            <svg width="600" height="400" viewBox="0 0 600 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="600" height="400" rx="16" fill="#E2E8F0"/>
                <rect x="50" y="50" width="500" height="300" rx="8" fill="white"/>
                <rect x="80" y="80" width="200" height="20" rx="4" fill="#CBD5E1"/>
                <rect x="80" y="120" width="300" height="10" rx="2" fill="#E2E8F0"/>
                <rect x="80" y="140" width="280" height="10" rx="2" fill="#E2E8F0"/>
                <circle cx="450" cy="200" r="60" fill="#3B82F6" fill-opacity="0.2"/>
                <path d="M450 170L480 220H420L450 170Z" fill="#3B82F6"/>
            </svg>
        </div>
    </div>
</section>

<!-- Logos / Social Proof -->
<div class="section" style="padding-top: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--color-border);">
    <div class="container">
        <p class="text-center" style="color: var(--color-text-light); margin-bottom: 1.5rem; font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">Trusted by innovative companies</p>
        <div class="flex items-center justify-between" style="flex-wrap: wrap; opacity: 0.6; gap: 2rem; justify-content: center;">
            <!-- Generic Company Logos (Placeholders) -->
            <span style="font-weight: 700; font-size: 1.5rem; color: #94a3b8;">ACME Corp</span>
            <span style="font-weight: 700; font-size: 1.5rem; color: #94a3b8;">Globex</span>
            <span style="font-weight: 700; font-size: 1.5rem; color: #94a3b8;">Soylent</span>
            <span style="font-weight: 700; font-size: 1.5rem; color: #94a3b8;">Initech</span>
            <span style="font-weight: 700; font-size: 1.5rem; color: #94a3b8;">Umbrella</span>
        </div>
    </div>
</div>

<!-- How It Works -->
<section class="section">
    <div class="container">
        <div class="text-center" style="max-width: 600px; margin: 0 auto 4rem auto;">
            <h2>How We Work</h2>
            <p>Our proven process takes you from chaos to clarity in three simple steps.</p>
        </div>

        <div class="steps-grid">
            <!-- Step 1 -->
            <div class="step-item">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3>1. Audit & Strategy</h3>
                <p>We analyze your current setup, identify gaps, and build a roadmap for growth tailored to your goals.</p>
            </div>

            <!-- Step 2 -->
            <div class="step-item">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3>2. Execute & Optimize</h3>
                <p>Our team implements the strategy, launching campaigns and refining assets to maximize ROI.</p>
            </div>

            <!-- Step 3 -->
            <div class="step-item">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3>3. Scale & Grow</h3>
                <p>We double down on what works, using data to drive consistent, predictable revenue growth.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section id="services" class="section bg-alt">
    <div class="container">
        <div class="text-center" style="max-width: 600px; margin: 0 auto 4rem auto;">
            <h2>Our Services</h2>
            <p>Everything you need to dominate your market.</p>
        </div>

        <div class="services-grid">
            <div class="card">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
                <h3>SEO & Content</h3>
                <p>Rank higher and attract qualified leads with our data-driven SEO and content marketing strategies.</p>
                <a href="#" style="font-weight: 600; font-size: 0.875rem;">Learn more &rarr;</a>
            </div>

            <div class="card">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h3>PPC & Paid Social</h3>
                <p>Maximize your ad spend with targeted campaigns on Google, LinkedIn, and Facebook.</p>
                <a href="#" style="font-weight: 600; font-size: 0.875rem;">Learn more &rarr;</a>
            </div>

            <div class="card">
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <h3>Web Design & Dev</h3>
                <p>Custom WordPress websites designed for speed, conversion, and long-term maintainability.</p>
                <a href="#" style="font-weight: 600; font-size: 0.875rem;">Learn more &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section text-center">
    <div class="container">
        <div style="background: var(--color-primary); color: white; padding: 4rem 2rem; border-radius: var(--radius-lg);">
            <h2 style="color: white; margin-bottom: 1rem;">Ready to Scale Your Agency?</h2>
            <p style="color: #cbd5e1; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">Stop guessing and start growing. Schedule your free discovery call today and see how we can help.</p>
            <a href="/contact" class="btn btn-accent">Book Your Call Now</a>
        </div>
    </div>
</section>

<!-- Blog Preview -->
<section class="section bg-alt">
    <div class="container">
        <div class="flex items-center justify-between" style="margin-bottom: 3rem;">
            <h2 style="margin-bottom: 0;">Latest Insights</h2>
            <a href="/blog" class="btn btn-secondary">View All Posts</a>
        </div>

        <div class="grid grid-3">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'ignore_sticky_posts' => 1,
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="card" style="padding: 0; overflow: hidden;">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 200px; object-fit: cover; display: block;')); ?>
                    </a>
                <?php else : ?>
                    <div style="width: 100%; height: 200px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
                <?php endif; ?>

                <div style="padding: 1.5rem;">
                    <div class="post-meta"><?php echo get_the_date(); ?></div>
                    <h3><a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    <a href="<?php the_permalink(); ?>" style="font-weight: 600; font-size: 0.875rem;">Read more &rarr;</a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
