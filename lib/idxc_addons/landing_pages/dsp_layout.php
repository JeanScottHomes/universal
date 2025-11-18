<?php /* Landing Page (Layout Centered) */ 

// Default Variables if using Single image vs Gallery Slideshow
//$image_width = 960;				// pixels
//$image_height = 720;			// height of image. If set to 0, Height will adjust automatically
?>


<div id="landing_main" class="entry-content">
	<div class="landing_wrap">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Assign values to variables to be used
			$headline = get_post_meta($post->ID, "_idxc_mb_landingpage_headline", $single = true);
			$subheading = get_post_meta($post->ID, "_idxc_mb_landingpage_subheading", $single = true);
			$form_id = get_post_meta($post->ID, "_idxc_mb_landingpage_form_id", $single = true);
			$name = get_post_meta($post->ID, "_idxc_mb_landingpage_name", $single = true);
			$title = get_post_meta($post->ID, "_idxc_mb_landingpage_title", $single = true);
			$phone = get_post_meta($post->ID, "_idxc_mb_landingpage_phone", $single = true);
			$email = get_post_meta($post->ID, "_idxc_mb_landingpage_email", $single = true);
			$license_number = get_post_meta($post->ID, "_idxc_mb_landingpage_license_number", $single = true);
			$office = get_post_meta($post->ID, "_idxc_mb_landingpage_office", $single = true);
			$website_url = get_post_meta($post->ID, "_idxc_mb_landingpage_website_url", $single = true);
			$agent_url = get_post_meta($post->ID, "_idxc_mb_landingpage_agent_url", $single = true);
			$logo_url = get_post_meta($post->ID, "_idxc_mb_landingpage_logo_url", $single = true);
		
			$bullet_1 = get_post_meta($post->ID, "_idxc_mb_landingpage_bullet_1", $single = true);
			$bullet_2 = get_post_meta($post->ID, "_idxc_mb_landingpage_bullet_2", $single = true);
			$bullet_3 = get_post_meta($post->ID, "_idxc_mb_landingpage_bullet_3", $single = true);
			$bullet_4 = get_post_meta($post->ID, "_idxc_mb_landingpage_bullet_4", $single = true);
			$bullet_5 = get_post_meta($post->ID, "_idxc_mb_landingpage_bullet_5", $single = true);
			$form_headline = get_post_meta($post->ID, "_idxc_mb_landingpage_form_headline", $single = true);
		
			$confirmation_message = get_post_meta($post->ID, "_idxc_mb_landingpage_confirmation_message", $single = true);
			$button_label_1 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_label_1", $single = true);
			$button_link_1 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_link_1", $single = true);
			$button_label_2 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_label_2", $single = true);
			$button_link_2 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_link_2", $single = true);
			$button_label_3 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_label_3", $single = true);
			$button_link_3 = get_post_meta($post->ID, "_idxc_mb_landingpage_ss_button_link_3", $single = true);
		
			$background_overlay = get_post_meta($post->ID, "_idxc_mb_landingpage_background_overlay", $single = true);
		
	

			// Theme Options Fields (global) ** Not used at this time **
			/*
			$g_agent_name = idxcto_get_option( 'agent_name' );
			$g_agent_title = idxcto_get_option( 'agent_title' );
			$g_agent_phone = idxcto_get_option( 'agent_phone' );
			$g_agent_email = idxcto_get_option( 'agent_email' );
			$g_agent_image_url = idxcto_get_option( 'agent_image_url' );
			$g_logo_url = idxcto_get_option( 'logo_url' );
			*/
			
			// Set css flags to control alternate layouts
			if ($agent_url == '') { $agentphoto_used = 'no_photo'; } else { $agentphoto_used = 'yes_photo'; }
			if ($logo_url == '') { $logo_used = 'no_logo'; } else { $logo_used = 'yes_logo'; }
			if ($bullet_1 == '' && $bullet_2 == '' && $bullet_3 == '' && $bullet_4 == '' && $bullet_5 == '') { $bullet_used = 'no_bullet'; } else { $bullet_used = 'yes_bullet'; }
			if (!isset($_GET['confirm'])) { $confirm = 'no_confirm'; } else { $confirm = 'yes_confirm'; }
			?>
			<div class="landing_content<?php echo ' ' . $bullet_used . ' ' . $confirm;?>">
				<div class="landing_content_wrap">
					<div class="landing_content_inner">
						<div class="landing_headlines">
								<?php if ($headline != '') { echo '<h1>' . $headline . '</h1>'; } else { echo "";} ?>
								<?php if ($subheading != '') { echo '<p>' . $subheading . '</p>'; } else { echo "";} ?>

								<?php if ($bullet_used == 'yes_bullet') { ?>
									<ul class="landing_bullets">
										<?php if($bullet_1 != '') { echo '<li class="landing_bullet">' . $bullet_1 . '</li>';} ?>
                                        <?php if($bullet_2 != '') { echo '<li class="landing_bullet">' . $bullet_2 . '</li>';} ?>
                                        <?php if($bullet_3 != '') { echo '<li class="landing_bullet">' . $bullet_3 . '</li>';} ?>
                                        <?php if($bullet_4 != '') { echo '<li class="landing_bullet">' . $bullet_4 . '</li>';} ?>
                                        <?php if($bullet_5 != '') { echo '<li class="landing_bullet">' . $bullet_5 . '</li>';} ?>
									</ul>
								<?php } ?>

							</div>
						<?php if ($confirm == 'no_confirm') { ?>

							<div class="landing_form"><?php if ($form_headline != '') { echo '<h2 class="landing_form_heading">' . $form_headline . '</h2>'; } else { echo "";} ?><?php echo do_shortcode('[gravityform id=' . $form_id . ' title=false description=false ajax=true]'); ?></div>
						<?php } else { ?>
							<div class="landing_confirmation_container">
								<div class="landing_confirmation"><?php echo $confirmation_message; ?></div>

								<?php // Display buttons if defined 		
									if ($button_label_1 != '' && $button_link_1 != '') { 
										echo '<span class="landing_button_wrap"><a class="landing_button" href="'. esc_url($button_link_1) .'">'.$button_label_1.'</a></span>';      
									 };
									if ($button_label_2 != '' && $button_link_2 != '') { 
										echo '<span class="landing_button_wrap last"><a class="landing_button" href="'. esc_url($button_link_2) .'">'.$button_label_2.'</a></span>';       
									 };
									if ($button_label_3 != '' && $button_link_3 != '') { 
										echo '<span class="landing_button_wrap last"><a class="landing_button" href="'. esc_url($button_link_3) .'">'.$button_label_3.'</a></span>';       
									 };
								 ?>
								<div class="clearfix"></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="landing_contact">
				<div class="landing_contact_wrap">
					<div class="agent_card<?php echo ' ' . $logo_used . ' ' . $agentphoto_used;?>">
						<div class="agent_card_photo"><?php if ($agent_url != '') { echo '<img src="'.esc_url($agent_url).'" class="landing_agent_image" alt="agent photo" />' ; } ?></div>
						<div class="agent_card_info">
							<?php if ($name != '') { echo '<span class="name">' . $name . '</span><br>'; } ?>
							<?php if ($title != '') { echo '<span class="title">' . $title . '</span><br>'; } ?>
							<?php if ($phone != '') { $phone_clean = preg_replace('/\D+/', '', $phone); echo '<a href="tel:'.$phone_clean.'">'.$phone.'</a><br>'; } ?>
							<?php if ($email != '') { echo '<a href="mailto:'.$email.'">'.$email.'</a><br>'; } ?>
							<?php if ($license_number != '') { echo $license_number; } ?>
						</div>					
					</div>
					
					<?php if ($logo_url != '') { ?>
					<div class="agent_logo"><img src="<?php echo esc_url($logo_url) ;?>" class="landing_agent_logo" alt="company logo" />
                    </div>
					<?php } ?>
				</div>
			</div>
			
    
	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
</div>