/**
 * Mobile Navigation — Interactivity API Module.
 *
 * Handles menu toggle, body class, focus trap, Escape key, and click-outside.
 */

import { store, getContext } from '@wordpress/interactivity';

store('hoplytics/mobile-nav', {
    actions: {
        toggle() {
            const ctx = getContext();
            ctx.isOpen = !ctx.isOpen;

            document.body.classList.toggle('nav-open', ctx.isOpen);

            const nav = document.getElementById('site-navigation');
            if (!nav) return;

            nav.classList.toggle('is-open', ctx.isOpen);

            if (ctx.isOpen) {
                // Focus first link in nav after opening
                const firstLink = nav.querySelector('a[href], button');
                if (firstLink) {
                    setTimeout(() => firstLink.focus(), 100);
                }
            }
        },

        close() {
            const ctx = getContext();
            ctx.isOpen = false;
            document.body.classList.remove('nav-open');

            const nav = document.getElementById('site-navigation');
            if (nav) {
                nav.classList.remove('is-open');
            }
        },
    },

    callbacks: {
        /**
         * Runs on init — sets up global listeners for Escape key and click-outside.
         */
        init() {
            document.addEventListener('keyup', (event) => {
                if (event.key === 'Escape' && document.body.classList.contains('nav-open')) {
                    const ctx = getContext();
                    ctx.isOpen = false;
                    document.body.classList.remove('nav-open');

                    const nav = document.getElementById('site-navigation');
                    if (nav) nav.classList.remove('is-open');

                    // Return focus to toggle button
                    const toggle = document.querySelector('.menu-toggle');
                    if (toggle) toggle.focus();
                }
            });

            // Close on click outside nav
            document.addEventListener('click', (event) => {
                if (!document.body.classList.contains('nav-open')) return;

                const nav = document.getElementById('site-navigation');
                const toggle = document.querySelector('.menu-toggle');

                if (
                    nav &&
                    !nav.contains(event.target) &&
                    toggle &&
                    !toggle.contains(event.target)
                ) {
                    const ctx = getContext();
                    ctx.isOpen = false;
                    document.body.classList.remove('nav-open');
                    nav.classList.remove('is-open');
                }
            });
        },
    },
});
