document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('a');
    const prefetchCache = new Set();

    const prefetchLink = (url) => {
        if (prefetchCache.has(url)) return;
        prefetchCache.add(url);

        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);
        console.log(`Prefetching: ${url}`);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const url = entry.target.href;
                // Only prefetch internal links
                if (url && url.startsWith(window.location.origin)) {
                    prefetchLink(url);
                    observer.unobserve(entry.target);
                }
            }
        });
    });

    links.forEach(link => {
        // Option 1: Prefetch on hover (more conservative)
        link.addEventListener('mouseenter', () => {
            const url = link.href;
            if (url && url.startsWith(window.location.origin)) {
                prefetchLink(url);
            }
        });

        // Option 2: Prefetch when link enters viewport (more aggressive, use carefully)
        // observer.observe(link);
    });
});
