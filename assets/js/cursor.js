document.addEventListener('DOMContentLoaded', () => {
    // Check if device has mouse (not touch)
    if (matchMedia('(pointer:fine)').matches) {

        // Create Cursor Element
        const cursor = document.createElement('div');
        cursor.id = 'custom-cursor';
        document.body.appendChild(cursor);

        // Basic Styles (injected here to avoid CSS clutter, or could be in style.css)
        const style = document.createElement('style');
        style.innerHTML = `
            #custom-cursor {
                width: 20px;
                height: 20px;
                border: 2px solid var(--color-secondary, #3b82f6);
                border-radius: 50%;
                position: fixed;
                pointer-events: none;
                z-index: 9999;
                transform: translate(-50%, -50%);
                transition: width 0.2s, height 0.2s, background-color 0.2s, border-color 0.2s;
                mix-blend-mode: difference;
            }
            #custom-cursor.hovered {
                width: 50px;
                height: 50px;
                background-color: rgba(59, 130, 246, 0.1);
                border-color: transparent;
                mix-blend-mode: normal;
            }
            body {
                cursor: none; /* Hide default cursor */
            }
            a, button, input, textarea, .btn {
                cursor: none; /* Ensure elements don't show default cursor */
            }
        `;
        document.head.appendChild(style);

        // Movement Logic
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        // Hover Effects
        const interactiveElements = document.querySelectorAll('a, button, .btn, input, textarea');

        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.classList.add('hovered');
            });
            el.addEventListener('mouseleave', () => {
                cursor.classList.remove('hovered');
            });
        });
    }
});
