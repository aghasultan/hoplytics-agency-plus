/**
 * Main theme interactions for Hoplytics.
 * Handles mobile navigation toggling and header behaviors.
 */

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const header = document.querySelector('.site-header');
    const nav = document.getElementById('site-navigation');
    const toggle = document.querySelector('.menu-toggle');
    const mobileQuery = window.matchMedia('(max-width: 900px)');
    const desktopQuery = window.matchMedia('(min-width: 901px)');

    const closeMenu = () => {
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
        }

        if (nav) {
            nav.classList.remove('is-open');
        }

        body.classList.remove('menu-open');
    };

    const openMenu = () => {
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'true');
        }

        if (nav) {
            nav.classList.add('is-open');
        }

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
            if (target instanceof HTMLElement && target.closest('a') && mobileQuery.matches) {
                closeMenu();
            }
        });

        document.addEventListener('keyup', (event) => {
            if (event.key === 'Escape' && nav.classList.contains('is-open')) {
                closeMenu();
            }
        });

        // Close menu when the viewport changes to desktop size
        const handleViewportChange = (event) => {
            if (!event.matches) {
                closeMenu();
            }
        };

        desktopQuery.addEventListener('change', handleViewportChange);
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
