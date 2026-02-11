/**
 * Hoplytics AJAX Forms — fetch-based form submission to REST API.
 *
 * Handles hero lead form and SEO audit form with inline feedback
 * and loading states. Falls back gracefully when JS is disabled.
 *
 * @package Hoplytics
 */

(function () {
    'use strict';

    const API_BASE = window.hoplyticsApi?.restUrl ?? '/wp-json/hoplytics/v1';
    const NONCE = window.hoplyticsApi?.nonce ?? '';

    /**
     * Submit a form via REST API with loading states and inline feedback.
     *
     * @param {HTMLFormElement} form
     * @param {string}         endpoint
     * @param {Function}       getData   Returns an object of form values.
     */
    const handleForm = async (form, endpoint, getData) => {
        const btn = form.querySelector('button[type="submit"]');
        const origText = btn?.textContent ?? 'Submit';

        // Set loading state
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Sending...';
        }

        // Remove old feedback
        const oldMsg = form.querySelector('.form-feedback');
        if (oldMsg) oldMsg.remove();

        try {
            const response = await fetch(`${API_BASE}/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': NONCE,
                },
                body: JSON.stringify(getData()),
            });

            const data = await response.json();
            const isSuccess = response.ok && data.success;

            // Show inline message
            const msg = document.createElement('div');
            msg.className = `form-feedback ${isSuccess ? 'form-success' : 'form-error'}`;
            msg.setAttribute('role', 'alert');
            msg.textContent = data.message || (isSuccess ? 'Submitted!' : 'Something went wrong.');
            form.appendChild(msg);

            if (isSuccess) {
                form.reset();
            }
        } catch {
            const msg = document.createElement('div');
            msg.className = 'form-feedback form-error';
            msg.setAttribute('role', 'alert');
            msg.textContent = 'Network error. Please try again.';
            form.appendChild(msg);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.textContent = origText;
            }
        }
    };

    // --- Hero Lead Form ---
    const heroForm = document.querySelector('.hero-application-form');
    if (heroForm) {
        heroForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleForm(heroForm, 'lead', () => ({
                name: heroForm.querySelector('[name="name"]')?.value ?? '',
                email: heroForm.querySelector('[name="email"]')?.value ?? '',
                website: heroForm.querySelector('[name="website_url"]')?.value ?? '',
                budget: heroForm.querySelector('[name="ad_budget"]')?.value ?? '',
            }));
        });
    }

    // --- SEO Audit Form ---
    const auditForm = document.querySelector('.seo-audit-form');
    if (auditForm) {
        auditForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleForm(auditForm, 'seo-audit', () => ({
                url: auditForm.querySelector('[name="audit_url"]')?.value ?? '',
                email: auditForm.querySelector('[name="audit_email"]')?.value ?? '',
            }));
        });
    }
})();
