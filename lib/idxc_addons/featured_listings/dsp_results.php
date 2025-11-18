<?php /* Custom post type template to display results (archives) */

/*

// Default Variables
$page_title = 'Featured Listings';
$page_title_solds = 'Sold Listings';
$total_posts = 20; 									// -1 to display all
													// Pagination will be used if total_posts is set to a number less than total posts retrieved.
													// Pagination will not work properly if total_posts is lower than the Settings > posts per page in the admin
$image_width = 600;									// width of image
$image_height = 390;								// height of image. If set to 0, Height will adjust automatically
$desc_characters = 200;								// Description character limit
$post_type = 'idxc_featlist'; 						// This does not need to be changed
$class = 'idxc_dsp_gallery iul_listings2';			// Ready Class(es) to determine style. (idxc_dsp_list|idxc_dsp_gallery)
$layout = 'basic';									// Set which template should be used for the layout of the listings. (original, basic, style1, style2...etc)

// Define variables
$prefix = '_idxc_mb_featuredlistings_';

// Modify the WordPress read more link
add_filter( 'get_the_content_more_link', 'idxcentral_read_more_info' );
function idxcentral_read_more_info() {
	return '&nbsp;... <a class="idxao-more-link" href="' . get_permalink() . '">' . __( 'Property&nbsp;Details', 'idxcentral' ) . '</a>';
}

// Determine layout setting based upon client option set in the Site Options page
if ($layout == 'original'){ 
	$layout_include = 'layouts/original.php';  	// Show grid view with images
	$class .= ' ao_fl_gs_original';   			// Add ready class (include space before readyclass name)
} elseif ($layout == 'basic') {
	$layout_include = 'layouts/basic.php';  	// Show grid view with images
	$class .= ' ao_fl_gs_basic';  		// Add ready class (include space before readyclass name)
} else {
	$layout_include = 'layouts/basic.php';  	// Show text links with no images
	$class .= ' ao_fl_gs_basic';   		// Add ready class (include space before readyclass name)
}
			

// Query Posts

// Check to see if the url parameter "solds" is passed. If yes, change compare value to show Solds
if (isset($_GET['solds'])) {
		$solds_array[] = array(
							'key' => $prefix . 'status',
							'value' => 'SOLD',
							'compare' => '=',
							); 
	} else {
		$solds_array[] = array(
							'key' => $prefix . 'status',
							'value' => 'SOLD',
							'compare' => '!=',
							);		
}

global $post;
$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; // allows for paging to work

query_posts(array(
	'post_type' => array($post_type),
	'posts_per_page'=> $total_posts,
	'paged'=> $page,
	'meta_query' => $solds_array, // Hide Solds filter if client wants their sold listings mixed with all listings (just comment out this line) 
));
?>
<h1 class="idxc_posttype_pageheading entry-title"><?php if (isset($_GET['solds'])) { echo $page_title_solds ;} else { echo $page_title ; } ?></h1>
<div id="idxc_fl_mainwrap" class="idxc_fl_mainwrap<?php if ($class != '') { echo ' ' . $class; } ?>">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php // Assign values to variables to be used
	$price = get_post_meta($post->ID, $prefix . 'price', true);
	$address = get_post_meta($post->ID, $prefix . 'address', true);
	$city = get_post_meta($post->ID, $prefix . 'city', true);
	$state = get_post_meta($post->ID, $prefix . 'state', true);
	$zip = get_post_meta($post->ID, $prefix . 'zip', true);
	$beds = get_post_meta($post->ID, $prefix . 'bedrooms', true);
	$baths = get_post_meta($post->ID, $prefix . 'bathrooms', true);
	$sqft = get_post_meta($post->ID, $prefix . 'sqft', true);
	$status = get_post_meta($post->ID, $prefix . 'status', true);
	$status_other = get_post_meta($post->ID, $prefix . 'status_other', true);
	$thegallerynumber = get_post_meta($post->ID, $prefix . 'gallery_id', true);
	$thumbnail = get_post_meta($post->ID, $prefix . 'thumbnail_id', true);
	$property_type = get_post_meta($post->ID, $prefix . 'property_type', true);


	include $layout_include;
	endwhile; else: ?>
<p>
	<?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif; ?>
</div>
<!-- Page Navigation -->
<?php genesis_posts_nav(); ?>


*/
echo do_shortcode('[mdao_listing_gallery number_of_posts="12" class="iul_listings2 smao_flex" layout="basic" image_width="795" image_height="460" pagination="true" exclude_categories="sold" order_by="price"]');
