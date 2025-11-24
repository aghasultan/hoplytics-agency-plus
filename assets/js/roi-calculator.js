document.addEventListener('DOMContentLoaded', function() {
    const calculators = document.querySelectorAll('.roi-calculator-wrapper');

    calculators.forEach(function(wrapper) {
        const trafficInput = wrapper.querySelector('.roi-traffic');
        const conversionInput = wrapper.querySelector('.roi-conversion');
        const clvInput = wrapper.querySelector('.roi-clv');
        const revenueOutput = wrapper.querySelector('.roi-revenue');

        function calculateRevenue() {
            const traffic = parseFloat(trafficInput.value) || 0;
            const conversion = parseFloat(conversionInput.value) || 0;
            const clv = parseFloat(clvInput.value) || 0;

            // Logic: (Traffic * (ConvRate/100)) * Value = Projected Revenue
            const conversions = traffic * (conversion / 100);
            const revenue = conversions * clv;

            revenueOutput.innerText = '$' + revenue.toLocaleString(undefined, {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        const inputs = [trafficInput, conversionInput, clvInput];
        inputs.forEach(input => {
            if (input) {
                input.addEventListener('input', calculateRevenue);
            }
        });

        // Initial calculation
        calculateRevenue();
    });
});
