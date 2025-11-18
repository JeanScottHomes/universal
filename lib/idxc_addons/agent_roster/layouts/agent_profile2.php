<div class="ao_agent_profile2">
	<div class="ao_agent_information">
		<div class="isc_wrap">

			<div class="isc_img">
			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
			<?php the_post_thumbnail( 'thumbnail_agentroster', array('alt' => $firstname . ' ' .$lastname) ); ?>
			<?php } else { ?>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/lib/idxc_addons/images/agent-photo-na.gif" alt="<?php echo $firstname . " " . $lastname ; // agent name ?>" />
			<?php } ?>
			</div>

			<div class="isc_content">
				<div class="isc_inner_wrap">
					<?php if (!empty($custom_profile)) { echo $custom_profile ; } else { ?>
					<h2><?php the_title(); ?></h2>
					<?php if (!empty($agenttitle)) { echo '<span class="isc_title">' . $agenttitle . '</span>';} // title ?>
					<?php if (!empty($license)) { echo '<span class="isc_license">' . $license . '</span>';} // license ?>
					<?php if (!empty($phonenumber)) { $phonenumber_tel = preg_replace("/[^0-9]/", "", $phonenumber ); echo '<span class="isc_label isc_phone_label">Phone</span><span class="isc_phone"><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber_tel . $phonenumberlabel_aria .'">'. $phonenumber . '</a>&nbsp; ' . $phonenumberlabel . '</span>';} // phone number ?>
					<?php if (!empty($phonenumber2)) { $phonenumber2_tel = preg_replace("/[^0-9]/", "", $phonenumber2 ); echo '<span class="isc_phone2"><a href="tel:' . $phonenumber2_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber2_tel . $phonenumber2label_aria .'">'. $phonenumber2 . '</a>&nbsp; ' . $phonenumber2label . '</span>';} // phone number alternate ?>
				
					<?php // Website
							if (!empty($agentwebsite)) {
								echo '<span class="isc_label isc_website_label">Website</span><span class="isc_website"><a class="external" href="' . $agentwebsite . '" target="_blank" aria-label="View website for ' . $firstname . ' ' . $lastname .'">' . parse_url($agentwebsite, PHP_URL_HOST) . '</a></span>';
							} 
							// Email Address
							if (!empty($agentemail)) {
								$pos = strpos($firstname, "&"); // search firstname to see if it contains the ampersand symbol (indicating there is more than one agent)
								if ($pos !== false) { $firstname = "Us"; } // change firstname to Us if an ampersan symbol is found
								echo '<span class="isc_label isc_email_label">Email</span><span class="isc_email"><a href="';
								echo 'mailto:' . $agentemail ;
								echo '" target="_blank">' . $agentemail . '</a></span>'; 
							} ?>
					<?php } ?>

					<?php if (!empty($facebook) || !empty($instagram) || !empty($linkedin) || !empty($pinterest) || !empty($snapchat) || !empty($twitter) || !empty($youtube) || !empty($vimeo) || !empty($tiktok)) { ?>
					<div class="social_icons iul_social_1">
						<?php // Add Social links to output if defined
							if (!empty($facebook)) {echo '<a href="'.$facebook.'" class="so_icon so_facebook" aria-label="Visit us on facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>';}
							if (!empty($instagram)) {echo '<a href="'.$instagram.'" class="so_icon so_instagram" aria-label="Visit us on instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>';}
							if (!empty($linkedin)) {echo '<a href="'.$linkedin.'" class="so_icon so_linkedin" aria-label="Visit us on linkedin"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>';}
							if (!empty($pinterest)) {echo '<a href="'.$pinterest.'" class="so_icon so_pinterest" aria-label="Visit us on pinterest"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>';}
							if (!empty($snapchat)) {echo '<a href="'.$snapchat.'" class="so_icon so_snapchat" aria-label="Visit us on snapchat"><i class="fab fa-snapchat-ghost" aria-hidden="true"></i></a>';}
							if (!empty($twitter)) {echo '<a href="'.$twitter.'" class="so_icon so_twitter" aria-label="Visit us on twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>';}
							if (!empty($youtube)) {echo '<a href="'.$youtube.'" class="so_icon so_youtube" aria-label="Visit us on youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>';}
							if (!empty($vimeo)) {echo '<a href="'.$vimeo.'" class="so_icon so_vimeo nofoobox" aria-label="Visit us on vimeo"><i class="fab fa-vimeo-v" aria-hidden="true"></i></a>';}
							if (!empty($tiktok)) {echo '<a href="'.$tiktok.'" class="so_icon so_tiktok nofoobox" aria-label="Visit us on tiktok"><i class="fab fa-tiktok" aria-hidden="true"></i></a>';}
						?>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<div class="isc_thecontent">
		<?php the_content(__('[Read more]'));?>
		<!-- Contact Agent - Gravity Form --->
		<!--<div id="contact_agent"></div>
		<h2 class="isc_form_heading">Contact <?php echo $firstname; ?></h2>-->
		<?php //echo do_shortcode('[gravityform id=4 name=AgentRoster Contact Form title=false description=false ajax=true]'); ?>
	</div>
	<?php //echo do_shortcode('[md_ao_testimonials number_of_posts="5" number_of_characters="250" class="slick_slider testimonial_slider" agent="'.the_title().'" before"<div class="iul_testimonials_1"><div class="testimonial_quote">&#8221;</div>" after="<div class="iul_testimonials_1"><div class="testimonial_quote">&#8221;</div>"]'); ?>
	
</div>
<?php // Get Testimonials and display using shortcode	
	$post_id = get_the_ID(); // Get the current post ID if you're within The Loop or have the ID some other way
	//$shortcode = '[md_ao_testimonials number_of_posts="5" number_of_characters="250" class="slick_slider testimonial_slider" pagination="true" layout="layout2" order_by="date" order="desc" agent="' . esc_attr($post_id) . '" before=\'<div class="iul_testimonials_1"><div class="testimonial_quote">&#8221;</div>\' after=\'</div>\']';
	$shortcode = '[md_ao_testimonials number_of_posts="5" number_of_characters="250" class="" pagination="true" layout="layout2" order_by="date" order="desc" agent="' . esc_attr($post_id) . '" title="What Clients are Saying"]';
	echo do_shortcode($shortcode);	
	?>
