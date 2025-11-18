<div class="ma_agentp_header">
  <div class="ma_agent_wrap">
    
    <div class="ma_agent_image">
      <?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
      <?php the_post_thumbnail( 'thumbnail_agentroster', array('alt' => $firstname . ' ' .$lastname) ); ?>
      <?php } else { ?>
      <img src="<?php bloginfo('stylesheet_directory'); ?>/lib/idxc_addons/images/agent-photo-na.gif" alt="<?php echo $firstname . " " . $lastname ; // agent name ?>" />
      <?php } ?>
    </div>
    
    <div class="ma_agent_data">
	  <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php if (!empty($agenttitle)) { echo '<span class="ma_agent_title">' . $agenttitle . '</span>';} // title ?>
	  <?php if (!empty($license)) { echo '<span class="ma_agent_license">' . $license . '</span>';} // license ?>
      <?php if (!empty($phonenumber)) { $phonenumber_tel = preg_replace("/[^0-9]/", "", $phonenumber ); echo '<span class="ma_agent_phone"><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber_tel . $phonenumberlabel_aria .'">'. $phonenumber . '</a>&nbsp; ' . $phonenumberlabel . '</span>';} // phone number ?>
      <?php if (!empty($phonenumber2)) { $phonenumber2_tel = preg_replace("/[^0-9]/", "", $phonenumber2 ); echo '<span class="ma_agent_phone2"><a href="tel:' . $phonenumber2_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber2_tel . $phonenumber2label_aria .'">'. $phonenumber2 . '</a>&nbsp; ' . $phonenumber2label . '</span>';} // phone number alternate ?>
      <span class="ma_agent_profile_link"><a href="<?php the_permalink(); ?>" aria-label="View Profile for <?php echo $firstname . ' ' . $lastname ; // agent name ?>">View Profile</a></span>
      <?php if (!empty($agentwebsite)) {
				echo '<span class="ma_agent_website"><a class="external" href="' . $agentwebsite . '" target="_blank" aria-label="View website for ' . $firstname . ' ' . $lastname .'">Visit Website</a></span>';
				} // website ?>
      <?php // Email Address
				if (!empty($agentemail)) {
				$pos = strpos($firstname, "&"); // search firstname to see if it contains the ampersand symbol (indicating there is more than one agent)
				if ($pos !== false) { $firstname = "Us"; } // change firstname to Us if an ampersan symbol is found
				echo '<span class="ma_agent_email"><a href="';
				echo the_permalink();
				echo '#contact_agent">Email ' . $firstname .'</a></span>'; 
				} ?>
		
		<?php if (!empty($facebook) || !empty($instagram) || !empty($linkedin) || !empty($pinterest) || !empty($snapchat) || !empty($twitter) || !empty($youtube) || !empty($vimeo) || !empty($tiktok)) { ?>
		<div class="social_icons iul_social_1">
			<?php // Add Social links to output if defined
				if (!empty($facebook)) {echo '<a href="'.$facebook.'" class="so_icon so_facebook" aria-label="Visit us on facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>';}
				if (!empty($instagram)) {echo '<a href="'.$instagram.'" class="so_icon so_instagram" aria-label="Visit us on instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>';}
				if (!empty($$linkedin)) {echo '<a href="'.$linkedin.'" class="so_icon so_linkedin" aria-label="Visit us on linkedin"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>';}
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
<div class="agentp_thecontent">
	<?php the_content(__('[Read more]'));?>
	<!-- Contact Agent - Gravity Form --->
	<a name="contact_agent"></a>
	<h2 class="agentp_form_heading">Contact <?php echo $firstname; ?></h2>
	<?php echo do_shortcode('[gravityform id=4 name=AgentRoster Contact Form title=false description=false ajax=true]'); ?>
</div>