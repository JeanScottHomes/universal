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
	var contactHeight = $('.landing_contact').height();

	$('.landing_content').css({ height: windowHeight - contactHeight + 'px' });

	$(window).resize(function () {
		// Image Section Height
		var windowHeight = $(window).height();
		var contactHeight = $('.landing_contact').height();

		$('.landing_content').css({ height: windowHeight - contactHeight + 'px' });
	});
});
