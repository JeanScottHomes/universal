<?php
/* 
Add-on: Agent Roster
Layout: Agent Roster Style 1. Vertical card with Image, name, title and contact details
Created: 2024-01-20
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
      <?php } ?></a>
	</div>
	<div class="isc_content">
		<?php if (!empty($firstname)) { echo '<div class="isc_agent_name">' . $firstname . ' ' . $lastname . '</div>' ;} // agent name ?>
		<?php if (!empty($agenttitle)) { echo '<span class="isc_agent_title">' . $agenttitle . '</span>';} // title ?>
		<?php if (!empty($license)) { echo '<span class="isc_agent_license">' . $license . '</span>';} // license ?>
		<?php if (!empty($phonenumber)) { $phonenumber_tel = preg_replace("/[^0-9]/", "", $phonenumber ); echo '<span class="isc_agent_phone"><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber_tel . $phonenumberlabel_aria .'">'. $phonenumber . '</a>&nbsp; ' . $phonenumberlabel . '</span>';} // phone number ?>
		<?php if (!empty($phonenumber2)) { $phonenumber2_tel = preg_replace("/[^0-9]/", "", $phonenumber2 ); echo '<span class="isc_agent_phone2"><a href="tel:' . $phonenumber2_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber2_tel . $phonenumber2label_aria .'">'. $phonenumber2 . '</a>&nbsp; ' . $phonenumber2label . '</span>';} // phone number alternate ?>
		<?php if (!empty($agentwebsite)) {
			echo '<span class="isc_agent_website"><a class="external" href="' . $agentwebsite . '" target="_blank" aria-label="View website for ' . $firstname . ' ' . $lastname .', opens in new window">Visit Website</a></span>';
		} // website ?>
		
		<?php /*
		// Email Address
		if (!empty($agentemail)) {
			$pos = strpos($firstname, "&"); // search firstname to see if it contains the ampersand symbol (indicating there is more than one agent)
			if ($pos !== false) { $firstname = "Us"; } // change firstname to Us if an ampersan symbol is found
			echo '<span class="isc_agent_email"><a href="';
			echo the_permalink();
			echo '#contact_agent">Email ' . $firstname .'</a></span>'; 
		}
		*/?>
		
		<?php // Email Address
				if (!empty($agentemail)) {
					echo '<span class="isc_agent_email"><a href="mailto:' . $agentemail. '" aria-label="Email ' . $firstname . ', opens in new window" target="_blank">Email</a></span>'; 
				} ?>
	</div>
  </div>
</div>