document.addEventListener('DOMContentLoaded', () => {

    // Add CSS for animations
    const style = document.createElement('style');
    style.innerHTML = `
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    `;
    document.head.appendChild(style);

    // Select elements to animate
    // We target common block elements, cards, and sections
    const targets = document.querySelectorAll('h1, h2, h3, p, .card, .btn, img, .wp-block-image, .step-item');

    targets.forEach(target => {
        target.classList.add('reveal-on-scroll');
    });

    // Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // Trigger when 10% of element is visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // Run once
            }
        });
    }, observerOptions);

    targets.forEach(target => {
        observer.observe(target);
    });
});
