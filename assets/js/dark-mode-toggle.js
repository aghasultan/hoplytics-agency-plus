/**
 * Dark Mode Toggle — persists preference in localStorage.
 *
 * Reads OS preference via prefers-color-scheme, allows explicit toggle
 * via a button with class "dark-mode-toggle", and persists the choice.
 *
 * @package Hoplytics
 */

(function () {
    'use strict';

    const STORAGE_KEY = 'hoplytics-theme';
    const html = document.documentElement;

    /**
     * Get the current effective theme.
     * Priority: localStorage > OS preference > 'light'
     */
    const getPreferred = () => {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'dark' || stored === 'light') return stored;

        if (window.matchMedia?.('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }

        return 'light';
    };

    /**
     * Apply theme to <html> and update toggle button icon.
     */
    const apply = (theme) => {
        html.setAttribute('data-theme', theme);

        // Update all toggle button icons
        document.querySelectorAll('.dark-mode-toggle').forEach((btn) => {
            btn.textContent = theme === 'dark' ? '☀️' : '🌙';
            btn.setAttribute('aria-label',
                theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
            );
        });
    };

    // Apply on load (before paint, since this runs in <head> or early body)
    apply(getPreferred());

    // Listen for toggle clicks
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.dark-mode-toggle');
        if (!btn) return;

        const current = html.getAttribute('data-theme') || getPreferred();
        const next = current === 'dark' ? 'light' : 'dark';

        localStorage.setItem(STORAGE_KEY, next);
        apply(next);
    });

    // Listen for OS preference changes (when no explicit choice stored)
    window.matchMedia?.('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem(STORAGE_KEY)) {
            apply(e.matches ? 'dark' : 'light');
        }
    });
})();
