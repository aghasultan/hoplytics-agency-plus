document.addEventListener('DOMContentLoaded', () => {
    const hour = new Date().getHours();
    const body = document.body;

    // Dynamic Greeting Logic
    // 7PM (19) to 6AM (6) is "Night"
    const isNight = hour >= 19 || hour < 6;

    if (isNight) {
        console.log('Night mode activated automatically.');
        body.classList.add('dark-mode');
    }

    // Dynamic Hero Text
    const heroTitle = document.querySelector('.hero-content h1');
    if (heroTitle) {
        let greeting = "";
        if (hour >= 5 && hour < 12) greeting = "Good Morning, Creator.";
        else if (hour >= 12 && hour < 18) greeting = "Good Afternoon, Creator.";
        else greeting = "Good Evening, Creator.";

        const greetingEl = document.createElement('span');
        greetingEl.style.display = 'block';
        greetingEl.style.fontSize = '1rem';
        greetingEl.style.color = 'var(--color-secondary)';
        greetingEl.style.marginBottom = '0.5rem';
        greetingEl.style.textTransform = 'uppercase';
        greetingEl.style.letterSpacing = '0.05em';
        greetingEl.textContent = greeting;

        heroTitle.parentNode.insertBefore(greetingEl, heroTitle);
    }
});
