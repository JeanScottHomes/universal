jQuery(function ($) {
	if (document.location.hash) {
		window.setTimeout(function () {
			document.location.href += '';
		}, 10);
	}

	// Local Scroll Speed
	$.localScroll({
		duration: 750,
	});

	// Image Section Height
	var windowHeight = $(window).height();
	var windowWidth = $(window).width();
	var headerHeight = $('header.site-header').height();
	var underBannerArea = $('.under_banner_area').height() + 30; // 30px accounts for the padding
	var underBannerAreaAdjusted = 0;

	//if (underBannerArea <= 30) {underBannerAreaAdjusted = 0;} else {underBannerAreaAdjusted = headerHeight;}
	if (underBannerArea <= 30) {
		underBannerAreaAdjusted = 0;
	} else {
		underBannerAreaAdjusted = underBannerArea;
	}
	//if (windowWidth >= 1024) {underBannerAreaAdjusted = 0;}

	$('.slider').css({ height: windowHeight - underBannerAreaAdjusted + 'px' });
	$('.slider_content_container').css({ 'padding-top': headerHeight / 2 + 'px' });

	$(window).resize(function () {
		// Image Section Height
		var windowHeight = $(window).height();
		var windowWidth = $(window).width();
		var headerHeight = $('header.site-header').height();
		var underBannerArea = $('.under_banner_area').height() + 30; // 30px accounts for the padding
		var underBannerAreaAdjusted = 0;

		//if (underBannerArea <= 30) {underBannerAreaAdjusted = 0;} else {underBannerAreaAdjusted = headerHeight;}
		if (underBannerArea <= 30) {
			underBannerAreaAdjusted = 0;
		} else {
			underBannerAreaAdjusted = underBannerArea;
		}
		//if (windowWidth >= 1024) {underBannerAreaAdjusted = 0;}

		$('.slider').css({ height: windowHeight - underBannerAreaAdjusted + 'px' });
		$('.slider_content_container').css({ 'padding-top': headerHeight / 2 + 'px' });
	});
});
