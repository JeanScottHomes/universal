<?php
/* 
Add-on: Agent Roster
Layout: Standard Grid
Created: 2022-11-06
Author: Mark Moineau
Version: 1.0.0
*/

// Initialize the class variable
$class_modifiers = '';
// Determine how to handle displaying the featured image
if (!empty($image_handling)) {
	$class_modifiers .= 'isc_image_' . $image_handling ;
}
// Determine how to handle displaying the featured image
if (!empty($card_class)) {
	$class_modifiers .= ' ' . $card_class;
}


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

// Test to see if an image/logo has been assigned (not the featured image)
if (empty($image_id)) { $class_modifiers .= ' isc_no_image';}
?>
<div class="iul_dirlisting_card2 isc_item <?php echo $class_modifiers;?>">
	<div class="isc_wrap">
		<?php // Check if the image ID is not empty.
			if (!empty($image_id)) {
				echo '<div class="isc_image">';
					// Attempt to get the medium-sized image.
					$image_info = wp_get_attachment_image_src($image_id, 'medium');

					// Get the alt text for the image.
					$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

					// If the alt text is not found, you can set a default or leave it empty.
					$alt_text = !empty($alt_text) ? $alt_text : get_the_title(); // Use the post's title as alt text if no alt text is set.

					// Check if the image URL is available.
					if ($image_info && !empty($image_info[0])) {
						$image_src = $image_info[0]; // This is the URL of the medium or fallback to the full-size image.

						// Display the image with alt text and lazy loading.
						echo '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($alt_text) . '" loading="lazy" />';
					}
				echo '</div>';
			}
		?>
			
		<div class="isc_content"> 
			<?php echo '<span class="isc_title">' . get_the_title() . '</span>'; ?>
			<?php if (!empty($address)) { echo '<span class="isc_address">' . $address . '</span>';} ?>
			<?php if (!empty($location)) { echo '<span class="isc_location">' . $location . '</span>';} ?>
			<div class="isc_contact_spacer"></div>
			<?php if (!empty($contact)) { echo '<span class="isc_contact">' . $contact . '</span>';} ?>
			<?php if (!empty($contact_title)) { echo '<span class="isc_contact_title">' . $contact_title . '</span>';} ?>
			<?php if (!empty($phone)) { $phonenumber_tel = preg_replace("/[^0-9]/", "", $phone ); echo '<span class="isc_phone"><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . get_the_title() . ' at '. $phonenumber_tel . '">'. $phone . '</a>&nbsp; ' . $phone_label . '</span>';} ?>
			<?php if (!empty($email)) { echo '<span class="isc_email"><i class="fa-regular fa-envelope"></i> <a href="mailto:' . $email . '">' . $email . '</a></span>';} ?>
			<?php if (!empty($website)) { echo '<span class="isc_website"><i class="fa-solid fa-globe"></i> <a href="' . $website . '" target="_blank" aria-label="View website for ' . get_the_title() . ', opens in new window">Website</a></span>';} ?>
			<?php if (!empty($content)) { echo '<div class="isc_page_content">' . apply_filters('the_content', $content) . '</div>';} ?>
		</div>
	</div>
</div>
