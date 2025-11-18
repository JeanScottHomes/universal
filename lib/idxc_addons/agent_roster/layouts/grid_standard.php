<?php
/* 
Add-on: Agent Roster
Layout: Standard Grid
Created: 2022-11-06
Author: Mark Moineau
Version: 1.0.0
*/
?>

<div class="ma_agent_container">
  <div class="ma_agent_wrap">
    
    <div class="ma_agent_image"><a href="<?php the_permalink(); ?>" aria-label="<?php echo $firstname . " " . $lastname ; // agent name ?>">
      <?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
      <?php the_post_thumbnail( 'thumbnail_agentroster', array('alt' => '') ); ?>
      <?php } else { ?>
      <img src="<?php bloginfo('stylesheet_directory'); ?>/lib/idxc_addons/images/agent-photo-na.gif" alt="" />
      <?php } ?>
    <?php if ($firstname != '') { echo '<div class="ma_agent_name">' . $firstname . ' ' . $lastname . '</div>' ;} // agent name ?>
    </a></div>
    
    <div class="ma_agent_data">
      <?php if ($agenttitle != '') { echo '<span class="ma_agent_title">' . $agenttitle . '</span>';} // title ?>
      <?php if ($phonenumber != '') { $phonenumber_tel = preg_replace("/[^0-9]/", "", $phonenumber ); echo '<span class="ma_agent_phone"><a href="tel:' . $phonenumber_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber_tel . $phonenumberlabel_aria .'">'. $phonenumber . '</a>&nbsp; ' . $phonenumberlabel . '</span>';} // phone number ?>
      <?php if ($phonenumber2 != '') { $phonenumber2_tel = preg_replace("/[^0-9]/", "", $phonenumber2 ); echo '<span class="ma_agent_phone2"><a href="tel:' . $phonenumber2_tel . '" aria-label="Call ' . $firstname . ' at '. $phonenumber2_tel . $phonenumber2label_aria .'">'. $phonenumber2 . '</a>&nbsp; ' . $phonenumber2label . '</span>';} // phone number alternate ?>
      <span class="ma_agent_profile_link"><a href="<?php the_permalink(); ?>" aria-label="View Profile for <?php echo $firstname . ' ' . $lastname ; // agent name ?>">View Profile</a></span>
      <?php if ($agentwebsite != '') {
				echo '<span class="ma_agent_website"><a class="external" href="' . $agentwebsite . '" target="_blank" aria-label="View website for ' . $firstname . ' ' . $lastname .'">Visit Website</a></span>';
				} // website ?>
      <?php // Email Address
				if ($agentemail != '') {
				$pos = strpos($firstname, "&"); // search firstname to see if it contains the ampersand symbol (indicating there is more than one agent)
				if ($pos !== false) { $firstname = "Us"; } // change firstname to Us if an ampersan symbol is found
				echo '<span class="ma_agent_email"><a href="';
				echo the_permalink();
				echo '#contact_agent">Email ' . $firstname .'</a></span>'; 
				} ?>
    </div>
  </div>
</div>