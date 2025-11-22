(function() {
    const body = document.body;
    const nav = document.getElementById('site-navigation');
    const toggle = document.querySelector('.menu-toggle');

    if (!nav || !toggle) {
        return;
    }

    const primaryMenu = document.getElementById('primary-menu');

    const closeMenu = () => {
        body.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
    };

    const openMenu = () => {
        body.classList.add('nav-open');
        toggle.setAttribute('aria-expanded', 'true');
        nav.classList.add('is-open');
    };

    toggle.addEventListener('click', () => {
        const isOpen = body.classList.contains('nav-open');
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
            toggle.focus();
        }
    });

    document.addEventListener('keyup', (event) => {
        if (event.key === 'Escape' && body.classList.contains('nav-open')) {
            closeMenu();
            toggle.focus();
        }
    });

    nav.addEventListener('click', (event) => {
        if (event.target.closest('a') && body.classList.contains('nav-open')) {
            closeMenu();
        }
    });

    if (primaryMenu) {
        primaryMenu.querySelectorAll('a').forEach((link) => {
            link.setAttribute('tabindex', '0');
        });
    }
})();
