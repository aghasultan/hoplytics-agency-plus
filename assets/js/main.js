(function() {
    const body = document.body;
    const nav = document.getElementById('site-navigation');
    const toggle = document.querySelector('.menu-toggle');

    if (!nav || !toggle) {
        return;
    }

    // Focus trapping variables
    const focusableElements = nav.querySelectorAll('a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select');
    const firstFocusableElement = focusableElements[0];
    const lastFocusableElement = focusableElements[focusableElements.length - 1];

    const closeMenu = () => {
        body.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
        toggle.focus(); // Return focus to toggle
    };

    const openMenu = () => {
        body.classList.add('nav-open');
        toggle.setAttribute('aria-expanded', 'true');
        nav.classList.add('is-open');

        // Move focus to first element in nav
        if (firstFocusableElement) {
            setTimeout(() => {
                firstFocusableElement.focus();
            }, 100);
        }
    };

    toggle.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent immediate close from document click
        const isOpen = body.classList.contains('nav-open');
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    document.addEventListener('keyup', (event) => {
        if (event.key === 'Escape' && body.classList.contains('nav-open')) {
            closeMenu();
        }
    });

    // Focus Trap inside Menu
    nav.addEventListener('keydown', (e) => {
        if (!body.classList.contains('nav-open')) return;

        const isTabPressed = (e.key === 'Tab' || e.keyCode === 9);
        if (!isTabPressed) return;

        if (e.shiftKey) { // Shift + Tab
            if (document.activeElement === firstFocusableElement) {
                lastFocusableElement.focus();
                e.preventDefault();
            }
        } else { // Tab
            if (document.activeElement === lastFocusableElement) {
                firstFocusableElement.focus();
                e.preventDefault();
            }
        }
    });

    // Close on click outside or on link click
    document.addEventListener('click', (event) => {
        if (!body.classList.contains('nav-open')) return;

        const isClickInsideNav = nav.contains(event.target);
        const isClickOnToggle = toggle.contains(event.target);

        if (!isClickInsideNav && !isClickOnToggle) {
            closeMenu();
        }
    });

    nav.addEventListener('click', (event) => {
        if (event.target.closest('a') && body.classList.contains('nav-open')) {
            closeMenu();
        }
    });
})();
