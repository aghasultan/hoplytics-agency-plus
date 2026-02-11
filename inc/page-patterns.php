<?php
/**
 * Block Patterns — Service pages, homepage sections, and reusable layouts.
 *
 * @package Hoplytics
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Register block pattern category and service page patterns.
 */
function hoplytics_register_page_patterns(): void
{
    register_block_pattern_category('hoplytics-services', [
        'label' => __('Hoplytics Services', 'hoplytics'),
    ]);

    register_block_pattern_category('hoplytics-sections', [
        'label' => __('Hoplytics Sections', 'hoplytics'),
    ]);

    // ─── SEO Service Page ───
    register_block_pattern('hoplytics/service-seo', [
        'title' => __('SEO Service Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'SEO Services That Drive Measurable Organic Growth',
            'Drive sustainable organic traffic with Hoplytics SEO services. Technical audits, keyword strategy, link building, and content optimization — all backed by data.',
            [
                ['🔍', 'Complete Technical SEO Audit', 'Full crawl analysis — broken links, duplicate content, site architecture, Core Web Vitals, mobile readiness, and indexation issues.'],
                ['🎯', 'Competitor & Keyword Research', 'Deep competitor gap analysis and intent-mapped keyword strategy to uncover high-value ranking opportunities.'],
                ['📝', 'On-Page Optimization', 'Title tags, meta descriptions, header structure, internal linking, schema markup — every element optimized for search.'],
                ['🔗', 'Link Building & Digital PR', 'White-hat link acquisition through data-driven outreach, guest posts, and digital PR that earns high-authority backlinks.'],
                ['✍️', 'Content Strategy & Creation', 'Topic clusters, pillar pages, and SEO-optimized articles that rank and convert organic visitors into leads.'],
                ['📍', 'Local SEO & Google Business', 'Google Business Profile optimization, local citations, review management, and map pack ranking strategies.'],
                ['📊', 'Monthly Analytics & Reporting', 'Transparent reporting — rankings, traffic, conversions, and ROI tracked monthly with clear recommendations.'],
                ['⚡', 'Core Web Vitals Optimization', 'LCP, FID, CLS — we optimize your site to pass Google\'s page experience signals for better rankings.'],
            ],
            ['Audit', 'Strategy', 'Execute', 'Report'],
            [
                ['How long does SEO take to show results?', 'Most clients see measurable improvements within 3-6 months. SEO is a compounding investment — the longer you invest, the greater the returns. Quick wins (technical fixes, content optimization) can show results in weeks.'],
                ['What\'s included in a technical SEO audit?', 'Our audit covers 50+ factors: site speed, mobile usability, indexation, crawlability, structured data, content quality, backlink profile, competitor analysis, and a prioritized action plan.'],
                ['Do you guarantee #1 rankings?', 'No reputable SEO agency guarantees specific rankings. We guarantee transparent reporting, proven strategies, and measurable ROI. Our average client sees 150%+ organic traffic growth in 12 months.'],
                ['How is your SEO pricing structured?', 'We offer monthly retainers based on your site size, competition level, and goals. Every engagement starts with a free audit so we can provide an accurate quote.'],
                ['Will I need to create new content?', 'Content is a key pillar of SEO. We handle the entire content strategy — from keyword research to writing to publishing. You just approve the topics.'],
                ['Do you work with e-commerce sites?', 'Yes — we have specific expertise in e-commerce SEO, including product page optimization, category structure, technical SEO for large catalogs, and shopping feed optimization.'],
            ],
            'Get Your Free SEO Audit',
            '/free-tools#audit-tool'
        ),
    ]);

    // ─── Paid Advertising Service Page ───
    register_block_pattern('hoplytics/service-ppc', [
        'title' => __('PPC / Paid Advertising Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'Paid Advertising That Delivers Real, Trackable ROI',
            'Stop wasting ad spend. Our PPC management delivers qualified leads at scale with Google Ads, Meta Ads, and LinkedIn Ads — tracked down to every dollar.',
            [
                ['🎯', 'Google Ads Management', 'Search, Display, Shopping, YouTube — full-funnel campaigns designed to capture high-intent prospects at the moment they\'re searching.'],
                ['📘', 'Meta (Facebook & Instagram) Ads', 'Lookalike audiences, retargeting, dynamic product ads — we maximize ROAS across Meta\'s entire advertising ecosystem.'],
                ['💼', 'LinkedIn Advertising', 'B2B lead generation with precision targeting by job title, industry, company size, and seniority level.'],
                ['🎵', 'TikTok & Emerging Platforms', 'Short-form video ads, spark ads, and brand takeover campaigns for brands targeting Gen Z and Millennial audiences.'],
                ['📊', 'Conversion Tracking Setup', 'Pixel implementation, server-side tracking, offline conversion imports — we ensure every lead and sale is accurately attributed.'],
                ['🔄', 'Landing Page Optimization', 'Custom landing pages A/B tested for maximum conversion rates — because traffic without conversions is just expense.'],
            ],
            ['Audit', 'Launch', 'Optimize', 'Scale'],
            [
                ['What\'s the minimum ad budget you recommend?', 'For Google Ads, we recommend a minimum of $2,000/month. For Meta Ads, $1,500/month. Smaller budgets limit data collection and optimization speed.'],
                ['How quickly can I expect results from PPC?', 'PPC delivers results faster than SEO — you can see leads within the first week. Allow 2-3 months for full optimization as we gather conversion data.'],
                ['How do you measure PPC success?', 'We track: Cost Per Acquisition (CPA), Return on Ad Spend (ROAS), Conversion Rate, Quality Score, and most importantly — revenue generated per dollar spent.'],
                ['Do you manage the creative/ad copy?', 'Yes — we handle everything from ad copywriting to image/video creative, A/B testing, and landing page design. Full-service means full-service.'],
            ],
            'Calculate Your Ad ROI',
            '/free-tools'
        ),
    ]);

    // ─── Social Media Marketing Service Page ───
    register_block_pattern('hoplytics/service-social', [
        'title' => __('Social Media Marketing Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'Social Media Marketing That Builds Brands & Drives Sales',
            'Build a loyal audience and drive conversions with our social media marketing services. Strategy, content, paid ads, and monthly reporting across all platforms.',
            [
                ['📱', 'Profile Setup & Optimization', 'Professional bio, branded visuals, strategic keyword placement, CTA optimization — every platform polished to perfection.'],
                ['📅', 'Content Calendar & Creation', 'Monthly content calendars with mix of educational, promotional, and engagement posts tailored to your brand voice.'],
                ['💬', 'Community Management', 'Real-time comment responses, DM management, brand mention monitoring — we protect and grow your online reputation.'],
                ['💰', 'Paid Social Advertising', 'Meta, TikTok, LinkedIn, Pinterest — targeted paid campaigns with A/B tested creatives and conversion-optimized landing pages.'],
                ['🤝', 'Influencer Collaboration', 'Identify, vet, and manage influencer partnerships that align with your brand and deliver measurable ROI.'],
                ['📊', 'Analytics & Monthly Reports', 'Follower growth, engagement rate, reach, impressions, click-through rates — transparent data that proves value.'],
            ],
            ['Audit', 'Plan', 'Create', 'Analyze'],
            [
                ['Which platforms should my business be on?', 'It depends on your audience. B2B businesses thrive on LinkedIn, B2C on Instagram and TikTok. We audit your audience demographics and recommend the highest-ROI platforms.'],
                ['How often will you post on my behalf?', 'We typically post 3-5 times per week per platform, plus Stories and Reels. The exact cadence is customized based on your industry and audience engagement patterns.'],
                ['Can you manage our existing social accounts?', 'Absolutely. We audit your existing profiles, optimize them, and take over management — no disruption, only improvement.'],
                ['Do you create the visual content too?', 'Yes — our in-house designers create branded graphics, carousels, short-form videos, and motion graphics for every piece of content.'],
            ],
            'Get a Free Social Media Audit',
            '/free-tools#audit-tool'
        ),
    ]);

    // ─── Content Marketing Service Page ───
    register_block_pattern('hoplytics/service-content', [
        'title' => __('Content Marketing Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'Content Marketing That Converts Readers Into Revenue',
            'Convert readers into revenue. Our content marketing services combine strategy, SEO-optimized writing, and distribution to grow your organic pipeline.',
            [
                ['🎯', 'Content Strategy Development', 'Audience personas, topic clusters, editorial calendar, and competitive content gap analysis — a roadmap for content that ranks and converts.'],
                ['✍️', 'Blog & Article Writing', 'SEO-optimized, research-backed articles written by industry experts. 1,500+ words, proper header structure, internal linking, and compelling CTAs.'],
                ['🚀', 'Content Distribution', 'Multi-channel amplification — email, social, syndication, and outreach to maximize every piece of content\'s reach and impact.'],
                ['📧', 'Email Newsletter Management', 'Segmented email campaigns, drip sequences, and newsletter management that nurture leads through your funnel.'],
                ['📱', 'Social Content Creation', 'Repurpose blog content into social posts, carousels, infographics, and short-form video for maximum cross-platform reach.'],
                ['📊', 'Content Performance Analytics', 'Track traffic, engagement, leads, and revenue generated by every piece of content. Continuous optimization based on data.'],
            ],
            ['Research', 'Create', 'Distribute', 'Measure'],
            [
                ['How is content marketing different from copywriting?', 'Content marketing is a long-term strategy focused on building trust through valuable, educational content. Copywriting is sales-focused. We do both — content that educates AND converts.'],
                ['How often will you publish content?', 'Most clients get 4-8 pieces per month — a mix of blog posts, pillar pages, email newsletters, and social content. We customize cadence to your goals and budget.'],
                ['Will the content be original?', 'Every piece is 100% original, written by human writers (not AI-generated), fact-checked, and optimized for search engines. We never use templates or recycled content.'],
                ['How do you measure content ROI?', 'We track the full funnel: organic traffic, keyword rankings, time on page, lead conversions, and revenue attributed to content. Monthly reports with clear ROI metrics.'],
            ],
            'Get a Custom Content Strategy',
            '/get-started'
        ),
    ]);

    // ─── Web Development Service Page ───
    register_block_pattern('hoplytics/service-webdev', [
        'title' => __('Web Development Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'Web Development Built for Speed and Conversions',
            'Custom WordPress websites built for speed, SEO, and conversions. Block editor native, mobile-first, and optimized for Core Web Vitals.',
            [
                ['🌐', 'Custom WordPress Development', 'Bespoke WordPress themes built with the block editor, PHP 8.2+, and modern APIs — not templates, real custom code.'],
                ['⚡', 'Performance Optimization', 'Sub-2-second load times. Optimized images, critical CSS inlining, lazy loading, speculative prerendering, and CDN-ready architecture.'],
                ['📱', 'Mobile-First Responsive Design', 'Every site is built mobile-first with fluid layouts, touch-optimized interactions, and tested across 20+ device types.'],
                ['🔍', 'SEO-Ready Architecture', 'Clean semantic HTML, JSON-LD structured data, breadcrumbs, XML sitemaps, and 95+ Lighthouse SEO scores out of the box.'],
                ['♿', 'WCAG Accessibility', 'WCAG 2.1 AA compliant — focus management, screen reader support, color contrast, keyboard navigation, and ARIA landmarks.'],
                ['🔧', 'Ongoing Maintenance', 'Security updates, performance monitoring, uptime checks, and monthly health reports to keep your site running at peak performance.'],
            ],
            ['Discovery', 'Design', 'Develop', 'Launch'],
            [
                ['How long does a website project take?', 'Simple brochure sites: 4-6 weeks. Custom sites with tools/integrations: 8-12 weeks. Enterprise sites: 12-20 weeks. We provide a detailed timeline after discovery.'],
                ['Will I be able to update the site myself?', 'Yes — we build with the WordPress block editor so you can update content, images, and layouts without touching code. We provide training and documentation.'],
                ['Do you build with page builders like Elementor?', 'No. Page builders add bloat and slow your site down. We build with native WordPress blocks and custom PHP — faster, more secure, and easier to maintain.'],
                ['What about hosting?', 'We recommend managed WordPress hosting (Cloudways, Kinsta, or WP Engine). We can set up and manage hosting for you as part of our maintenance packages.'],
            ],
            'Get a Free Website Audit',
            '/free-tools#audit-tool'
        ),
    ]);

    // ─── Marketing Automation Service Page ───
    register_block_pattern('hoplytics/service-automation', [
        'title' => __('Marketing Automation Page', 'hoplytics'),
        'categories' => ['hoplytics-services'],
        'content' => hoplytics_service_pattern(
            'Marketing Automation That Works While You Sleep',
            'Automate your marketing pipeline. From email sequences to lead scoring, we build systems that nurture prospects while you focus on closing.',
            [
                ['🤖', 'Workflow Automation', 'n8n, Zapier, Make — we build multi-step automations that connect your CRM, email, ads, and analytics into one intelligent pipeline.'],
                ['📧', 'Email Sequence Design', 'Welcome sequences, nurture drips, abandoned cart recovery, re-engagement campaigns — automated emails that convert at 3x industry average.'],
                ['🎯', 'Lead Scoring & Routing', 'Behavior-based lead scoring that auto-qualifies prospects and routes hot leads to your sales team in real-time.'],
                ['📊', 'CRM Integration', 'GoHighLevel, HubSpot, Salesforce — we integrate your marketing stack so every lead, email, and conversion is tracked in one place.'],
                ['🔄', 'Content Repurposing Automation', 'Blog post → social posts → email newsletter → video script. One piece of content, 10+ channels, fully automated.'],
                ['📈', 'Reporting Dashboards', 'Real-time dashboards showing pipeline velocity, conversion rates, ROI by channel, and forecast projections.'],
            ],
            ['Map', 'Build', 'Test', 'Optimize'],
            [
                ['What platforms do you work with?', 'We specialize in n8n (open-source), GoHighLevel, HubSpot, ActiveCampaign, Mailchimp, Zapier, and custom API integrations. We recommend the best tool for your needs and budget.'],
                ['How much does marketing automation cost?', 'Setup ranges from $3,000-$15,000 depending on complexity. Monthly management starts at $500. The ROI typically exceeds 5x within 6 months through time savings and increased conversions.'],
                ['Will automation replace my sales team?', 'No — automation handles repetitive tasks (follow-ups, data entry, lead routing) so your sales team can focus on what humans do best: building relationships and closing deals.'],
                ['How long does implementation take?', 'Basic automations: 1-2 weeks. Full marketing stack: 4-8 weeks. We build incrementally so you see value from day one.'],
            ],
            'Book an Automation Consultation',
            '/get-started'
        ),
    ]);
}
add_action('init', 'hoplytics_register_page_patterns');

/**
 * Generate a service page block pattern with consistent structure.
 */
function hoplytics_service_pattern(
    string $h1,
    string $meta_desc,
    array $services,
    array $process_steps,
    array $faqs,
    string $cta_text,
    string $cta_url
): string {

    // Services grid (2 columns)
    $services_html = '';
    foreach (array_chunk($services, 2) as $row) {
        $cols = '';
        foreach ($row as $svc) {
            $cols .= sprintf(
                '<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}}}} -->
<div class="wp-block-group is-style-card" style="padding:2rem" data-animate>
<!-- wp:paragraph {"style":{"typography":{"fontSize":"2rem"}}} -->
<p style="font-size:2rem">%s</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">%s</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#9CA3AF"}}} -->
<p style="color:#9CA3AF">%s</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->',
                esc_html($svc[0]),
                esc_html($svc[1]),
                esc_html($svc[2])
            );
        }
        $services_html .= '<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"1.5rem","margin":{"top":"1.5rem"}}}} -->
<div class="wp-block-columns alignwide" style="margin-top:1.5rem">' . $cols . '</div>
<!-- /wp:columns -->';
    }

    // Process steps
    $steps_html = '';
    foreach ($process_steps as $i => $step) {
        $num = $i + 1;
        $steps_html .= sprintf(
            '<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"is-style-glassmorphism","style":{"spacing":{"padding":{"top":"2rem","right":"1.5rem","bottom":"2rem","left":"1.5rem"}}}} -->
<div class="wp-block-group is-style-glassmorphism" style="padding:2rem 1.5rem">
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"2rem","fontWeight":"800"},"color":{"text":"#3B82F6"}}} -->
<p class="has-text-align-center" style="color:#3B82F6;font-size:2rem;font-weight:800">%d</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center">%s</h4>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->',
            $num,
            esc_html($step)
        );
    }

    // FAQ section
    $faq_html = '';
    foreach ($faqs as $faq) {
        $faq_html .= sprintf(
            '<!-- wp:details -->
<details class="wp-block-details"><summary>%s</summary><!-- wp:paragraph -->
<p>%s</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->',
            esc_html($faq[0]),
            esc_html($faq[1])
        );
    }

    return '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

<!-- wp:heading {"level":1,"textAlign":"center"} -->
<h1 class="wp-block-heading has-text-align-center">' . esc_html($h1) . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"},"color":{"text":"#9CA3AF"}}} -->
<p class="has-text-align-center" style="color:#9CA3AF;font-size:1.25rem">' . esc_html($meta_desc) . '</p>
<!-- /wp:paragraph -->

' . $services_html . '

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}},"color":{"background":"#111827"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#111827;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Our <span class="gradient-text">Process</span></h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"1rem","margin":{"top":"2rem"}}}} -->
<div class="wp-block-columns alignwide" style="margin-top:2rem" data-stagger>' . $steps_html . '</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Frequently Asked <span class="gradient-text">Questions</span></h2>
<!-- /wp:heading -->

' . $faq_html . '

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<div class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">

<!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="color:#ffffff">Ready to Get Started?</h2>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-glow","style":{"color":{"background":"#ffffff","text":"#0B0F19"}}} -->
<div class="wp-block-button is-style-glow"><a class="wp-block-button__link has-text-color has-background" href="' . esc_url($cta_url) . '" style="color:#0B0F19;background-color:#ffffff">' . esc_html($cta_text) . ' →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->';
}
