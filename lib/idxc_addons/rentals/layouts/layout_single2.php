<?php
/* 
Add-on: Featured Listings
Layout: Single detals layout2
Created: 2024-04-03
Author: Mark Moineau
Version: 1.0.0
*/
?>
<style>
/* Page specific styles */
.content-sidebar-wrap .content {padding-top: 0 !important;}
.entry {margin-bottom: 0; padding: 0;}
.galleria-stage .galleria-image img {width: 100% !important;height: 100% !important;object-fit: cover;}
</style>


<?php // Check if Featured Image is set. If set, nothing, if not set, then add Page Tile section
if ( has_post_thumbnail( $post_id ) ) {
	// Do nothing as the H1 Tag is included in the Page Banner
} else { ?>
	<div class="iul_full_width ao_title_no_image">
		<div class="wrap">
			<h1 class="entry-title"><?php echo get_the_title() ; ?><span class="visuallyhidden"><?php echo $location;?></span></h1>
		</div>
	</div>
<?php } ?>


<div class="ao_listing_layout2">	
	<div id="details" class="isc_info_bar_container iul_full_width isc_color1">
		<div class="wrap">
			<div class="isc_info_bar">
				<div class="isc_price">
				<?php if (!empty($price) || $price == "0") {
							if (!empty($pre_price_label)) {	echo '<span class="isc_pre_price_label">' . $pre_price_label . "</span>"; }
							echo $price == "0" ? 'undisclosed' : '$' . number_format(intval($price), 0, '', ',');
							if (!empty($price2)) { echo '-<wbr>$' . number_format((int)$price2, 0, '', ','); }
							if (!empty($post_price_label)) {echo $post_price_label; }
						} ?>
				</div>
				<div class="isc_details">
					<div class="isc_detail_items">
					<?php if (!empty($beds)) { echo '<div class="isc_beds"><span class="isc_number">' . $beds . '</span><span class="isc_label">Bedrooms</span></div>';}?>
					<?php if (!empty($baths)) { echo '<div class="isc_baths"><span class="isc_number">' . $baths . '</span><span class="isc_label">Bathrooms</span></div>';}?>
					<?php if (!empty($sleeps)) { echo '<div class="isc_sqft"><span class="isc_number">' . $sleeps . '</span><span class="isc_label">Sleeps</span></div>';}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="isc_section isc_property_information isc_description">
		<div class="isc_content_wrap">
			<div class="isc_label">
				<div class="isc_label_heading">Description</div>
				<?php /* Hidden : will use if needed at later date
				<div class="isc_label_content">
					<div class="isc_label_link1"><a href="https://youtu.be/q8okMKrV2aY?autoplay=1&autohide=1&fs=1&rel=0&hd=1&wmode=transparent&enablejsapi=1&html5=1" class="foobox" data-width="1920" data-height="1080"><i class="fa-regular fa-circle-play"></i> Virtual Tour</a></div>
				</div>
				*/
				?>
			</div>
			<div class="isc_content">
				<div class="isc_the_content"><?php the_content(__('Read more'));?></div>
				<?php if (!empty($tour_url) && empty($tour_image)) { ?>
					<div class="isc_content_links"><a href="<?php echo $tour_url ;?>" class="iul_button_ghost isc_dark foobox" data-width="1920" data-height="1080">Virtual Tour</a></div>
				<?php ;} ?>
			</div>	
		</div>
	</div>
	
	<div class="isc_section isc_property_information isc_features">
		<div class="isc_content_wrap">
			<div class="isc_label">Details</div>
			<div class="isc_content">
				<?php if (!empty($status)) { echo '<div class="isc_item isc_status"><span class="isc_item_label">Status:</span><span class="isc_item_value">' . $status . '</span></div>';} ?>				
				<?php /*
				if (!empty($price) || $price === "0") { 
							echo '<div class="isc_item isc_price"><span class="isc_item_label">Price:</span><span class="isc_item_value">';
							echo $price === "0" 
							? 'undisclosed' 
							: (!empty($pre_price_label) 
							? $pre_price_label . " " 
							: '') . '$' . number_format((int)$price, 0, '', ',')
							. (!empty($post_price_label) 
							? "" . $post_price_label 
							: '');
							echo '</span></div>';
						}
						*/
					?>
				
				<?php if (!empty($price) || $price == "0") {
	
							echo '<div class="isc_item isc_price"><span class="isc_item_label">Price:</span><span class="isc_item_value">';
	
								if (!empty($pre_price_label)) {	echo '<span class="isc_pre_price_label">' . $pre_price_label . "</span> "; }
							echo $price == "0" ? 'undisclosed' : '$' . number_format(intval($price), 0, '', ',');
							if (!empty($price2)) { echo '-<wbr>$' . number_format((int)$price2, 0, '', ','); }
							if (!empty($post_price_label)) {echo $post_price_label; }
	
							echo '</span></div>';
	
						} ?>
							
				<?php if (!empty($beds)) { echo '<div class="isc_item isc_beds"><span class="isc_item_label">Beds:</span><span class="isc_item_value">' . $beds . '</span></div>';} ?>	
				<?php if (!empty($baths)) { echo '<div class="isc_item isc_baths"><span class="isc_item_label">Baths:</span><span class="isc_item_value">' . $baths . '</span></div>';} ?>	
				<?php if (!empty($sleeps)) { echo '<div class="isc_item isc_sleeps"><span class="isc_item_label">Sleeps:</span><span class="isc_item_value">' . $sleeps . '</span></div>';} ?>
				<?php if (!empty($sqft)) { echo '<div class="isc_item isc_sqft"><span class="isc_item_label">SqFt:</span><span class="isc_item_value">' . $sqft . '</span></div>';} ?>
				<?php if (!empty($garage)) { echo '<div class="isc_item isc_garage"><span class="isc_item_label">Garage:</span><span class="isc_item_value">' . $garage . '</span></div>';} ?>	
				<?php if (!empty($yearbuilt)) { echo '<div class="isc_item isc_yearbuilt"><span class="isc_item_label">Year Built:</span><span class="isc_item_value">' . $yearbuilt . '</span></div>';} ?>
				<?php if (!empty($mlsnumber)) { echo '<div class="isc_item isc_mls_number"><span class="isc_item_label">Property ID:</span><span class="isc_item_value">' . $mlsnumber . '</span></div>';} ?>
			</div>		
		</div>
	</div>
		
	
	<div class="isc_section isc_property_information isc_amenities">
		<div class="isc_content_wrap">
			<div class="isc_label">
				<div class="isc_label_heading">Amenities</div>
			</div>
			<div class="isc_content">
				<div class="isc_content_inner">
					<?php // Amenities Section
					// Check if terms are returned and there's no error
					if ( $amenity_terms && ! is_wp_error( $amenity_terms ) ) :
						echo '<ul>';
						// Loop through each term and display it
						foreach ( $amenity_terms as $term ) {
							echo '<li>' . esc_html( $term->name ) . '</li>';
						}
						echo '</ul>';
					endif;
					?>
				</div>
			</div>	
		</div>
	</div>
	
	
	
	<div class="isc_section isc_property_information isc_location">
		<div class="isc_content_wrap">
			<div class="isc_label">
				<div class="isc_label_heading">Location</div>
			</div>
			<div class="isc_content">
				<div class="isc_content_inner">
					<div class="isc_address"><?php echo $address;?></div>
					<div class="isc_location_details"><?php echo $location;?></div>
				</div>
			</div>	
		</div>
	</div>
	
	<div class="isc_section isc_property_information isc_questions">
		<div class="isc_content_wrap">
			<div class="isc_label">
				<div class="isc_label_heading">Questions</div>
			</div>
			<div class="isc_content">
				<div class="isc_content_inner">
					<div class="isc_question">Need more information about this property?</div>
					<a href="javascript:void(0);" class="md_modal_trigger iul_button_ghost isc_dark" data-modal="modal_contact1" role="button" aria-haspopup="dialog" aria-controls="modal_contact1" style="animation-delay: 1s;">Contact Us</a>
				</div>
			</div>	
		</div>
	</div>
	
	
	<?php if (!empty($thegallerynumber)) { ?>
	<div id="photos" class="iul_full_width">
		<div class="isc_gallery_container">
			<?php echo do_shortcode('[ngg src="galleries" ids="' . $thegallerynumber . '" display="pro_sidescroll"]'); ?> 
		</div>
	</div>
	<?php } ?>
	
	<?php if (!empty($tour_url) && !empty($tour_image)) { ?>
	<div id="video" class="isc_tour_info iul_full_width">
		<div class="wrap">
			<div class="iul_heading3">
				<h2><span>Property</span>Virtual Tour</h2>
			</div>
			<a href="<?php echo $tour_url ;?>" class="foobox iul_play_icon fbx-link fbx-instance" data-width="1920" data-height="1080"><img src="<?php echo $tour_image ;?>" loading="lazy" alt="View Listing information"></a> 
		</div>
	</div>
	<?php } ?>
	
	
	<?php if (!empty($agent)) { ?>
	<div id="contact" class="isc_agent_card_container">
		<div class="wrap">
			<?php echo do_shortcode('[mdao_agentroster_display number_of_posts="2" order_by="last_name" ids="' . $agent . '" layout="results1" class="isc_content_center isc_align_center"]'); ?>
		</div>
	</div>
	<?php } ?>
	
	
	<?php if ($address != '' && $zip != '') { ?>
	<div id="map" class="isc_map_location iul_full_width">
		<?php if ($map_code != '') { echo $map_code; } else { ?>
			<iframe title="Google Map of property location" src="https://www.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo str_replace(" ", "+", $address) ; ?>+<?php echo $zip ; ?>&amp;ie=UTF8&amp;z=14&iwloc=near&addr&amp;output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		<?php } ?>
	</div>
	<?php } ?>
	
	
	
</div>

<?php // Check if the 'featured' parameter exists in the URL
if (isset($_GET['featured'])) { ?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var link = document.querySelector('.header_left_widget a');
		if (link) {
			var container = document.createElement('div');
			container.innerHTML = link.innerHTML;
			container.className = link.className;
			link.parentNode.replaceChild(container, link);
		}
	});
	</script>
<?php } ?>