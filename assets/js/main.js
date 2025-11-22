/**
 * Main theme interactions for Hoplytics.
 * Handles mobile navigation toggling and header behaviors.
 */

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const header = document.querySelector('.site-header');
    const nav = document.getElementById('site-navigation');
    const toggle = document.querySelector('.menu-toggle');

    const closeMenu = () => {
        toggle?.setAttribute('aria-expanded', 'false');
        nav?.classList.remove('is-open');
        body.classList.remove('menu-open');
    };

    const openMenu = () => {
        toggle?.setAttribute('aria-expanded', 'true');
        nav?.classList.add('is-open');
        body.classList.add('menu-open');
    };

    // Mobile Menu Toggle
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        nav.addEventListener('click', (event) => {
            const target = event.target;
            if (target instanceof HTMLElement && target.closest('a') && window.matchMedia('(max-width: 900px)').matches) {
                closeMenu();
            }
        });

        // Close menu when resizing to desktop
        window.addEventListener('resize', () => {
            if (window.matchMedia('(min-width: 901px)').matches) {
                closeMenu();
            }
        });
    }

    // Header scroll interaction
    if (header) {
        let isTicking = false;

        const updateHeaderState = () => {
            const scrolled = window.scrollY > 10;
            header.classList.toggle('is-scrolled', scrolled);
            isTicking = false;
        };

        const onScroll = () => {
            if (!isTicking) {
                window.requestAnimationFrame(updateHeaderState);
                isTicking = true;
            }
        };

        updateHeaderState();
        window.addEventListener('scroll', onScroll, { passive: true });
    }
});
