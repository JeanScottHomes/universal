<?php 


    $files = cmb2_get_option( 'md_main_options', 'banner_image_list', 1 );

    // Create an image counter
    $banner_image_count = 0;    

	// Loop through images array and output containing divs
	foreach ( (array) $files as $attachment_id => $attachment_url ) {
		if ($banner_image_count < 1) {$show_class_status = ' show';} else {$show_class_status = '';}
		echo '<div class="imgslide jarallax' . $show_class_status . '" style="background-image: url(\'';
        echo wp_get_attachment_url( $attachment_id );
		echo '\');"></div>';
        $banner_image_count = $banner_image_count + 1;
	}


// Image Slider Animation script
if ($banner_image_count > 1) {echo '<script>
function cycleBackgrounds() {
    var index = 0;
    $imageEls = jQuery(\'.imgslide\'); // Get the images to be cycled.
    setInterval(function () {
        // Get the next index.  If at end, restart to the beginning.
        index = index + 1 < $imageEls.length ? index + x`1 : 0;
        // Show the next image.
        $imageEls.eq(index).addClass(\'show\');
        // Hide the previous image.
        $imageEls.eq(index - 1).removeClass(\'show\');
    }, 7000);
};

// Document Ready.
jQuery(function () { cycleBackgrounds(); });
</script>';}
