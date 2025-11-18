// === follow-up-boss Custom Event Logging ===

console.log('✅ Loaded: follow-up-boss-events.js (FOOTER)');

// Logs property view clicks & search actions into Follow Up Boss
(function () {
	// Watch for property click events (iHomeFinder AJAX links)
	document.addEventListener('click', function (e) {
		const propertyLink = e.target.closest('a[href*="/idx/details"]');
		if (propertyLink) {
			const propertyURL = propertyLink.href;
			const propertyAddress = propertyLink.textContent.trim();

			// Send custom event into Follow Up Boss Pixel
			if (window.widgetTracker) {
				window.widgetTracker('send', 'event', {
					category: 'Property View',
					action: 'Viewed Property',
					label: propertyAddress,
					value: propertyURL,
				});
				console.log(`follow-up-boss Event Logged: Viewed ${propertyAddress}`);
			}
		}
	});

	// Watch for search submissions
	document.addEventListener('submit', function (e) {
		if (e.target.matches('form[action*="search"]')) {
			const query = new URLSearchParams(new FormData(e.target)).toString();
			if (window.widgetTracker) {
				window.widgetTracker('send', 'event', {
					category: 'Search',
					action: 'Ran Search',
					label: decodeURIComponent(query),
				});
				console.log(`follow-up-boss Event Logged: Search Query ${query}`);
			}
		}
	});
})();
