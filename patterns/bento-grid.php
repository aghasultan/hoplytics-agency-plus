<?php
/**
 * Title: Bento Grid
 * Slug: hoplytics/bento-grid
 * Categories: featured
 * Description: A bento grid layout for the front page.
 */
?>
<!-- wp:group {"align":"full","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null},"style":{"spacing":{"blockGap":"var:preset|spacing|50"}}} -->
<div class="wp-block-group alignfull">
    <!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"primary","textColor":"white"} -->
    <div class="wp-block-group has-white-color has-primary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
        <!-- wp:heading {"level":1} -->
        <h1 class="wp-block-heading">We Build Digital Ecosystems.</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p>Specializing in FSE, Headless WP, and AI Integrations.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base"} -->
    <div class="wp-block-group has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading">Services</h3>
        <!-- /wp:heading -->

        <!-- wp:list -->
        <ul>
            <!-- wp:list-item -->
            <li>Fullstack Architecture</li>
            <!-- /wp:list-item -->

            <!-- wp:list-item -->
            <li>Next.js Integration</li>
            <!-- /wp:list-item -->

            <!-- wp:list-item -->
            <li>Block Theme Dev</li>
            <!-- /wp:list-item -->

            <!-- wp:list-item -->
            <li>Automated QA</li>
            <!-- /wp:list-item -->
        </ul>
        <!-- /wp:list -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base"} -->
    <div class="wp-block-group has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading">Engineering Logs</h3>
        <!-- /wp:heading -->

        <!-- wp:latest-posts {"postsToShow":3,"displayPostDate":true} /-->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
