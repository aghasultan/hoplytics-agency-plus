document.addEventListener('DOMContentLoaded', function() {
    const calculators = document.querySelectorAll('.roi-calculator-wrapper');

    calculators.forEach(function(wrapper) {
        const spendInput = wrapper.querySelector('.roi-spend');
        const roasInput = wrapper.querySelector('.roi-roas');
        const revenueOutput = wrapper.querySelector('.roi-revenue');
        const profitOutput = wrapper.querySelector('.roi-profit');

        // Helper to format currency
        const formatCurrency = (num) => {
            return '$' + num.toLocaleString(undefined, {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        };

        // Helper to update slider progress background
        const updateSliderBackground = (input) => {
            if (!input) return;
            const min = parseFloat(input.min) || 0;
            const max = parseFloat(input.max) || 100;
            const val = parseFloat(input.value) || 0;
            const percentage = ((val - min) / (max - min)) * 100;

            // This assumes a CSS variable or specific styling will be used,
            // but setting background-size or linear-gradient directly is robust for webkit sliders.
            // We use a linear gradient: filled part (green) + empty part (gray)
            // Color codes match the plan (success green approx #10B981) and gray (#E5E7EB)
            input.style.background = `linear-gradient(to right, #10B981 ${percentage}%, #E5E7EB ${percentage}%)`;
        };

        function updateCalculator() {
            const spend = parseFloat(spendInput.value) || 0;
            const roas = parseFloat(roasInput.value) || 0;

            // Update Value Displays next to sliders
            const spendDisplay = wrapper.querySelector(`.roi-value-display[data-target="${spendInput.id}"]`);
            if (spendDisplay) spendDisplay.innerText = formatCurrency(spend);

            const roasDisplay = wrapper.querySelector(`.roi-value-display[data-target="${roasInput.id}"]`);
            if (roasDisplay) roasDisplay.innerText = roas.toFixed(1) + 'x';

            // Logic
            const revenue = spend * roas;
            const profit = revenue - spend;

            // Update Results
            if (revenueOutput) revenueOutput.innerText = formatCurrency(revenue);
            if (profitOutput) profitOutput.innerText = formatCurrency(profit);

            // Update Slider Visuals
            updateSliderBackground(spendInput);
            updateSliderBackground(roasInput);
        }

        const inputs = [spendInput, roasInput];
        inputs.forEach(input => {
            if (input) {
                input.addEventListener('input', updateCalculator);
                // Initial background set
                updateSliderBackground(input);
            }
        });

        // Initial calculation
        updateCalculator();
    });
});
