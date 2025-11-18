const HOMES_FOR_SALE_OFFSET = 0; // Adjust to change where the anchor stops relative to the top

document.addEventListener('DOMContentLoaded', function () {
	const scrollWithOffset = (selector, offset) => {
		const el = document.querySelector(selector);
		if (el) {
			const y = el.getBoundingClientRect().top + window.pageYOffset - offset;
			window.scrollTo({ top: y, behavior: 'smooth' });
		}
	};

	document.querySelectorAll('a[href="#homes-for-sale"]').forEach((link) => {
		link.addEventListener('click', function (e) {
			e.preventDefault();
			scrollWithOffset('#homes-for-sale', HOMES_FOR_SALE_OFFSET);
		});
	});
});

// On full page load with hash, scroll with offset manually
window.addEventListener('load', function () {
	const hash = window.location.hash;
	if (hash === '#homes-for-sale') {
		setTimeout(() => {
			const el = document.querySelector(hash);
			if (el) {
				const y = el.getBoundingClientRect().top + window.pageYOffset - HOMES_FOR_SALE_OFFSET;
				window.scrollTo({ top: y, behavior: 'smooth' });
			}
		}, 200); // Adjust delay if needed
	}
});
