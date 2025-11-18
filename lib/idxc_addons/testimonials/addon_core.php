<?php 
/*
Project: Testimonials Add-on (Custom Write Panel)
Description: Creates a custom post type for Testimonials.
Version: 3.0.0
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2024 Moineau Design
Last Updated: 2024-02-20
*/

// Add thumbnail support for this specific post type. 
// Check to see if any existing post-thumbnail support has been added by other themes or plugins. 
// If yes, add new support, if not, add support for just this post type.
function add_testimonials_thumbsupport() {
	global $_wp_theme_features;
	if( !isset( $_wp_theme_features['post-thumbnails'] ) )
	  $_wp_theme_features['post-thumbnails'] = array( array( 'idxc_testimonials' ) );
	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) )
	  $_wp_theme_features['post-thumbnails'][0][] = 'idxc_testimonials';
}
add_action( 'after_setup_theme', 'add_testimonials_thumbsupport', '9999' );
add_image_size( 'thumbnail_testimonials', 185, 210, true ); // first value is width, true = hard crop mode 

/* Set up the custom post type */
add_action( 'init', 'idxc_register_post_type_testimonials' );

/* Register the post type */
function idxc_register_post_type_testimonials() {

    /* Set up the arguments for the post type. */
    $posttype_args = array(
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => 'testimonials', 													// False to prevent queries, or string value of the query var to use for this post type
			'has_archive' => false, 														// Used in the results / archive url
			'rewrite' => array('slug' => 'testimonials', 'with_front' => false), 			// used in the single post type url
			'supports' => array('title','editor','thumbnail'), 								// 'custom-fields' could be added if needed
			'menu_position' => 5,
			'labels' => array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New',
			'edit_item' => 'Edit',
			'new_item' => 'New',
			'view_item' => 'View',
			'search_items' => 'Search',
			'not_found' => 'No Testimonials Found',
			'not_found_in_trash' => 'No Testimonials Found In Trash'
        	),
    );

    /* Register the post type. */
    register_post_type( 'idxc_testimonials', $posttype_args ); // Post type. (max. 20 characters, can not contain capital letters or spaces)  
}

// ******************
// Add Taxonomy: Category == Start
$taxonomy_name = 'Category';  					// Singular version
$taxonomy_name_plural = 'Categories';  			// Plural version
$taxonomy_slug = 'testimonial_category'; 		// Slug for the taxonomy (lowercase and underscore_separated)

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
register_taxonomy( $taxonomy_slug, array( 'idxc_testimonials' ), $args );
// Add Taxonomy: Catebory == End 
// ******************


/* Add Metabox (Testimonials)  */ 
add_action( 'cmb2_admin_init', 'idxc_mb_create_testimonials' );
/**
 * Hook in and add metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function idxc_mb_create_testimonials() {
	$prefix = '_idxc_mb_testimonials_';

	/**
	 * Metabox Information
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Testimonial Information', 'cmb2' ),
		'object_types'  => array( 'idxc_testimonials', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );
	
	$idxc2_metabox->add_field( array(
        'name'       => __( 'Category', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => $prefix . 'category',
        'taxonomy'       => 'testimonial_category', // Enter Taxonomy Slug
        'type'           => 'taxonomy_multicheck',
        'remove_default' => 'true', // Removes the default metabox provided by WP core.
        // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
         	'orderby' => 'slug',
            // 'hide_empty' => true,
        ),
    ) );
	
	/* Fields */
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Agent', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'agent',
		'type'       => 'select',
		'show_option_none' => true,
		'options_cb' => 'cb_get_agents',
	) );
 
}



// Shortcode: Display Testimonials
// Requires: Testimonials add-on (custom post type)
//				 Limit Posts (modified) plugin (typically we keep this in the mu-plugins directory)
// Version: 1.5.2
// Useage: Shortcode to be used in a Page or Post. Get query attributes from http://codex.wordpress.org/Class_Reference/WP_Query
//         [md_ao_testimonials title="testimonials" number_of_posts="2" number_of_characters="150" ]
//      		Ready Class: 
//				none



function md_ao_testimonials_func($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"button_text" => 'All Testimonials',		// Button text - for viewing all testimonials (optional)
		"button_link" => '',						// Button link - for viewing all testimonials (optional)
		"show_more_link" => 'inside',				// optional: (inside|no) inside excerpt div, No for no link
		"show_thumbnail" => 'n',					// not tested
		"show_shadow" => 'n',						// not tested
		"number_of_characters" => '200',			// length of content. Limit of 2000 characters
		"class" => '',								// optional: (any_custom_name)
		"ids" => '',								// List of post id's to be included
		"exclude_ids" => '',						// Will exclude posts with these ids
		"number_of_posts" => '1',
		"post_offset" => '0',						// not supported yet
		"order_by" => 'rand',
		"order" => 'desc',
		"layout" => '', 							// Layout to use
		"agent" => '', 								// Agent ID
		"before" => '', 							// Before output of looped content
		"after" => '', 								// After output of looped content
		"pagination" => 'false', 					// Enable pagination
		"include_categories" => '', 				// Category name (nice name or slug will work I believe)
		"exclude_categories" => '', 				// Category name (nice name or slug will work I believe)
		"match_type" => 'any', 						// Include categories operator (any or all)
	), $atts));

	if ($number_of_posts >= 35) { $number_of_posts = 35; }
	$ids_array = explode(",", $ids); 
	$conditional_ids = $ids != "" ? 'post__in' : 'post__not_in';
	if ($exclude_ids != "") { 
		$conditional_ids = 'post__not_in';
		$ids_array = explode(",", $exclude_ids);
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
	
	$args = array(
		$conditional_ids => $ids_array,
		'post_type' => array( 'idxc_testimonials' ),
		'posts_per_page'=> $number_of_posts,
		'orderby'=> $order_by,
		'order'=> $order,
		'paged' => $paged,
		'no_found_rows' => ($pagination == 'true') ? false : true, // Optimize query when not using pagination
		'meta_query' => array(),
		'tax_query' => array(
							'relation' => 'AND', // Use AND relation if both include and exclude are provided
							),
	);
	
	// Filter by Agent if defined (can be a comma separated list)
	if (!empty($agent)) {
		$agents = array_map('trim', explode(',', $agent)); // Split the string into an array and trim whitespace
		$args['meta_query'][] = array(
			'key' => '_idxc_mb_testimonials_agent',
			'value' => $agents,
			'compare' => 'IN' // Use 'IN' to match any value in the array
		);
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
					'taxonomy' => 'testimonial_category',
					'field'    => 'slug',
					'terms'    => $cat_slug,
					'operator' => 'IN', // For 'all', this remains 'IN' but with the 'AND' relation above
				);
			}
		} else { // Default to 'any'
			$args['tax_query'][] = array(
				'taxonomy' => 'testimonial_category',
				'field'    => 'slug',
				'terms'    => $include_cats_array,
				'operator' => 'IN', // This is the default behavior you already had
			);
		}
	}
	
	// Add the tax query conditions based on he user provided exclude_categories.
	if (!empty($exclude_cats_array[0])) { // Check if exclude_categories is not empty
		$args['tax_query'][] = array(
			'taxonomy' => 'testimonial_category',
			'field'    => 'slug',
			'terms'    => $exclude_cats_array,
			'operator' => 'NOT IN',
		);
	}
	
	// Temporarily replace the global $wp_query (necessary to allow the default genesis pagination function work)
	$custom_query = new WP_Query($args);
    global $wp_query;
    $original_query = $wp_query;
    $wp_query = $custom_query;
	
	// Determine layout setting based upon client option set in the Site Options page
	switch ($layout) {		
	 case 'layout2':
        $layout_include = 'layouts/layout2.php';
        $class .= 'ao_testimonials_layout2'; // Replace with your actual class for this layout
        break;
			
	 case 'layout3':
        $layout_include = 'layouts/layout3.php';
        $class .= ''; 						// Replace with your actual class for this layout
        break;

    default:
        $layout_include = 'layouts/layout1.php'; // Default layout
        $class .= ''; // Default class
        break;
	}
	
	ob_start();
	$recent = new WP_Query($args);
	if ($recent->have_posts()) { // Check if there are any posts
		if (!empty($before)) {echo $before;}
		echo "<div class=\"md_testimonials" . ($class != "" ? " " . $class : "") . "\">";
		if ($title != "") {echo "<h2>$title</h2>";}
		

		while($recent->have_posts()) : $recent->the_post();
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = strip_tags($content);
			$length_of_string = strlen($content);
			include $layout_include;
		endwhile;
		echo "</div>";
		if (!empty($after)) {echo $after;}

		if ($button_link != '') {
			echo "<a href=\"$button_link\" class=\"md_testimonials_button_link\">$button_text</a>";
		}
	} else {
		// Optionally, return a message indicating no testimonials are available
		// echo "<p>No testimonials available.</p>";
	}
	
	// Genesis pagination (keep as is to use the Genesis built-in function)
    genesis_posts_nav();

    // Reset postdata and restore original query
    wp_reset_postdata();
    $wp_query = $original_query;

    // Get the buffer content and clean buffer
    return ob_get_clean();
}
add_shortcode("md_ao_testimonials", "md_ao_testimonials_func");
