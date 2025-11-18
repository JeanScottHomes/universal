<?php /* Neighborhood - Single post display */ 

// Default Variables
$image_width = 400; 			// pixels (only used when using single image)
$mlsarea_holder = 'tsmls'; 		// IDXCentral only setting
$idxid_holder = 'IDXID'; 		// IDX ClientID (cid,idxid, etc)
$quicksearchtype = 'idxc';		// Options are (idxc,ihf or idxb). Some settings will need to be made in the related quick search function located in the /custom directory.
?>

<div id="arp_mainwrap" class="entry-content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Assign values to variables to be used
			$target_keyword = get_post_meta($post->ID, "_idxc_mb_neighborhood_keyword", $single = true);
			$thumbnail = get_post_meta($post->ID, "_idxc_mb_neighborhood_thumbnail_id", $single = true);
			$thegallerynumber = get_post_meta($post->ID, "_idxc_mb_neighborhood_gallery_id", $single = true);
			$listing_header = get_post_meta($post->ID, "_idxc_mb_neighborhood_listing_header", $single = true);
			$listing_results = get_post_meta($post->ID, "_idxc_mb_neighborhood_listing_results", $single = true);
			$button_label_1 = get_post_meta($post->ID, "_idxc_mb_neighborhood_ss_button_label_1", $single = true);
			$button_link_1 = get_post_meta($post->ID, "_idxc_mb_neighborhood_ss_button_link_1", $single = true);
			$button_label_2 = get_post_meta($post->ID, "_idxc_mb_neighborhood_ss_button_label_2", $single = true);
			$button_link_2 = get_post_meta($post->ID, "_idxc_mb_neighborhood_ss_button_link_2", $single = true);
			?>
	<div class="gen_main_cw">
		<div class="gen_main_c">
			<?php // Remove page title if Page banner image is set (featured image) 
			if ( ! has_post_thumbnail()  ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php }; ?>
            <?php // Image gallery (slideshow) OR Single image if no gallery is defined
					$content = get_the_content();
					$numWords =  sizeof(explode(" ", $content));
					
					// Default code - display a gallery or thumbnail ID has been defined
					if ($thegallerynumber != '' || ($thumbnail != '' && $numWords > 25)) { 
						if ($thegallerynumber != '') {
						echo '<div class="arp_slideshow_outer"><div class="arp_slideshow">';
						echo do_shortcode('[ngg_images gallery_ids=' . $thegallerynumber . ' display_type=photocrati-nextgen_pro_slideshow ngg_triggers_display=always]');
						echo '</div></div>';
						} else { 
						echo '<img class="ngg-singlepic ngg-right" src="';
						echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=0 float= display_view="custom/idxcimgonly-view.php" quality=60 ]');
						echo '" alt="'.get_the_title().'" width="'.$image_width.'" loading="lazy"/>';
						 }
					} 
					
					?>
			<?php the_content(__('Read more'));?>
            <div class="clearfix xxx"></div>
			<?php // Display buttons if defined 		
				if ($button_label_1 != '' && $button_link_1 != '') { 
					echo '<span class="cta_button_wrap"><a class="cta_button" href="'. esc_url($button_link_1) .'">'.$button_label_1.'</a></span>';      
				 };
				 if ($button_label_2 != '' && $button_link_2 != '') { 
					echo '<span class="cta_button_wrap last"><a class="cta_button" href="'. esc_url($button_link_2) .'">'.$button_label_2.'</a></span>';       
				 };
			 ?>
			<div class="clearfix"></div>
		</div>
	</div>
    
    <?php // Listings
		if ($listing_results != '') { ?>
			<div class="gen_main_cw arp_outerwrap_listings">
				<div class="gen_main_c">
					<h2><?php if ($listing_header != '') { echo $listing_header; } else { echo 'Area Listings';} ?></h2>
					<div id="arp_wrap_listings">
						<?php // test to see if the filed contains a shortcode, if yes then execute the shortcode, if not echo contents
								if ($listing_results[0] == '[') { echo do_shortcode("$listing_results"); } else { echo '<div id="idxb_sct1">'.$listing_results.'</div>'; } ?>
                    </div>
				</div>
			</div>
	<?php } ?>
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	<?php edit_post_link('Edit this page', '<p>', '</p>'); ?>
	<script>
	// Add fullscreen text label to image slideshow
	document.addEventListener('DOMContentLoaded', function() {
	var nggTriggerButtons = document.querySelector('.idxc_neighborhood-template-default .arp_slideshow_outer .ngg-trigger-buttons');
	if (nggTriggerButtons) {
	nggTriggerButtons.innerHTML = '<span class="ng_view">View Fullscreen</span>' + nggTriggerButtons.innerHTML;
	}
	});
	</script>
</div>