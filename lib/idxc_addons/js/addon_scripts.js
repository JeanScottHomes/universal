// Validation Scripts for add-ons

// Listings add-on

// Validate the price and price_sold field and do not allow anything other than numbers
jQuery(document).ready(function ($) {
	$(
		'#_idxc_mb_featuredlistings_price, #_idxc_mb_featuredlistings_price_sold, #_idxc_mb_rentals_price'
	).on('input', function () {
		// Remove non-digits and anything after a decimal point
		var sanitizedValue = this.value.replace(/[^0-9]+/g, '').replace(/\..*$/, '');
		if (sanitizedValue !== this.value) {
			// Alert the user or display a message
			alert(
				'Please enter whole numbers only without any symbols, commas, or decimal points.'
			);
			// Update the value with the sanitized value
			this.value = sanitizedValue;
		}
	});
});
