<?php
/**
 * Title: Bento Home Grid
 * Slug: hoplytics/bento-grid
 * Categories: featured
 */
?>
<!-- wp:group {"className":"hoplytics-bento-grid","style":{"spacing":{"blockGap":"1.5rem"}}} -->
<div class="wp-block-group hoplytics-bento-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: auto auto; gap: 1.5rem;">
    <!-- wp:group {"style":{"color":{"background":"var(--wp--preset--color--primary)","text":"var(--wp--preset--color--surface)"}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group has-text-color has-background has-surface-color has-primary-background-color" style="grid-column: span 2; grid-row: span 2; padding: 2rem; background-color: var(--wp--preset--color--primary); color: var(--wp--preset--color--surface);">
        <!-- wp:heading {"level":1} -->
        <h1 class="wp-block-heading">Hero Intro</h1>
        <!-- /wp:heading -->
        <!-- wp:buttons -->
        <div class="wp-block-buttons"><!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Get Started</a></div>
        <!-- /wp:button --></div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="grid-column: span 1; grid-row: span 2; padding: 2rem; border: 1px solid var(--wp--preset--color--text);">
        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading">Services</h3>
        <!-- /wp:heading -->
        <!-- wp:list -->
        <ul><!-- wp:list-item -->
        <li>SEO</li>
        <!-- /wp:list-item -->
        <!-- wp:list-item -->
        <li>PPC</li>
        <!-- /wp:list-item -->
        <!-- wp:list-item -->
        <li>Content</li>
        <!-- /wp:list-item --></ul>
        <!-- /wp:list -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="grid-column: span 1; grid-row: span 2;">
        <!-- wp:hoplytics/roi-calculator /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="grid-column: span 2; grid-row: span 1; padding: 2rem;">
        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading">Latest Insights</h3>
        <!-- /wp:heading -->
        <!-- wp:query {"queryId":1,"query":{"perPage":2,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":2}} -->
        <div class="wp-block-query">
            <!-- wp:post-template -->
            <!-- wp:post-title /-->
            <!-- /wp:post-template -->
        </div>
        <!-- /wp:query -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"style":{"color":{"background":"var(--wp--preset--color--accent)","text":"#ffffff"}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group has-text-color has-background" style="background-color:var(--wp--preset--color--accent);color:#ffffff;grid-column: span 2; grid-row: span 1; padding: 2rem; display: flex; align-items: center; justify-content: center;">
        <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.5rem","fontWeight":"bold"}}} -->
        <p class="has-text-align-center" style="font-size:1.5rem;font-weight:bold"><a href="/contact" style="color: inherit; text-decoration: underline;">Book Now</a></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
