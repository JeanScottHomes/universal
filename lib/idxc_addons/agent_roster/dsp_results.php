<?php /* Custom Post Type template to display results */

// Default Variables
$page_title = 'Our Agents';
$total_posts = -1; 					// -1 to display all 
									// Pagination will be used if total_posts is set to a number less than total posts retrieved. 
									// Pagination will not work properly if total_posts is lower than the Settings > posts per page in the admin
$post_type = 'idxc_agent'; 			// This does not need to be changed
$class = '';						// Ready Class(es) to determine style. (idxc_dsp_list|idxc_dsp_gallery)
$layout = 'grid-standard';			// Set which template should be used for the layout of the listings. (grid-standard | agent_roster1)


// Determine layout setting based upon client option set in the Site Options page
switch ($layout) {
	case 'agent_roster1':
		$layout_include = 'layouts/agent_roster1.php';
		$class .= ' ao_agent_roster1'; // Replace with your actual class for this layout
		break;

	default:
		$layout_include = 'layouts/grid_standard.php'; // Default layout
		$class .= ' ao_agent_gs_gridstandard'; // Default class
		break;
}

?>

<h1 class="idxc_posttype_pageheading entry-title"><?php echo $page_title ;?></h1>


<?php /* Query Posts */	
		global $post;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; // allows for paging to work
		query_posts(array(
			'post_type' => array($post_type),
			'posts_per_page'=> $total_posts,
			'paged'=> $page,
			'orderby' => 'date',
			'order' => 'ASC', 
		));
?>
<div class="ma_agent_container_outer<?php if ($class != "") { echo " " . $class;} ?>" >
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php // Variables needed for display 
        $firstname = get_post_meta($post->ID, "_idxc_mb_agentroster_first_name", $single = true); 
        $lastname = get_post_meta($post->ID, "_idxc_mb_agentroster_last_name", $single = true); 
        $agentemail = get_post_meta($post->ID, "_idxc_mb_agentroster_email", $single = true); 
        $phonenumber = get_post_meta($post->ID, "_idxc_mb_agentroster_phone", $single = true);
        $phonenumberlabel = get_post_meta($post->ID, "_idxc_mb_agentroster_phone_label", $single = true);
        $phonenumber2 = get_post_meta($post->ID, "_idxc_mb_agentroster_phone2", $single = true);
        $phonenumber2label = get_post_meta($post->ID, "_idxc_mb_agentroster_phone2_label", $single = true);
        $agentwebsite = get_post_meta($post->ID, "_idxc_mb_agentroster_website", $single = true); 
        $agenttitle = get_post_meta($post->ID, "_idxc_mb_agentroster_title", $single = true); 

        
        if ($phonenumberlabel != '') {$phonenumberlabel_aria = ', ' . $phonenumberlabel;};
        if ($phonenumber2label != '') {$phonenumber2label_aria = ', ' . $phonenumber2label;};

	include $layout_include;
    endwhile; else: ?>
<p>
  <?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif; ?>
</div>
<!-- Page Navigation -->
<?php genesis_posts_nav(); ?>
