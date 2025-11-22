<?php
/**
 * Template Name: Style Guide
 *
 * A custom page template to visualize the design system.
 *
 * @package Agency_Plus
 */

get_header();
?>

<div class="container inner-wrapper">

    <header class="page-header-centered">
        <h1 class="page-title">Design System</h1>
        <p class="page-subtitle">A live reference of the theme's typography, colors, and components.</p>
    </header>

    <!-- Colors -->
    <section class="section">
        <h2>Colors</h2>
        <div class="grid grid-3">
            <div class="card">
                <div style="height: 100px; background-color: var(--color-primary); border-radius: var(--radius-md);"></div>
                <h4 style="margin-top: 1rem;">Primary</h4>
                <code>--color-primary</code>
            </div>
            <div class="card">
                <div style="height: 100px; background-color: var(--color-secondary); border-radius: var(--radius-md);"></div>
                <h4 style="margin-top: 1rem;">Secondary</h4>
                <code>--color-secondary</code>
            </div>
            <div class="card">
                <div style="height: 100px; background-color: var(--color-accent); border-radius: var(--radius-md);"></div>
                <h4 style="margin-top: 1rem;">Accent</h4>
                <code>--color-accent</code>
            </div>
             <div class="card">
                <div style="height: 100px; background-color: var(--color-text); border-radius: var(--radius-md);"></div>
                <h4 style="margin-top: 1rem;">Text</h4>
                <code>--color-text</code>
            </div>
             <div class="card">
                <div style="height: 100px; background-color: var(--color-bg-alt); border-radius: var(--radius-md); border: 1px solid #ddd;"></div>
                <h4 style="margin-top: 1rem;">Background Alt</h4>
                <code>--color-bg-alt</code>
            </div>
        </div>
    </section>

    <!-- Typography -->
    <section class="section">
        <h2>Typography</h2>
        <div class="card">
            <h1>Heading 1</h1>
            <h2>Heading 2</h2>
            <h3>Heading 3</h3>
            <h4>Heading 4</h4>
            <h5>Heading 5</h5>
            <h6>Heading 6</h6>
            <p><strong>Body Text:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <p><small>Small Text: This is fine print.</small></p>
        </div>
    </section>

    <!-- Buttons -->
    <section class="section">
        <h2>Buttons</h2>
        <div class="flex gap-4" style="flex-wrap: wrap;">
            <a href="#" class="btn btn-primary">Primary Button</a>
            <a href="#" class="btn btn-secondary">Secondary Button</a>
            <a href="#" class="btn btn-accent">Accent Button</a>
            <a href="#" class="btn btn-primary btn-sm">Small Button</a>
        </div>
    </section>

    <!-- Form Elements -->
    <section class="section">
        <h2>Form Elements</h2>
        <div class="card" style="max-width: 600px;">
            <form>
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="John Doe">

                <label for="email">Email</label>
                <input type="email" id="email" placeholder="john@example.com">

                <label for="message">Message</label>
                <textarea id="message" rows="4" placeholder="Type your message..."></textarea>

                <button type="submit" class="btn btn-primary">Submit Form</button>
            </form>
        </div>
    </section>

</div>

<?php
get_footer();
