document.addEventListener('DOMContentLoaded', () => {
    const initializeROICalculators = () => {
        const calculators = document.querySelectorAll('.wp-block-hoplytics-roi-calculator');

        calculators.forEach(container => {
            // Select elements scoped to this container
            const adSpendRange = container.querySelector('.roi-ad-spend-range');
            const adSpendNumber = container.querySelector('.roi-ad-spend-number');
            const closeRateRange = container.querySelector('.roi-close-rate-range');
            const closeRateNumber = container.querySelector('.roi-close-rate-number');
            const dealValueInput = container.querySelector('.roi-deal-value');
            const revenueDisplay = container.querySelector('.roi-revenue-display');

            const CPL_CONSTANT = 50;

            const updateCalculation = () => {
                const adSpend = parseFloat(adSpendNumber.value) || 0;
                const closeRate = parseFloat(closeRateNumber.value) || 0;
                const dealValue = parseFloat(dealValueInput.value) || 0;

                // Logic: (Ad Spend / CPL_Constant) * (Close Rate / 100) * Deal Value
                // (5000 / 50) * (20/100) * 1000 = 100 * 0.2 * 1000 = 20 * 1000 = 20000
                const revenue = (adSpend / CPL_CONSTANT) * (closeRate / 100) * dealValue;

                // Format output
                const formattedRevenue = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    maximumFractionDigits: 0
                }).format(revenue);

                if (revenueDisplay) {
                    revenueDisplay.textContent = formattedRevenue;
                }
            };

            const syncInputs = (source, target) => {
                target.value = source.value;
                updateCalculation();
            };

            // Event Listeners
            if (adSpendRange && adSpendNumber) {
                adSpendRange.addEventListener('input', () => syncInputs(adSpendRange, adSpendNumber));
                adSpendNumber.addEventListener('input', () => syncInputs(adSpendNumber, adSpendRange));
            }

            if (closeRateRange && closeRateNumber) {
                closeRateRange.addEventListener('input', () => syncInputs(closeRateRange, closeRateNumber));
                closeRateNumber.addEventListener('input', () => syncInputs(closeRateNumber, closeRateRange));
            }

            if (dealValueInput) {
                dealValueInput.addEventListener('input', updateCalculation);
            }

            // Initial calculation
            updateCalculation();
        });
    };

    // Initialize on load
    initializeROICalculators();
});
