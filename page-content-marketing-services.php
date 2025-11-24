<?php
/**
 * Template Name: Content Marketing
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
                <div class="hero-content mx-auto text-center" style="align-items: center;">
                    <h1>Content That Closes Deals Before You Even Speak.</h1>
                    <p class="text-lg">Turn your expertise into a library of trust. We build Case Studies and White Papers that position you as the leader.</p>
                    <div class="mt-4">
                        <a href="#contact" class="btn btn-primary">See Content Examples</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Framework Section -->
        <section class="framework-section section bg-alt">
            <div class="container">
                <div class="grid grid-2 items-center">
                    <div class="framework-content">
                        <h2>The "Hub & Spoke" Model</h2>
                        <p class="text-lg mb-6">Maximum output, minimal time.</p>
                        <p class="mb-4">We create one massive <strong>"Pillar Asset"</strong> (like a White Paper or Deep-Dive Guide) and slice it into micro-content for every channel.</p>

                        <div class="card p-6 border-primary mt-6">
                            <h3 class="text-lg font-bold mb-3">One Pillar Asset Becomes:</h3>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="text-primary font-bold">10</span> LinkedIn Posts
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-primary font-bold">5</span> Email Newsletters
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-primary font-bold">3</span> Short-Form Videos
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="framework-visual">
                        <div class="hub-spoke-visual p-8 text-center">
                            <!-- Hub -->
                            <div class="hub bg-primary text-white p-6 rounded-full inline-block mb-8 relative z-10 shadow-lg">
                                <span class="font-bold text-lg">Pillar Content</span>
                            </div>

                            <!-- Spokes Visual (CSS Lines could be complex, using simple grid for clarity) -->
                            <div class="grid grid-3 gap-4">
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Blog Posts</span>
                                </div>
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Social Snippets</span>
                                </div>
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Email Series</span>
                                </div>
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Infographics</span>
                                </div>
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Video Scripts</span>
                                </div>
                                <div class="spoke card p-3 bg-alt border-gray-200">
                                    <span class="font-bold text-sm">Webinars</span>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-muted">1 Asset → 6+ Channels</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

<?php
get_footer();
