jQuery(document).ready(function () {
	let isMobile = window.matchMedia('only screen and (max-width:1023px)').matches;

	// Set delay to allow iframe to load so script will be able to remove the iframe if necessary
	setTimeout(function () {
		// remove iframe elements with the class .video_banner
		if (isMobile) {
			var iframes = document.querySelectorAll('iframe.video_banner');
			for (var i = 0; i < iframes.length; i++) {
				iframes[i].parentNode.removeChild(iframes[i]);
			}
		}

		// remove elements with the class .video_poster
		if (isMobile) {
			var mobile_hidden = document.querySelectorAll('.video_poster');
			for (var j = 0; j < mobile_hidden.length; j++) {
				mobile_hidden[j].parentNode.removeChild(mobile_hidden[j]);
			}
			// Add class keep_active so we can override the video poster image with the first banner image on smaller devices.
			jQuery('.video_poster_mobile').addClass('keep_active');
			jQuery('.video_bg').addClass('is_mobile');
		}
	}, 250); // Wait time in milliseconds (1000 = 1 second)
});
