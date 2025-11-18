<?php
/* 
Add-on: Featured Listings
Layout: Basic (basic information)
Created: 2022-09-06
Author: Mark Moineau
Version: 1.0.2
Updated: 2024-04-04
*/


// Configure the City, State Zip information
$location_parts = []; // Initialize an empty array to hold parts of the location

// Check if each variable has a value and add it to the location parts array
if (!empty($city)) {
    $location_parts[] = $city . ','; // Add a comma after the city
}
if (!empty($state)) {
    $location_parts[] = $state;
}
if (!empty($zip)) {
    $location_parts[] = $zip;
}

// Combine the parts into a single string with space after commas
$location = implode(' ', $location_parts);

$post_title = get_the_title(); // Store the title in a variable

?>


<div class="ao_fl_wrap_outer">
		<div class="ao_fl_wrap_inner"><a href="<?php the_permalink() ?>" class="ao_fl_primary_link">
		<div class="cust_special_wrap">

			<div class="ao_fl_image_container">
			<?php // thumnail / single picture
			if ($thumbnail != '' && is_numeric($thumbnail)) : ?>
				<img class="ao_fl_image" src="<?php echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=' . $image_height . ' crop=1 float= display_view="custom/idxcimgonly-view.php" quality=60 ]'); ?>" alt="<?php the_title(); ?>" loading="lazy" />
			<?php else: ?>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/images/no-photo-available-325x215.jpg" alt="<?php the_title(); ?>" loading="lazy" />
			<?php endif; ?>
			</div>
			<span class="overlay2"></span>
			<?php if (!empty($feature_label)) { echo '<span class="ao_fl_text">' . $feature_label . '</span>'; } ?>
			<div class="ao_fl_info_wrap">				
				<?php if (!empty($post_title)) { echo '<span class="ao_fl_title">' . $post_title . '</span>';} ?>
				<?php if (!empty($price) || $price === "0") { 
							echo '<span class="ao_fl_price">';
							if (!empty($pre_price_label)) {	echo '<span class="isc_pre_price_label">' . $pre_price_label . " </span>"; }
							echo $price === "0" ? 'undisclosed' : '$' . number_format((int)$price, 0, '', ',');
							if (!empty($price2)) { echo '&shy;-$' . number_format((int)$price2, 0, '', ','); }
							if (!empty($post_price_label)) { echo $post_price_label; }
							echo '</span>';
						}
					?>
				<?php if (!empty($address)) { echo '<span class="ao_fl_address">' . $address . '</span>';} ?>
				<?php if (!empty($location)) { echo '<span class="ao_fl_city_state_zip">' . $location . '</span>';} ?>
				<span class="ao_fl_info_line1"><?php if ($property_type == 'Land') { // Land Fields (add as needed)?>Land Listing<?php } else { // Residential fields ?>Beds: <?php if ($beds != '') { echo $beds; } else { echo "n/a";} ?> &nbsp;&nbsp;Baths: <?php if ($baths != '') { echo $baths; } else { echo "n/a";} ?> &nbsp;&nbsp;Sleeps: <?php if ($sleeps != '') { echo $sleeps; } else { echo "n/a";} ?><?php } ?></span>
			</div>
	   </div>
	   </a></div>
</div>