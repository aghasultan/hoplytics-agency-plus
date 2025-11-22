document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('roi-calculate-btn');
    if (!btn) return;

    const ctx = document.getElementById('roiChart').getContext('2d');
    let roiChart = null;

    btn.addEventListener('click', function() {
        const budget = parseFloat(document.getElementById('roi-budget').value) || 0;
        const cpc = parseFloat(document.getElementById('roi-cpc').value) || 0;
        const conversion = parseFloat(document.getElementById('roi-conversion').value) || 0;
        const aov = parseFloat(document.getElementById('roi-aov').value) || 0;

        if (cpc === 0) return;

        const traffic = budget / cpc;
        const leads = traffic * (conversion / 100);
        const revenue = leads * aov;
        const roas = revenue / budget;

        // Update Text
        document.getElementById('roi-revenue').textContent = '$' + revenue.toLocaleString(undefined, {maximumFractionDigits: 0});
        document.getElementById('roi-roas').textContent = roas.toFixed(2) + 'x';
        document.getElementById('roi-text-results').style.display = 'block';

        // Render Chart
        if (roiChart) roiChart.destroy();

        roiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Spend', 'Revenue'],
                datasets: [{
                    label: 'ROI Projection',
                    data: [budget, revenue],
                    backgroundColor: [
                        'rgba(203, 213, 225, 0.8)', // Slate 300
                        'rgba(16, 185, 129, 0.8)'   // Emerald 500
                    ],
                    borderColor: [
                        'rgba(203, 213, 225, 1)',
                        'rgba(16, 185, 129, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Simulate "Gating" logic - show email form after calculation
        // setTimeout(() => { document.getElementById('roi-gate').style.display = 'block'; }, 2000);
    });
});
