<?php 
/*
Project: Agent Roster Add-on (Custom Post Type / Write Panel)
Description: Adds a custom post type to display a roster of company agents (employees)
Version: 3.0.1
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2016 Moineau Design
Last Updated: 2024-01-20
*/

// Add thumbnail support for this specific post type. 
// Check to see if any existing post-thumbnail support has been added by other themes or plugins. 
// If yes, add new support, if not, add support for just this post type.
function add_agentroster_thumbsupport() {
	global $_wp_theme_features;
	if( !isset( $_wp_theme_features['post-thumbnails'] ) )
	  $_wp_theme_features['post-thumbnails'] = array( array( 'idxc_agent' ) );
	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) )
	  $_wp_theme_features['post-thumbnails'][0][] = 'idxc_agent';
}

add_action( 'after_setup_theme', 'add_agentroster_thumbsupport', '9999' );
add_image_size( 'thumbnail_agentroster', 600, 725, true ); // width, height, hard crop mode eq true

// Filter to add hidden form field to Gravity Forms - This will allow us to dynamically populate the "to" email address
add_filter('gform_field_value_agent_email', 'populate_agentroster_email');
function populate_agentroster_email($value){
    global $post;
    $agent_email = get_post_meta($post->ID, "_idxc_mb_agentroster_email", $single = true); // Get the Agent's email address for use with Gravity Form
    return $agent_email;
}

// Get Agent Names for use on Listings and Testimonials add-on (others if needed)
// Callback function
function cb_get_agents($field) {
    $agent_names = array(); // Initialize an empty array

    // Set up the arguments for the WP_Query
    $args = array(
        'post_type'      => 'idxc_agent',    // The custom post type
        'posts_per_page' => -1,              // Retrieve all posts
        'post_status'    => 'publish',       // Only retrieve published posts
        'orderby'        => 'title',         // Order by post title
        'order'          => 'ASC',           // Ascending order
    );

    // Create a new instance of WP_Query
    $the_query = new WP_Query($args);

    // Check if there are any posts to process
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            // Use post ID as the key and the post title as the value for the array
            $agent_names[get_the_ID()] = get_the_title();
        }
        wp_reset_postdata(); // Reset postdata after the loop
    }

    // No need to sort by title again as it's already sorted by WP_Query
    return $agent_names; // Return the populated array
}


/* Set up the custom post type */
add_action( 'init', 'idxc_register_post_type_agentroster' );

/* Register the post type */
function idxc_register_post_type_agentroster() {

    /* Set up the arguments for the post type. */
    $album_args = array(
				'public' => true,
				'publicly_queryable' => true,
				'query_var' => 'agents', 													// False to prevent queries, or string value of the query var to use for this post type
				'has_archive' => false, 													// Set to false to disable the archive page
				'rewrite' => array('slug' => 'agents', 'with_front' => false), 				// used in the single post type url
				'supports' => array('title','editor','thumbnail'), 							// 'custom-fields' could be added if needed
				'menu_position' => 5,
				'labels' => array(
				'name' => 'Agents',
				'singular_name' => 'Agent',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Agent',
				'edit_item' => 'Edit',
				'new_item' => 'New',
				'view_item' => 'View',
				'search_items' => 'Search',
				'not_found' => 'No Agents Found',
				'not_found_in_trash' => 'No Agents Found In Trash'
        ),
    );

    /* Register the post type. */
    register_post_type( 'idxc_agent', $album_args );
}

/**/
// ******************
// Add Taxonomy: Category
$taxonomy_name = 'Category';  					// Singular version
$taxonomy_name_plural = 'Categories';  			// Plural version
$taxonomy_slug = 'agent_category'; 				// Slug for the taxonomy (lowercase and underscore_separated)

// Use the variable in the labels array
$labels = array(
	'name'                       => $taxonomy_name,
	'singular_name'              => $taxonomy_name,
	'search_items'               => 'Search ' . $taxonomy_name_plural,
	'popular_items'              => 'Popular ' . $taxonomy_name_plural,
	'all_items'                  => 'All ' . $taxonomy_name_plural,
	'parent_item'                => 'Parent ' . $taxonomy_name,
	'parent_item_colon'          => 'Parent ' . $taxonomy_name . ':',
	'edit_item'                  => 'Edit ' . $taxonomy_name,
	'update_item'                => 'Update ' . $taxonomy_name,
	'add_new_item'               => 'Add New ' . $taxonomy_name,
	'new_item_name'              => 'New ' . $taxonomy_name . ' Name',
	'separate_items_with_commas' => 'Separate ' . $taxonomy_name_plural . ' with commas',
	'add_or_remove_items'        => 'Add or remove ' . $taxonomy_name_plural,
	'choose_from_most_used'      => 'Choose from most used ' . $taxonomy_name_plural,
	'menu_name'                  => $taxonomy_name_plural,
);

// Use the variables in the args array
$args = array(
	'labels'            => $labels,
	'public'            => true,
	'show_in_nav_menus' => true,
	'show_ui'           => true,
	'show_tagcloud'     => true,
	'hierarchical'      => false,
	'meta_box_cb'       => 'post_categories_meta_box',
	'rewrite'           => array( 'slug' => $taxonomy_slug, 'with_front' => true ),
	'query_var'         => true,
	'show_admin_column' => true,
	'show_in_quick_edit' => false,  // Remove from Quick Edit interface as it was causing the save function to not work
);

// Register the taxonomy
register_taxonomy( $taxonomy_slug, array( 'idxc_agent' ), $args );


/* Add Metabox (Agent Roster) */ 
add_action( 'cmb2_admin_init', 'idxc2_mb_create_agentroster' );
/**
 * Hook in and add metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function idxc2_mb_create_agentroster() {
	$prefix = '_idxc_mb_agentroster_';

	/**
	 * Metabox Information
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Agent Information', 'cmb2' ),
		'object_types'  => array( 'idxc_agent', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );
	
	/* Fields */
	$idxc2_metabox->add_field( array(
		'name'       => __( 'First Name', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'first_name',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Last Name', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'last_name',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Email', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'email',
		'type'       => 'text_email',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Phone', 'cmb2' ),
		'desc'       => __( '<br />Example (555) 555-1212. Ideally, try to be consistent with the formatting', 'cmb2' ),
		'id'         => $prefix . 'phone',
		'type'       => 'text_medium',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Phone Label', 'cmb2' ),
		'desc'		=> __( 'Example: Office', 'cmb2' ),
		'id'		=> $prefix . 'phone_label',
		'type'		=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Phone Alternate', 'cmb2' ),
		'desc'       => __( '<br />Example (555) 555-1212. Ideally, try to be consistent with the formatting', 'cmb2' ),
		'id'         => $prefix . 'phone2',
		'type'       => 'text_medium',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Phone Alternate Label', 'cmb2' ),
		'desc'		=> __( 'Example: Cell', 'cmb2' ),
		'id'		=> $prefix . 'phone2_label',
		'type'		=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Website', 'cmb2' ),
		'desc'       => __( 'Example: http://www.yourdomain.com', 'cmb2' ),
		'id'         => $prefix . 'website',
		'type'       => 'text_url',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Title', 'cmb2' ),
		'desc'       => __( 'Optional', 'cmb2' ),
		'id'         => $prefix . 'title',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'License', 'cmb2' ),
		'desc'       => __( 'Optional', 'cmb2' ),
		'id'         => $prefix . 'license',
		'type'       => 'text_medium',
	) );
	
	
	$idxc2_metabox->add_field( array(
        'name'       => __( 'Category', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => $prefix . 'category',
        'taxonomy'       => 'agent_category', // Enter Taxonomy Slug
        'type'           => 'taxonomy_multicheck',
        'remove_default' => 'true', // Removes the default metabox provided by WP core.
        // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
         	'orderby' => 'slug',
            // 'hide_empty' => true,
        ),
    ) );
	
	$idxc2_metabox->add_field( array(
		'name'		=> __( 'Facebook', 'cmb2' ),
		'id'		=> $prefix . 'facebook_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
	
	$idxc2_metabox->add_field( array(
		'name'		=> __( 'Instagram', 'cmb2' ),
		'id'		=> $prefix . 'instagram_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'LinkedIn', 'cmb2' ),
		'id'		=> $prefix . 'linkedin_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Pinterest', 'cmb2' ),
		'id'		=> $prefix . 'pinterest_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Snapchat', 'cmb2' ),
		'id'		=> $prefix . 'snapchat_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'X (Twitter)', 'cmb2' ),
		'id'		=> $prefix . 'twitter_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'YouTube', 'cmb2' ),
		'id'		=> $prefix . 'youtube_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Vimeo', 'cmb2' ),
		'id'		=> $prefix . 'vimeo_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
	
	$idxc2_metabox->add_field( array(
		'name'		=> __( 'TikTok', 'cmb2' ),
		'id'		=> $prefix . 'tiktok_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'https' ), // Array of allowed protocols
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Custom Profile Override', 'cmb2' ),
		'desc'       => __( 'Override the standard output for the Agents details. Typically used when there is a Team or special layout needed.', 'cmb2' ),
		'id'         => $prefix . 'custom_profile',
		'type'       => 'textarea_code',
	) );
	
}


// Shortcode: Display Agent Roster by (optionally by Group)
// Requires: Agent Roster add-on (custom post type)
//				 Limit Posts (modified) plugin, but comes standard with Genesis (typically we keep this in the mu-plugins directory)
// Version: 1.0.0
// Useage: Shortcode to be used in a Page, Post, widget, etc. Designed to showcase a complete or by group, Agent Roster. Pagination can not be used.
//         [mdao_agentroster_display number_of_posts="3" layout="agent_roster1" class="isc_content_center" category="support-staff"] (see below for other options)
//      		Ready Class(es): 
//				isc_content_center, isc_align_center
      
function mdao_agentroster_display_func($atts, $content = null) {
    global $wp_query;
	
	extract(shortcode_atts(array(
		"title" => '',
		"number_of_characters" => '200',		// length of content. Limit of 2000 characters
		"image_width" => '300',					// width of image.
		"image_height" => '0',					// height of image. If set to 0, Height will adjust automatically
		"class" => '',							// optional: (any_custom_name)
		"ids" => '',							// List of post id's to be included
		"exclude_ids" => '',					// Will exclude posts with these ids
        "number_of_posts" => '-1',
		"order_by" => 'last_name',					// date, rand
		"order" => 'ASC',
		"layout" => 'grid-standard',			// Layout option
		//"category" => '',
		"pagination" => 'false', 				// Turn on pagination
		"include_categories" => '', 			// Attribute for including categories
		"exclude_categories" => '', 			// Attribute for excluding categories
		"match_type" => 'any', 					// Include categories operator (any or all) 
	), $atts));

	// Define variables
	$prefix = '_idxc_mb_agentroster_';

	// Validate variables
	if ($number_of_posts > 60) { $number_of_posts = 60; } 	// set max number of posts that can be retrieved
	$ids_array = explode(",", $ids); 						// create array of post ids
	if ($ids != "") { $conditional_ids = 'post__in';} else { $conditional_ids = 'post__not_in';}
	if ($exclude_ids != "") { 
		$conditional_ids = 'post__not_in';
		$ids_array = explode(",", $exclude_ids); 			// create array of ids to be excluded
		}	
	
	// Determine the current page based on the 'pagination' parameter
	if($pagination == 'true') {
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	} else {
		$paged = 1; // This ensures it only queries for the first set of posts
		$number_of_posts = ($number_of_posts > 0) ? $number_of_posts : -1; // Fetch all posts if not limited
	}
	
	// Normalize the case and prepare Category arrays
	$include_cats_array = explode(",", strtolower($include_categories)); // Convert to lowercase then to array
	$exclude_cats_array = explode(",", strtolower($exclude_categories)); // Convert to lowercase then to array
	
	// Query filters
	$args = array(
		$conditional_ids => $ids_array,                  	// post ids to include if defined, otherwise include them all
		'post_type' => array( 'idxc_agent' ),            	// post types allowed
		'posts_per_page'=> $number_of_posts,
		'order' => $order, 
        'paged' => $paged,
		'no_found_rows' => ($pagination == 'true') ? false : true, // Optimize query when not using pagination
		'tax_query' => array(
							'relation' => 'AND', // Use AND relation if both include and exclude are provided
							),
		);
	
	// Conditional logic for setting orderby and meta_key
	if ($order_by === 'last_name') {
		$args['orderby'] = 'meta_value'; // Use meta_value for custom fields
		$args['meta_key'] = $prefix . 'last_name'; // Custom field for ordering
	} else {
		$args['orderby'] = $order_by; // Use standard WordPress ordering
		// No need to set meta_key for standard orderby values
	}
	
	// Add the tax query conditions based on he user provided include_categories. 
	// By default it will include restuls for any category match. 
	// If match_type equals 'all', the listings must match all categories defined.
	if (!empty($include_cats_array[0])) {
		// Initialize the tax_query array if not already initialized
		if (!isset($args['tax_query'])) {
			$args['tax_query'] = array();
		}

		// Adjust relation and operator based on match_type
		if ($match_type === 'all') {
			$args['tax_query']['relation'] = 'AND';
			foreach ($include_cats_array as $cat_slug) {
				$args['tax_query'][] = array(
					'taxonomy' => 'agent_category',
					'field'    => 'slug',
					'terms'    => $cat_slug,
					'operator' => 'IN', // For 'all', this remains 'IN' but with the 'AND' relation above
				);
			}
		} else { // Default to 'any'
			$args['tax_query'][] = array(
				'taxonomy' => 'agent_category',
				'field'    => 'slug',
				'terms'    => $include_cats_array,
				'operator' => 'IN', // This is the default behavior you already had
			);
		}
	}
	
	// Add the tax query conditions based on he user provided exclude_categories.
	if (!empty($exclude_cats_array[0])) { // Check if exclude_categories is not empty
		$args['tax_query'][] = array(
			'taxonomy' => 'agent_category',
			'field'    => 'slug',
			'terms'    => $exclude_cats_array,
			'operator' => 'NOT IN',
		);
	}
	
    // Custom query for your shortcode
    $custom_query = new WP_Query($args);

    // Temporarily replace the global $wp_query (necessary to allow the default genesis pagination function work)
    $original_query = $wp_query;
    $wp_query = $custom_query;
	
	// Determine layout setting 
	switch ($layout) {
    case 'agent_roster1':
        $layout_include = 'layouts/agent_roster1.php';
        $class .= ' ao_agent_roster1'; // Replace with your actual class for this layout
        break;
			
	case 'results1':
        $layout_include = 'layouts/layout_results1.php';
        $class .= ' ao_agent_results1'; // Replace with your actual class for this layout
        break;

    default:
        $layout_include = 'layouts/grid_standard.php'; // Default layout
        $class .= ' ao_agent_gs_gridstandard'; // Default class
        break;
	}
	
	ob_start();
	
	?>	

	<div class="ma_agent_container_outer<?php if ($class != "") { echo " " . $class;} ?>" >
		<?php global $post; $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();

			// Variables needed for display 
			$firstname = get_post_meta($post->ID, $prefix . 'first_name', true);
			$lastname = get_post_meta($post->ID, $prefix . 'last_name', true);
			$agentemail = get_post_meta($post->ID, $prefix . 'email', true);
			$phonenumber = get_post_meta($post->ID, $prefix . 'phone', true);
			$phonenumber2 = get_post_meta($post->ID, $prefix . 'phone2', true);
			$agentwebsite = get_post_meta($post->ID, $prefix . 'website', true);
			$agenttitle = get_post_meta($post->ID, $prefix . 'title', true);
			$license = get_post_meta($post->ID, $prefix . 'license', true);
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

			include $layout_include;
			endwhile; 
		?>
	</div>
	
		
	<?php 
	
	// Genesis pagination
    genesis_posts_nav();

    // Reset postdata and restore original query
    wp_reset_postdata();
    $wp_query = $original_query;

    // Get the buffer content and clean buffer
    $content = ob_get_clean();
    //$content = preg_replace('/\n|\r|<p>|<\/p>|<br>|<br \/>/','',$content);
	return $content;
	
}
add_shortcode("mdao_agentroster_display", "mdao_agentroster_display_func");

