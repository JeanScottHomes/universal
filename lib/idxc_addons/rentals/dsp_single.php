<?php /* Featured Listings - Single post display */ 

// Default Variables if using Single image vs Gallery Slideshow
$image_width = 960;				// pixels
$image_height = 720;			// height of image. If set to 0, Height will adjust automatically

$prefix = "_idxc_mb_rentals_"; // Define your prefix here
$layout_include = get_stylesheet_directory() . '/lib/idxc_addons/rentals/layouts/layout_single2.php';
$main_class_wrapper = "listing_layout_single2";
// $main_class_wrapper = "pd_mainwrap"; // used with layout_single1.php

/*
// Used for testing new layout
if ( is_user_logged_in() ) { // Check if user is logged in
	$current_user = wp_get_current_user(); // Get current user's details
	if ( $current_user->user_login == 'idxcentral' ) { // Check if username is idxcentral
		$layout_include = get_stylesheet_directory() . '/lib/idxc_addons/featured_listings/layouts/layout_single2.php';
		$main_class_wrapper = "listing_layout_single2";
	}
}
*/

?>

<div id="<?php echo $main_class_wrapper; ?>" class="entry-content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Assign values to variables to be used
			$price = get_post_meta($post->ID, $prefix . "price", $single = true);
			$price2 = get_post_meta($post->ID, $prefix . "price2", $single = true);
			$address = get_post_meta($post->ID, $prefix . "address", $single = true);
			$city = get_post_meta($post->ID, $prefix . "city", $single = true);
			$state = get_post_meta($post->ID, $prefix . "state", $single = true);
			$zip = get_post_meta($post->ID, $prefix . "zip", $single = true);
			$mlsnumber = get_post_meta($post->ID, $prefix . "property_id", $single = true);
			$beds = get_post_meta($post->ID, $prefix . "bedrooms", $single = true);
			$baths = get_post_meta($post->ID, $prefix . "bathrooms", $single = true);
			$sqft = get_post_meta($post->ID, $prefix . "sqft", $single = true);
			$garage = get_post_meta($post->ID, $prefix . "garage", $single = true);
			$yearbuilt = get_post_meta($post->ID, $prefix . "yearbuilt", $single = true);
			$thegallerynumber = get_post_meta($post->ID, $prefix . "gallery_id", $single = true);
			$thumbnail = get_post_meta($post->ID, $prefix . "thumbnail_id", $single = true);
			$property_type = get_post_meta($post->ID, $prefix . "property_type", $single = true);
			$feature_label = get_post_meta($post->ID, $prefix . "feature_label", $single = true);
			$agent = get_post_meta($post->ID, $prefix . "agent", $single = true);
			$tour_url = get_post_meta($post->ID, $prefix . "tour_url", $single = true);
			$tour_image = get_post_meta($post->ID, $prefix . "tour_image", $single = true);
			$map_code = get_post_meta($post->ID, $prefix . "map_code", $single = true);
			$sleeps = get_post_meta($post->ID, $prefix . 'sleeps', true);
			$pre_price_label = get_post_meta($post->ID, $prefix . 'pre_price_label', true);
			$post_price_label = get_post_meta($post->ID, $prefix . 'post_price_label', true);
			$status = get_post_meta($post->ID, $prefix . 'status', true);
	
			// Taxonomy Multiple Select Variables
			$amenity_terms = get_the_terms( get_the_ID(), 'rental_amenities' );
	
	
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
	
	
	
			if (file_exists($layout_include)) {
				include $layout_include;
			} else {
				echo 'include not found';
				echo '<br> layout: ' . $layout_include ;
			}

			endwhile; else: 
	?>
	<?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	<?php // edit_post_link('Edit this page', '<p>', '</p>'); ?>
</div>