<?php 
/*
Project: Rentals Add-on (Custom Write Panel)
Description: Creates a custom post type for Rentals.
Version: 2.0.0
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2016 Moineau Design
*/

/* Set up the custom post type */
add_action( 'init', 'idxc_register_post_type_rentals' );

/* Create the post type */
function idxc_register_post_type_rentals() {

    /* Set up the arguments for the post type. */
    $posttype_args = array(
        	'public' => true,
		  	'publicly_queryable' => true,
        	'query_var' => 'rentals', 														// False to prevent queries, or string value of the query var to use for this post type
		  	'has_archive' => false, 														// Set to false to disable the archive page
        	'rewrite' => array('slug' => 'rentals', 'with_front' => false), 				// used in the single post type url
        	'supports' => array('title','editor','thumbnail'),								// 'custom-fields' could be added if needed
		  	'menu_position' => 5,
        	'labels' => array(
            'name' => 'Rentals',
            'singular_name' => 'Rental',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Rental',
            'edit_item' => 'Edit',
            'new_item' => 'New',
            'view_item' => 'View',
            'search_items' => 'Search',
            'not_found' => 'No Rentals Found',
            'not_found_in_trash' => 'No Rentals Found In Trash'
        ),
    );

	/* Register the post type. */
	register_post_type( 'idxc_rentals', $posttype_args ); // Post type. (max. 20 characters, can not contain capital letters or spaces)  
}

// Enable Layout Settings metabox, which includese Custom Body Class for customizations
add_post_type_support( 'idxc_rentals', 'genesis-layouts' );

// ******************
// Add Taxonomy: Category == Start
$taxonomy_name = 'Category';  					// Singular version
$taxonomy_name_plural = 'Categories';  			// Plural version
$taxonomy_slug = 'rental_category'; 				// Slug for the taxonomy (lowercase and underscore_separated)

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
register_taxonomy( $taxonomy_slug, array( 'idxc_rentals' ), $args );
// Add Taxonomy: Catebory == End 
// ******************

// ******************
// Add Taxonomy: Amenities == Start
$taxonomy_name = 'Amenity';  					// Singular version
$taxonomy_name_plural = 'Amenities';  			// Plural version
$taxonomy_slug = 'rental_amenities'; 			// Slug for the taxonomy (lowercase and underscore_separated)

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
register_taxonomy( $taxonomy_slug, array( 'idxc_rentals' ), $args );
// Add Taxonomy: Catebory == End 
// ******************


/* Add Metabox */ 
add_action( 'cmb2_admin_init', 'idxc_mb_create_rentals' );
/**
 * Hook in and add metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function idxc_mb_create_rentals() {
	$prefix = '_idxc_mb_rentals_';

	/**
	 * Metabox Information
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Rental Information', 'cmb2' ),
		'object_types'  => array( 'idxc_rentals', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );
	
	/* Fields */
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Address', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'address',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'City', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'city',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'State', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'state',
		'type'       => 'select',
		'show_option_none' => false,
		'options'          => array(
			'AL' => __( 'AL', 'cmb2' ),
			'AK' => __( 'AK', 'cmb2' ),
			'AZ' => __( 'AZ', 'cmb2' ),
			'AR' => __( 'AR', 'cmb2' ),
			'CA' => __( 'CA', 'cmb2' ),
			'CO' => __( 'CO', 'cmb2' ),
			'CT' => __( 'CT', 'cmb2' ),
			'DE' => __( 'DE', 'cmb2' ),
			'DC' => __( 'DC', 'cmb2' ),
			'FL' => __( 'FL', 'cmb2' ),
			'GA' => __( 'GA', 'cmb2' ),
			'HI' => __( 'HI', 'cmb2' ),
			'ID' => __( 'ID', 'cmb2' ),
			'IL' => __( 'IL', 'cmb2' ),
			'IN' => __( 'IN', 'cmb2' ),
			'IA' => __( 'IA', 'cmb2' ),
			'KS' => __( 'KS', 'cmb2' ),
			'KY' => __( 'KY', 'cmb2' ),
			'LA' => __( 'LA', 'cmb2' ),
			'ME' => __( 'ME', 'cmb2' ),
			'MD' => __( 'MD', 'cmb2' ),
			'MA' => __( 'MA', 'cmb2' ),
			'MI' => __( 'MI', 'cmb2' ),
			'MN' => __( 'MN', 'cmb2' ),
			'MS' => __( 'MS', 'cmb2' ),
			'MO' => __( 'MO', 'cmb2' ),
			'MT' => __( 'MT', 'cmb2' ),
			'NE' => __( 'NE', 'cmb2' ),
			'NV' => __( 'NV', 'cmb2' ),
			'NH' => __( 'NH', 'cmb2' ),
			'NJ' => __( 'NJ', 'cmb2' ),
			'NM' => __( 'NM', 'cmb2' ),
			'NY' => __( 'NY', 'cmb2' ),
			'NC' => __( 'NC', 'cmb2' ),
			'ND' => __( 'ND', 'cmb2' ),
			'OH' => __( 'OH', 'cmb2' ),
			'OK' => __( 'OK', 'cmb2' ),
			'OR' => __( 'OR', 'cmb2' ),
			'PA' => __( 'PA', 'cmb2' ),
			'RI' => __( 'RI', 'cmb2' ),
			'SC' => __( 'SC', 'cmb2' ),
			'SD' => __( 'SD', 'cmb2' ),
			'TN' => __( 'TN', 'cmb2' ),
			'TX' => __( 'TX', 'cmb2' ),
			'UT' => __( 'UT', 'cmb2' ),
			'VT' => __( 'VT', 'cmb2' ),
			'VA' => __( 'VA', 'cmb2' ),
			'WA' => __( 'WA', 'cmb2' ),
			'WV' => __( 'WV', 'cmb2' ),
			'WI' => __( 'WI', 'cmb2' ),
			'WY' => __( 'WY', 'cmb2' ),
		),
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Zip', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'zip',
		'type'       => 'text_small',
	) );
	
	// Numbered array for Bed and Bath options
	$options = [];
		for ($i = 1; $i <= 20; $i++) {
			$options[(string)$i] = __((string)$i, 'cmb2');
		}
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Bedrooms', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'bedrooms',
		'type'       => 'select',
		'show_option_none' => true,
		'options' => $options,
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Sleeps', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'sleeps',
		'type'       => 'select',
		'show_option_none' => false,
		'options' => $options,
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Bathrooms', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'bathrooms',
		'type'       => 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Sq. Feet', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'sqft',
		'type'       => 'text_small',
	) );
	
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Price', 'cmb2' ),
		'desc'       => __( 'Enter the price as a number without any symbols or decimal places.', 'cmb2' ),
		'id'       	 => $prefix . 'price',
		'type'       => 'text_small',
		'attributes' => array(
			'placeholder' => 'e.g., 500',
		),
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Price Max', 'cmb2' ),
		'desc'       => __( 'If you want to display a price range, please enter the maximum price. Enter the price as a number without any symbols or decimal places.', 'cmb2' ),
		'id'       	 => $prefix . 'price2',
		'type'       => 'text_small',
		'attributes' => array(
			'placeholder' => 'e.g., 1000',
		),
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Pre Price Label', 'cmb2' ),
		'desc'       => __( '<br />Label will appear before Price (ie: Starting at:)', 'cmb2' ),
		'id'         => $prefix . 'pre_price_label',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Post Price Label', 'cmb2' ),
		'desc'       => __( '<br />Label will appear after Price (ie: per night)', 'cmb2' ),
		'id'         => $prefix . 'post_price_label',
		'type'       => 'text_medium',
	) );	
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Property ID', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'property_id',
		'type'       => 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Year Built', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'yearbuilt',
		'type'       => 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Garage', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'garage',
		'type'       => 'text_small',
	) );
	
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Tour Link', 'cmb2' ),
		'desc'       => __( 'Example: https://www.vimeo.com/...', 'cmb2' ),
		'id'         => $prefix . 'tour_url',
		'type'       => 'text_url',
		'protocols' => array( 'https' ), // Array of allowed protocols
	) );
	
	$idxc2_metabox->add_field( array(
        'name'		=> __( 'Tour Image', 'cmb2' ),
        'desc'    => '(Optional) Logo or Image to represent the Tour.',
        'id'      => $prefix . 'tour_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );

	$idxc2_metabox->add_field( array(
        'name'       => __( 'Category', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => $prefix . 'category',
        'taxonomy'       => 'rental_category', // Enter Taxonomy Slug
        'type'           => 'taxonomy_multicheck',
		'select_all_button' => false,
        'remove_default' => 'true', // Removes the default metabox provided by WP core.
        // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
         	'orderby' => 'slug',
            // 'hide_empty' => true,
        ),
    ) );
	
	$idxc2_metabox->add_field( array(
        'name'       => __( 'Amenities', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => $prefix . 'amenities',
        'taxonomy'       => 'rental_amenities', // Enter Taxonomy Slug
        'type'           => 'taxonomy_multicheck',
		'select_all_button' => false,
        'remove_default' => 'true', // Removes the default metabox provided by WP core.
        // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
            // 'orderby' => 'slug',
            // 'hide_empty' => true,
        ),
    ) );

	/*
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Agent', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'agent',
		'type'       => 'select',
		'show_option_none' => true,
		'options_cb' => 'cb_get_agents',
	) );
	*/
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Status', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'status',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Feature Label', 'cmb2' ),
		'desc'       => __( '<br />Feature label is displayed over listing image on some results displays.', 'cmb2' ),
		'id'         => $prefix . 'feature_label',
		'type'       => 'text_medium',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Thumbnail ID', 'cmb2' ),
		'desc'       => __( '<br />Enter the thumbnail\'s id. Need help? <a target="_blank" href="http://theinsider.idxcentral.com/tutorials/premium-add-ons/how-to-identify-gallery-thumbnail-id/">How to identify the Thumbnail id</a>', 'cmb2' ),
		'id'         => $prefix . 'thumbnail_id',
		'type'       => 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Gallery ID', 'cmb2' ),
		'desc'       => __( '<br />Enter the gallery\'s id. Need help? <a href="http://theinsider.idxcentral.com/tutorials/premium-add-ons/how-to-identify-gallery-thumbnail-id/" target="_blank">How to identify the Gallery id</a>', 'cmb2' ),
		'id'         => $prefix . 'gallery_id',
		'type'       => 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Map Code', 'cmb2' ),
		'desc'       => __( 'Override the default Map. Only necessary if the automatic mapping was not correct. <a href="https://www.loom.com/share/df9b2af2eeae491e8cfadbb3106f2cce" target="_blank">How to get map code</a>.', 'cmb2' ),
		'id'         => $prefix . 'map_code',
		'type'       => 'textarea_code',
	) );
 
}



// Shortcode: Display Rentals 
// Requires: Rentals add-on (custom post type)
//				 Limit Posts (modified) plugin, but comes standard with Genesis (typically we keep this in the mu-plugins directory)
// Version: 1.0.0
// Useage: Shortcode to be used in a Page, Post, widget, etc. Originally designed for use on the Home page. Get query attributes from http://codex.wordpress.org/Class_Reference/WP_Query
//         [mdao_rental_gallery number_of_posts="3"] (see below for other options)
//      		Ready Class(es): 
//				none
      
function mdao_rental_gallery_func($atts, $content = null) {

	extract(shortcode_atts(array(
		"title" => '',
		"layout" => '',							// Layout option
		"number_of_characters" => '200',		// length of content. Limit of 2000 characters
		"image_width" => '570',					// width of image.
		"image_height" => '0',					// height of image. If set to 0, Height will adjust automatically
		"class" => '',							// optional: (any_custom_name)
		"ids" => '',							// List of post id's to be included
		"exclude_ids" => '',					// Will exclude posts with these ids
		"number_of_posts" => '3',
		"order_by" => 'date',					// date, rand
		"order" => 'desc',
		"pagination" => 'false', 				// Enable pagination
		"include_categories" => '', 			// Attribute for including categories
		"exclude_categories" => '', 			// Attribute for excluding categories
		"match_type" => 'any', 					// Include categories operator (any or all) 
	), $atts));

	// Define variables
	$prefix = '_idxc_mb_rentals_';

	// Validate variables
	if ($number_of_posts > 48) { $number_of_posts = 48; } 	// set max number of posts that can be retrieved
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


    // Query Filters
	$args = array(
		$conditional_ids => $ids_array,					// post ids to include if defined, otherwise include them all
		'post_type' => array( 'idxc_rentals' ),			// post types allowed
		'posts_per_page'=> $number_of_posts,			// -1 to show all posts, otherwise set max number of posts to show (set limit max below)
		'orderby'=> $order_by,							// sort by
		'orderby'=> ($order_by == 'price') ? 'meta_value_num' : $order_by,  // Check if order_by is 'price'
		'order'=> $order,								// order value
		'paged' => $paged,
		'no_found_rows' => ($pagination == 'true') ? false : true, // Optimize query when not using pagination
		'tax_query' => array(
							'relation' => 'AND', // Use AND relation if both include and exclude are provided
							),
			
	);
	
	
	// Conditionally add meta_key for price sorting
	if ($order_by == 'price') {
		$args['meta_key'] = '_idxc_mb_rentals_price';  // Custom field for price
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
					'taxonomy' => 'rental_category',
					'field'    => 'slug',
					'terms'    => $cat_slug,
					'operator' => 'IN', // For 'all', this remains 'IN' but with the 'AND' relation above
				);
			}
		} else { // Default to 'any'
			$args['tax_query'][] = array(
				'taxonomy' => 'rental_category',
				'field'    => 'slug',
				'terms'    => $include_cats_array,
				'operator' => 'IN', // This is the default behavior you already had
			);
		}
	}
	
	// Add the tax query conditions based on he user provided exclude_categories.
	if (!empty($exclude_cats_array[0])) { // Check if exclude_categories is not empty
		$args['tax_query'][] = array(
			'taxonomy' => 'rental_category',
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

	
	// Determine layout setting 
	switch ($layout) {
    case 'standard':
        $layout_include = 'layouts/standard.php';
        $class .= ''; // Replace with your actual class for this layout
        break;

    default:
        $layout_include = 'layouts/basic.php'; // Default layout
        $class .= ' ao_fl_gs_basic'; // Default class
        break;
	}
	
	ob_start();
	?>	
	
<div id="featured_listings_ao_container" class="ao_fl_featured_listings<?php if ($class != "") { echo " " . $class;} ?>" >
	<?php if ($title != "") { ?>
		<h2><?php echo $title; ?></h2>
	<?php } ?>
	
	<?php global $post; $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();
			$price = get_post_meta($post->ID, $prefix . 'price', true);
			$price2 = get_post_meta($post->ID, $prefix . 'price2', true);
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
			$feature_label = get_post_meta($post->ID, $prefix . 'feature_label', true);
			$pre_price_label = get_post_meta($post->ID, $prefix . 'pre_price_label', true);
			$post_price_label = get_post_meta($post->ID, $prefix . 'post_price_label', true);
			$sleeps = get_post_meta($post->ID, $prefix . 'sleeps', true);
			
	
	
			include $layout_include;
    		endwhile;
	?>
</div>
	
	
	<?php 
	// Genesis pagination (keep as is to use the Genesis built-in function)
    genesis_posts_nav();

    // Reset postdata and restore original query
    wp_reset_postdata();
    $wp_query = $original_query;

    // Get the buffer content and clean buffer
    return ob_get_clean();
	
}
add_shortcode("mdao_rental_gallery", "mdao_rental_gallery_func");




/*										*/
/* Sanitize Variables - Error Handling 	*/
/*										*/

// Strip out any character that is not a digit. Remove decimals as well.
add_filter( 'cmb2_sanitize_text_small', 'sanitize_rental_price_field', 10, 5 );
function sanitize_rental_price_field( $override_value, $value, $object_id, $field_args, $sanitizer_object ) {
    // Check if the current field is either 'price' or 'price_2'
    if ( '_idxc_mb_rentals_price' === $field_args['id'] || '_idxc_mb_rentals_price_2' === $field_args['id'] ) {
        // First, remove any characters that are not digits or decimal points
        $value = preg_replace("/[^0-9.]/", "", $value);
        // Then, remove the decimal point and any numbers after it
        $sanitized_value = preg_replace("/\..*/", "", $value);
        return $sanitized_value;
    }

    // Return the original value for other fields
    return $override_value;
}


// Call related form field validation alert
function my_rental_admin_scripts() {
    wp_enqueue_script( 'my-custom-script', get_stylesheet_directory_uri() . '/lib/idxc_addons/js/addon_scripts.js', array( 'jquery' ), null, true );
}
add_action( 'admin_enqueue_scripts', 'my_rental_admin_scripts' );

