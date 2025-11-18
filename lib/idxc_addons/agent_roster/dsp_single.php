<?php /* Agent Profile - Single post display */ 

// Default Variables
$prefix = '_idxc_mb_agentroster_';
$layout_include = get_stylesheet_directory() . '/lib/idxc_addons/agent_roster/layouts/agent_profile2.php';
?>
<div class="ma_agentp_wrap entry-content">	
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Variables needed for display 
		$firstname = get_post_meta($post->ID, $prefix . 'first_name', true);
		$lastname = get_post_meta($post->ID, $prefix . 'last_name', true);
		$agentemail = get_post_meta($post->ID, $prefix . 'email', true);
		$phonenumber = get_post_meta($post->ID, $prefix . 'phone', true);
		$phonenumberlabel = get_post_meta($post->ID, $prefix . 'phone_label', true);
		$phonenumber2 = get_post_meta($post->ID, $prefix . 'phone2', true);
		$phonenumber2label = get_post_meta($post->ID, $prefix . 'phone2_label', true);
		$agentwebsite = get_post_meta($post->ID, $prefix . 'website', true);
		$agenttitle = get_post_meta($post->ID, $prefix . 'title', true);
		$facebook = get_post_meta($post->ID, $prefix . 'facebook_url', true);
		$instagram = get_post_meta($post->ID, $prefix . 'instagram_url', true);
		$linkedin = get_post_meta($post->ID, $prefix . 'linkedin_url', true);
		$pinterest = get_post_meta($post->ID, $prefix . 'pinterest_url', true);
		$snapchat = get_post_meta($post->ID, $prefix . 'snapchat_url', true);
		$twitter = get_post_meta($post->ID, $prefix . 'twitter_url', true);
		$youtube = get_post_meta($post->ID, $prefix . 'youtube_url', true);
		$vimeo = get_post_meta($post->ID, $prefix . 'vimeo_url', true);
		$tiktok = get_post_meta($post->ID, $prefix . 'tiktok_url', true);
	    $license = get_post_meta($post->ID, $prefix . 'license', true);
		$custom_profile = get_post_meta($post->ID, $prefix . 'custom_profile', true);

	
        if ($phonenumberlabel != '') {$phonenumberlabel_aria = ', ' . $phonenumberlabel;};
        if ($phonenumber2label != '') {$phonenumber2label_aria = ', ' . $phonenumber2label;};
	 

		if (file_exists($layout_include)) {
			include $layout_include;
		} else {
			echo 'include not found';
			echo '<br> layout: ' . $layout_include ;
		}
		
		endwhile; else: ?>
	<p>
		<?php _e('Sorry, no posts matched your criteria.'); ?>
	</p>
<?php endif; ?>
<?php edit_post_link('Edit this page', '<p>', '</p>'); ?>
<?php // Agent Profile: End ?>
</div>