<?php
/* 
Add-on: Agent Roster
Layout: Agent Roster Layout 1. Vertical card with Image, name, title and contact details
Created: 2024-04-02
Author: Mark Moineau
Version: 1.0.0
*/
?>
<div class="isc_card">
	<div class="isc_wrap">
		<div class="isc_image"><a href="<?php the_permalink(); ?>" aria-label="<?php echo $firstname . " " . $lastname ; // agent name ?>">
			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
			<?php the_post_thumbnail( 'thumbnail_agentroster', array('alt' => '') ); ?>
			<?php } else { ?>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/lib/idxc_addons/images/agent-photo-na.gif" alt="no photo available" />
			<?php } ?>
			</a> 
		</div>
		<div class="isc_content">
			<div class="isc_content_inner">
			
			
			<?php if (!empty($firstname)) { echo '<div class="isc_agent_name">' . $firstname . ' ' . $lastname . '</div>' ;} // agent name ?>
			<?php if (!empty($agenttitle)) { echo '<span class="isc_agent_title">' . $agenttitle . '</span>';} // title ?>
				
			<div class="isc_contact_details">
			<?php if (!empty($license)) { echo '<span class="isc_agent_license"><span class="isc_agent_label">License</span>' . $license . '</span>';} // license ?>
			<?php if (!empty($phonenumber)) { 
					$phonenumber_tel = preg_replace("/[^0-9]/", "", $phonenumber ); 
					echo '<span class="isc_agent_phone"><span class="isc_agent_label">Phone</span><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber_tel . $phonenumberlabel_aria .'">'. $phonenumber . '</a>&nbsp; ' . $phonenumberlabel;

					if (!empty($phonenumber2)) { $phonenumber2_tel = preg_replace("/[^0-9]/", "", $phonenumber2 ); 
						echo '<br><a href="tel:' . $phonenumber2_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber2_tel . $phonenumber2label_aria .'">'. $phonenumber2 . '</a>&nbsp; ' . $phonenumber2label ;} // phone number alternate

					echo '</span>';
				} // phone number 
			?>

			<?php
			if ( !empty( $agentwebsite ) ) {
				echo '<span class="isc_agent_website"><span class="isc_agent_label">Website</span><a class="external" href="' . $agentwebsite . '" target="_blank" aria-label="View website for ' . $firstname . ' ' . $lastname . ', opens in new window">Visit Website</a></span>';
			} // website ?>
			<?php // Email Address
			if ( !empty( $agentemail ) ) {
				echo '<span class="isc_agent_email"><span class="isc_agent_label">Email</span><a href="mailto:' . $agentemail . '" aria-label="Email ' . $firstname . ', opens in new window" target="_blank">' . $agentemail . '</a></span>';
			}
			?>
			</div>
				
			<a href="javascript:void(0);" class="md_modal_trigger iul_button_ghost isc_dark" data-modal="modal_agent_contact1" role="button" aria-haspopup="dialog" aria-controls="modal_agent_contact1" style="animation-delay: 1s;">Contact</a>
				
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
