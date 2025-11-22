document.addEventListener('keydown', (e) => {
    // Toggle Grid with 'G' key (Shift+G to avoid accidental typing)
    if (e.shiftKey && e.key.toLowerCase() === 'g') {
        toggleGrid();
    }
});

function toggleGrid() {
    let grid = document.getElementById('dev-grid-overlay');

    if (grid) {
        grid.remove();
        console.log('Grid hidden');
    } else {
        grid = document.createElement('div');
        grid.id = 'dev-grid-overlay';
        grid.style.position = 'fixed';
        grid.style.top = '0';
        grid.style.left = '50%';
        grid.style.transform = 'translateX(-50%)';
        grid.style.width = '100%';
        grid.style.maxWidth = 'var(--container-width, 1200px)';
        grid.style.height = '100vh';
        grid.style.zIndex = '10000';
        grid.style.pointerEvents = 'none';
        grid.style.display = 'grid';
        grid.style.gridTemplateColumns = 'repeat(12, 1fr)';
        grid.style.gap = 'var(--spacing-md, 1rem)';
        grid.style.padding = '0 var(--spacing-md, 1rem)';
        grid.style.opacity = '0.1';

        for (let i = 0; i < 12; i++) {
            const col = document.createElement('div');
            col.style.backgroundColor = 'red';
            col.style.height = '100%';
            grid.appendChild(col);
        }

        document.body.appendChild(grid);
        console.log('Grid visible');
    }
}
