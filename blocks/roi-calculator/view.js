/**
 * ROI Calculator — Interactivity API Module.
 *
 * Replaces vanilla JS DOM manipulation with WordPress reactive store.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/interactivity-api/
 */

import { store, getContext } from '@wordpress/interactivity';

const formatCurrency = ( value ) => {
	return new Intl.NumberFormat( 'en-US', {
		style: 'currency',
		currency: 'USD',
		maximumFractionDigits: 0,
	} ).format( value );
};

const recalculate = ( ctx ) => {
	const revenue =
		( ctx.adSpend / ctx.cplConstant ) * ( ctx.closeRate / 100 ) * ctx.dealValue;
	ctx.revenue = formatCurrency( revenue );
};

store( 'hoplytics/roi-calculator', {
	actions: {
		updateAdSpend() {
			const ctx = getContext();
			ctx.adSpend = parseFloat( getContext().adSpend ) || 0;
			const el = event.target;
			ctx.adSpend = parseFloat( el.value ) || 0;
			recalculate( ctx );
		},
		updateCloseRate() {
			const ctx = getContext();
			const el = event.target;
			ctx.closeRate = parseFloat( el.value ) || 0;
			recalculate( ctx );
		},
		updateDealValue() {
			const ctx = getContext();
			const el = event.target;
			ctx.dealValue = parseFloat( el.value ) || 0;
			recalculate( ctx );
		},
	},
} );
