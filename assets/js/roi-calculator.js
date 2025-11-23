document.addEventListener('DOMContentLoaded', function() {
    const calculators = document.querySelectorAll('.roi-calculator-wrapper');

    calculators.forEach(function(wrapper) {
        const budgetInput = wrapper.querySelector('.roi-budget');
        const cpcInput = wrapper.querySelector('.roi-cpc');
        const conversionInput = wrapper.querySelector('.roi-conversion');
        const aovInput = wrapper.querySelector('.roi-aov');
        const revenueOutput = wrapper.querySelector('.roi-revenue');
        const roasOutput = wrapper.querySelector('.roi-roas');
        const resultsContainer = wrapper.querySelector('.roi-text-results');
        const chartCanvas = wrapper.querySelector('.roi-chart-canvas');
        let roiChart = null;

        function calculateROI() {
            const budget = parseFloat(budgetInput.value) || 0;
            const cpc = parseFloat(cpcInput.value) || 0;
            const conversion = parseFloat(conversionInput.value) || 0;
            const aov = parseFloat(aovInput.value) || 0;

            if (cpc <= 0) {
                revenueOutput.innerText = '$0';
                roasOutput.innerText = '0x';
                return;
            }

            const clicks = budget / cpc;
            const conversions = clicks * (conversion / 100);
            const revenue = conversions * aov;
            const roas = budget > 0 ? revenue / budget : 0;

            revenueOutput.innerText = '$' + revenue.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
            roasOutput.innerText = roas.toFixed(2) + 'x';
            resultsContainer.style.display = 'block';

            updateChart(budget, revenue);
        }

        function updateChart(cost, revenue) {
            if (typeof Chart === 'undefined' || !chartCanvas) return;

            if (roiChart) {
                roiChart.data.datasets[0].data = [cost, revenue];
                roiChart.update();
            } else {
                const ctx = chartCanvas.getContext('2d');
                roiChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Cost', 'Revenue'],
                        datasets: [{
                            label: 'Amount ($)',
                            data: [cost, revenue],
                            backgroundColor: [
                                'rgba(255, 255, 255, 0.3)',
                                'rgba(16, 185, 129, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 255, 255, 0.5)',
                                'rgba(16, 185, 129, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        const inputs = [budgetInput, cpcInput, conversionInput, aovInput];
        inputs.forEach(input => {
            if (input) {
                input.addEventListener('input', calculateROI);
            }
        });

        // Initial calculation
        if (budgetInput) {
            calculateROI();
        }
    });
});
