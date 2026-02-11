/**
 * Scroll Animations — Intersection Observer powered.
 *
 * Adds 'is-visible' class to elements with [data-animate] or [data-stagger]
 * when they enter the viewport. Also handles number counter animations.
 *
 * @package Hoplytics
 */

(function () {
    'use strict';

    // ─── Scroll-triggered reveal ───

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -50px 0px',
        threshold: 0.1,
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // ─── Number Counter Animation ───

    function animateNumber(el) {
        const target = parseInt(el.dataset.countTo, 10);
        if (isNaN(target)) return;

        const suffix = el.dataset.countSuffix || '';
        const prefix = el.dataset.countPrefix || '';
        const duration = parseInt(el.dataset.countDuration, 10) || 2000;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(target * eased);
            el.textContent = prefix + current.toLocaleString() + suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    // ─── Typing Animation ───

    function initTypingAnimation(el) {
        const phrases = JSON.parse(el.dataset.typing || '[]');
        if (!phrases.length) return;

        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let speed = 80;

        function type() {
            const currentPhrase = phrases[phraseIndex];

            if (isDeleting) {
                el.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                speed = 40;
            } else {
                el.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                speed = 80;
            }

            if (!isDeleting && charIndex === currentPhrase.length) {
                // Pause before deleting
                speed = 2000;
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                speed = 300;
            }

            setTimeout(type, speed);
        }

        type();
    }

    // ─── Reading Progress Bar ───

    function initReadingProgress() {
        const bar = document.querySelector('.reading-progress-bar');
        if (!bar) return;

        const article = document.querySelector('article, .entry-content, main');
        if (!article) return;

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const progress = Math.min(Math.max((scrollTop - articleTop) / (articleHeight - windowHeight), 0), 1);
            bar.style.transform = `scaleX(${progress})`;
        }, { passive: true });
    }

    // ─── Initialize ───

    function init() {
        // Respect prefers-reduced-motion
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (reducedMotion) {
            // Show everything immediately
            document.querySelectorAll('[data-animate], [data-stagger]').forEach((el) => {
                el.classList.add('is-visible');
            });
        } else {
            // Observe animations
            document.querySelectorAll('[data-animate], [data-stagger]').forEach((el) => {
                revealObserver.observe(el);
            });
        }

        // Counter animations
        document.querySelectorAll('[data-count-to]').forEach((el) => {
            counterObserver.observe(el);
        });

        // Typing animations
        document.querySelectorAll('[data-typing]').forEach((el) => {
            initTypingAnimation(el);
        });

        // Reading progress
        initReadingProgress();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
