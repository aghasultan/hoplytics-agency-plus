<?php
/**
 * Title: Hero Section
 * Slug: hoplytics/hero-section
 * Categories: featured, hoplytics
 * Keywords: hero, cta, lead form
 */

declare(strict_types=1);
?>
<!-- wp:group {"className":"hero-section section","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group hero-section section">
    <!-- wp:columns {"className":"grid items-center"} -->
    <div class="wp-block-columns grid items-center">

        <!-- wp:column {"className":"hero-content"} -->
        <div class="wp-block-column hero-content">
            <!-- wp:heading {"level":1} -->
            <h1>Stop Buying Shared Leads. Start Owning the Market.</h1>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"text-lg"} -->
            <p class="text-lg">We build exclusive "Client Acquisition Systems" for Life Insurance Brokers to add $50k/mo
                in commissions, without cold calling.</p>
            <!-- /wp:paragraph -->
            <!-- wp:paragraph {"className":"text-sm text-muted"} -->
            <p class="text-sm text-muted"><strong>Trusted by 140+ Brokers in North America.</strong></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"hero-form-wrapper"} -->
        <div class="wp-block-column hero-form-wrapper">
            <!-- wp:group {"className":"card p-8 bg-alt shadow-lg"} -->
            <div class="wp-block-group card p-8 bg-alt shadow-lg" id="contact">
                <!-- wp:heading {"level":2,"className":"text-2xl font-bold"} -->
                <h2 class="text-2xl font-bold">Get Your Free Growth Audit.</h2>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"className":"text-muted"} -->
                <p class="text-muted">See exactly how we can scale your revenue in 90 days.</p>
                <!-- /wp:paragraph -->
                <!-- wp:html -->
                <form class="hero-application-form">
                    <div class="form-group mb-4">
                        <label for="website-url" class="block text-sm font-medium mb-1">Website URL</label>
                        <input type="url" id="website-url" name="website_url" placeholder="https://youragency.com"
                            required>
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
                <!-- /wp:html -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->