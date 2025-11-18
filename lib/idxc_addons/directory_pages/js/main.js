// Related Scripts

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
	var contactHeight = 0; // Used if you only have one element and want it fullscreen
	//var contactHeight = $( '.ADDITIONAL_ELEMENT_CLASS' ).height();        // Use if you want to recduce the height of the main element by a second element

	$('#directory_main').css({ height: windowHeight - contactHeight + 'px' });

	$(window).resize(function () {
		// Image Section Height
		var windowHeight = $(window).height();
		var contactHeight = 0; // Used if you only have one element and want it fullscreen
		//var contactHeight = $( '.ADDITIONAL_ELEMENT_CLASS' ).height();        // Use if you want to recduce the height of the main element by a second element

		$('#directory_main').css({ height: windowHeight - contactHeight + 'px' });
	});
});
