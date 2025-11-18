<?php /* Directory Page (Layout Centered) */ 

?>


<div id="directory_main" class="entry-content">
	<div class="directory_wrap">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Assign values to variables to be used
			$header_image = get_post_meta($post->ID, "_idxc_mb_directorypage_header_image", $single = true);
            $headline = get_post_meta($post->ID, "_idxc_mb_directorypage_headline", $single = true);
			$subheading = get_post_meta($post->ID, "_idxc_mb_directorypage_subheading", $single = true);
            $description = get_post_meta($post->ID, "_idxc_mb_directorypage_page_description", $single = true);
            $phone = get_post_meta($post->ID, "_idxc_mb_directorypage_phone", $single = true);
			$email = get_post_meta($post->ID, "_idxc_mb_directorypage_email", $single = true);
        
            $facebook = get_post_meta($post->ID, "_idxc_mb_directorypage_facebook_url", $single = true);
            $instagram = get_post_meta($post->ID, "_idxc_mb_directorypage_instagram_url", $single = true);
            $linkedin = get_post_meta($post->ID, "_idxc_mb_directorypage_linkedin_url", $single = true);
            $pinterest = get_post_meta($post->ID, "_idxc_mb_directorypage_pinterest_url", $single = true);
            $snapchat = get_post_meta($post->ID, "_idxc_mb_directorypage_snapchat_url", $single = true);
            $twitter = get_post_meta($post->ID, "_idxc_mb_directorypage_twitter_url", $single = true);
            $youtube = get_post_meta($post->ID, "_idxc_mb_directorypage_youtube_url", $single = true);

            $footer_image = get_post_meta($post->ID, "_idxc_mb_directorypage_footer_image", $single = true);
            $license_number = get_post_meta($post->ID, "_idxc_mb_directorypage_license_number", $single = true);

			$name = get_post_meta($post->ID, "_idxc_mb_directorypage_name", $single = true);
			$title = get_post_meta($post->ID, "_idxc_mb_directorypage_title", $single = true);
			
			
			$office = get_post_meta($post->ID, "_idxc_mb_directorypage_office", $single = true);
			$website_url = get_post_meta($post->ID, "_idxc_mb_directorypage_website_url", $single = true);

			$background_overlay = get_post_meta($post->ID, "_idxc_mb_directorypage_background_overlay", $single = true);
		
			
			// Set css flags to control alternate layouts

			?>
        
<div class="content_outer">
    <div class="content_inner">
        <?php if ($header_image != '') { echo '<div class="header_image"><img src="'.$header_image.'" alt="header image" /></div>'; } ?>
        <?php if ($headline != '') { echo '<h1>'.$headline.'</h1>'; } ?>
        <?php if ($subheading != '') { echo '<h2>'.$subheading.'</h2>'; } ?>
        <?php if ($description != '') { echo '<p>'.$description.'</p>'; } ?>
        
        <?php if ($email != '' || $phone != '')  { ?>
        <div class="contact_icons">
            <?php if ($email != '') { echo '<a href="mailto:'.$email.'" class="icon_circle" aria-label="email"><i class="far fa-envelope" aria-hidden="true"></i></a>'; } ?>
            <?php if ($phone != '') { $phone_clean = preg_replace('/\D+/', '', $phone); echo '<a href="tel:'.$phone_clean.'" class="icon_circle" aria-label="call '.$phone_clean.'"><i class="fas fa-phone" aria-hidden="true"></i></a>'; } ?>
        </div>
        <?php } ?>
        
        
        <div class="slp_buttons">
            <?php $entries = get_post_meta( get_the_ID(), '_idxc_mb_directorypage_link_group', true );
                foreach ( (array) $entries as $key => $entry ) {

                    // Set all variables to default as blank
                    $_idxc_mb_directorypage_link_name = $_idxc_mb_directorypage_link_url = '';

                    if ( isset( $entry['_idxc_mb_directorypage_link_name'] ) ) {
                    $link_name = esc_html( $entry['_idxc_mb_directorypage_link_name'] );
                    }

                    if ( isset( $entry['_idxc_mb_directorypage_link_url'] ) ) {
                    $link_url = esc_html( $entry['_idxc_mb_directorypage_link_url'] );
                    }

                    // Output the data
                    echo '<a href="' . $link_url . '" class="slp_button" target="_blank">' . $link_name . '</a>';
                } ?>
        </div>
        
        <?php if ($facebook != '' || $instagram != '' || $linkedin != '' || $pinterest != '' || $snapchat != '' || $twitter != '' || $youtube != '')  { ?>
        <div class="social_icons"> 
            <?php if ($facebook != '') { echo '<a href="'.$facebook.'" class="icon_circle" target="_blank" aria-label="facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>'; } ?>
            <?php if ($instagram != '') { echo '<a href="'.$instagram.'" class="icon_circle" target="_blank" aria-label="instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>'; } ?>
            <?php if ($linkedin != '') { echo '<a href="'.$linkedin.'" class="icon_circle" target="_blank" aria-label="linkedin-in"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>'; } ?>
            <?php if ($pinterest != '') { echo '<a href="'.$pinterest.'" class="icon_circle" target="_blank" aria-label="pinterest"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>'; } ?>
            <?php if ($snapchat != '') { echo '<a href="'.$snapchat.'" class="icon_circle" target="_blank" aria-label="snapchat"><i class="fab fa-snapchat-ghost" aria-hidden="true"></i></a>'; } ?>
            <?php if ($twitter != '') { echo '<a href="'.$twitter.'" class="icon_circle" target="_blank" aria-label="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>'; } ?>
            <?php if ($youtube != '') { echo '<a href="'.$youtube.'" class="icon_circle" target="_blank" aria-label="youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>'; } ?>
        </div>
        <?php } ?>
        
        <?php if ($footer_image != '')  { ?>
        <div class="footer_area"> 
        <img src="<?php echo $footer_image;?>" alt="footer image" />
        </div>
        <?php } ?>
        
        <?php if ($license_number != '')  { ?>
        <div class="disclaimer">
            <?php if ($license_number != '') { echo '<p>DRE #'.$license_number.'</p>'; } ?>
        </div>
        <?php } ?>
        
    </div>
</div>
        

	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
</div>