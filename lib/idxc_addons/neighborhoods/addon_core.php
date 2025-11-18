<?php 
/*
Project: Neighborhood Add-on (Custom Post Type / Write Panel)
Description: Adds a custom post type to display Neighborhoods
Version: 2.0.0
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2016 Moineau Design
Last Updated: 2016-06-20
*/


/* Set up the custom post type */
add_action( 'init', 'idxc_register_post_type_neighborhood' );

/* Create the post type */
function idxc_register_post_type_neighborhood() {

    /* Set up the arguments for the post type. */
    $posttype_args = array(
        	'public' => true,
		 	'publicly_queryable' => true,
        	'query_var' => 'market', 													// False to prevent queries, or string value of the query var to use for this post type
		  	'has_archive' => false, 													// Set to false to disable the archive page
        	'rewrite' => array('slug' => 'market', 'with_front' => false), 				// used in the single post type url
        	'supports' => array('title','editor','thumbnail','excerpt'), 				// 'custom-fields' could be added if needed
		  	'menu_position' => 5,
        	'labels' => array(
            'name' => 'Markets',
            'singular_name' => 'Market',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Market',
            'edit_item' => 'Edit',
            'new_item' => 'New',
            'view_item' => 'View',
            'search_items' => 'Search',
            'not_found' => 'No Markets Found',
            'not_found_in_trash' => 'No Markets Found In Trash'
        ),
    );

	/* Register the post type. */
	register_post_type( 'idxc_neighborhood', $posttype_args ); // Post type. (max. 20 characters, can not contain capital letters or spaces)  
}

// Enable Layout Settings metabox, which includese Custom Body Class for customizations
add_post_type_support( 'idxc_neighborhood', 'genesis-layouts' );


// ******************
// Add Taxonomy: Category == Start
$taxonomy_name = 'Category';  					// Singular version
$taxonomy_name_plural = 'Categories';  			// Plural version
$taxonomy_slug = 'neighborhood_category'; 		// Slug for the taxonomy (lowercase and underscore_separated)

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
register_taxonomy( $taxonomy_slug, array( 'idxc_neighborhood' ), $args );
// Add Taxonomy: Catebory == End 
// ******************


/* Add Metabox (Neighborhoods) */ 
add_action( 'cmb2_admin_init', 'idxc2_mb_create_neighborhoods' );
/**
 * Hook in and add metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function idxc2_mb_create_neighborhoods() {
	$prefix = '_idxc_mb_neighborhood_';

	/**
	 * Metabox Information
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Neighborhood Information', 'cmb2' ),
		'object_types'  => array( 'idxc_neighborhood', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );
	
	/* Fields */
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Listings Headline', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'listing_header',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Listings', 'cmb2' ),
		'desc'       => __( 'Listings shortcode or javascript widget', 'cmb2' ),
		'id'         => $prefix . 'listing_results',
		'type'       => 'textarea_code',
	) );
	
	$idxc2_metabox->add_field( array(
        'name'       => __( 'Category', 'cmb2' ),
        'desc'       => __( '', 'cmb2' ),
        'id'         => $prefix . 'category',
        'taxonomy'       => 'neighborhood_category', // Enter Taxonomy Slug
        'type'           => 'taxonomy_multicheck',
        'remove_default' => 'true', // Removes the default metabox provided by WP core.
        // Optionally override the args sent to the WordPress get_terms function.
        'query_args' => array(
         	'orderby' => 'slug',
            // 'hide_empty' => true,
        ),
    ) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 1 Label', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_label_1',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 1 Link', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_link_1',
		'type'       => 'text_url',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 2 Label', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_label_2',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 2 Link', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_link_2',
		'type'       => 'text_url',
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
 
}
 
 
// Shortcode: Display Neighborhoods 
// Requires: Neighborhoods add-on (custom post type)
//				 Limit Posts (modified) plugin, but comes standard with Genesis (typically we keep this in the mu-plugins directory)
// Version: 3.0.0
// Useage: Shortcode to be used in a Page, Post, widget, etc. Originally designed for use on the Home page. Get query attributes from http://codex.wordpress.org/Class_Reference/WP_Query
//         [mdao_neighborhood_gallery number_of_posts="6"] (see below for other options)
//      		Ready Class(es): 
//				none
      
function mdao_neighborhood_gallery_func($atts, $content = null) {

	extract(shortcode_atts(array(
		"title" => '',
		"layout" => 'grid-standard',			// Layout option
		"button_text" => '',					// Button text (optional)
		"number_of_characters" => '200',		// length of content. Limit of 2000 characters
		"image_width" => '150',					// width of image.
		"image_height" => '0',					// height of image. If set to 0, Height will adjust automatically
		"class" => '',						// optional: (any_custom_name)
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
	$prefix = '_idxc_mb_neighborhood_';

	// Validate variables
	if ($number_of_posts > 12) { $number_of_posts = 12; } 	// set max number of posts that can be retrieved
	$ids_array = explode(",", $ids); 								// create array of post ids
	if ($ids != "") { $conditional_ids = 'post__in';} else { $conditional_ids = 'post__not_in';}
	if ($exclude_ids != "") { 
		$conditional_ids = 'post__not_in';
		$ids_array = explode(",", $exclude_ids); // create array of ids to be excluded
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
		$conditional_ids => $ids_array,						// post ids to include if defined, otherwise include them all
		'post_type' => array( 'idxc_neighborhood' ),		// post types allowed
		'posts_per_page'=> $number_of_posts,				// -1 to show all posts, otherwise set max number of posts to show (set limit max below)
		'orderby'=> $order_by,								// sort by
		'order'=> $order,									// order value
		'paged' => $paged,
		'no_found_rows' => ($pagination == 'true') ? false : true, // Optimize query when not using pagination
		'tax_query' => array(
							'relation' => 'AND', // Use AND relation if both include and exclude are provided
							),
		
	);
	
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
					'taxonomy' => 'neighborhood_category',
					'field'    => 'slug',
					'terms'    => $cat_slug,
					'operator' => 'IN', // For 'all', this remains 'IN' but with the 'AND' relation above
				);
			}
		} else { // Default to 'any'
			$args['tax_query'][] = array(
				'taxonomy' => 'neighborhood_category',
				'field'    => 'slug',
				'terms'    => $include_cats_array,
				'operator' => 'IN', // This is the default behavior you already had
			);
		}
	}
	
	// Add the tax query conditions based on he user provided exclude_categories.
	if (!empty($exclude_cats_array[0])) { // Check if exclude_categories is not empty
		$args['tax_query'][] = array(
			'taxonomy' => 'neighborhood_category',
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
    case 'buttons':
        $layout_include = 'layouts/buttons.php';
        $class .= ' ao_fn_layout_button'; // Replace with your actual class for this layout
        break;

    default:
        $layout_include = 'layouts/grid_standard.php'; // Default layout
        $class .= ' ao_fn_gs_gridstandard'; // Default class
        break;
	}
	
	ob_start();
	?>	
	
<div class="ao_fn_featured_neighborhoods<?php if ($class != "") { echo " " . $class;} ?>" >
	
	<?php global $post; $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();
			$thegallerynumber = get_post_meta($post->ID, $prefix . 'gallery_id', $single = true);
			$thumbnail = get_post_meta($post->ID, $prefix . 'thumbnail_id', $single = true);

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
add_shortcode("mdao_neighborhood_gallery", "mdao_neighborhood_gallery_func");



// Shortcode: Display Neighborhoods in List on Homepage 
// Requires: Neighborhoods add-on (custom post type)
//				 Limit Posts (modified) plugin, but comes standard with Genesis (typically we keep this in the mu-plugins directory)
// Version: 2.0.0
// Useage: Shortcode to be used in a Page, Post, widget, etc. Originally designed for use on the Home page. Get query attributes from http://codex.wordpress.org/Class_Reference/WP_Query
//         [mdao_neighborhood_gallery_list number_of_posts="6"] (see below for other options)
//      		Ready Class(es): 
//				none
      
function mdao_neighborhood_gallery_func_list($atts, $content = null) {

	extract(shortcode_atts(array(
		"title" => '',
		"number_of_characters" => '200',		// length of content. Limit of 2000 characters
		"image_width" => '150',					// width of image.
		"image_height" => '0',					// height of image. If set to 0, Height will adjust automatically
		"class" => '',							// optional: (any_custom_name)
		"ids" => '',							// List of post id's to be included
		"exclude_ids" => '',					// Will exclude posts with these ids
		"number_of_posts" => '3',
		"order_by" => 'date',					// date, rand
		"order" => 'desc',
	), $atts));



	// Validate variables
	if ($number_of_posts > 12) { $number_of_posts = 12; } 	// set max number of posts that can be retrieved
	$ids_array = explode(",", $ids); 								// create array of post ids
	if ($ids != "") { $conditional_ids = 'post__in';} else { $conditional_ids = 'post__not_in';}
	if ($exclude_ids != "") { 
		$conditional_ids = 'post__not_in';
		$ids_array = explode(",", $exclude_ids); // create array of ids to be excluded
		}
	 
	$args = array(
		$conditional_ids => $ids_array,						// post ids to include if defined, otherwise include them all
		'post_type' => array( 'idxc_neighborhood' ),		// post types allowed
		'posts_per_page'=> $number_of_posts,				// -1 to show all posts, otherwise set max number of posts to show (set limit max below)
		'orderby'=> $order_by,								// sort by
		'order'=> $order,									// order value
		
	);
	ob_start();
	?>	
	
<div class="ao_fn_featured_neighborhoods">
	<ul class="hm_neighborhood">
        <?php global $post; $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();?>
            <li><a href="<?php the_permalink(); ?>" ><?php echo the_title(); ?></a></li>
         <?php endwhile;?>
    </ul>
</div><div class="md_clearfix" style="clear: both;"></div>
<?php 
	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();
	// remove new line, carriage returns, p & br tags from content
	$content = preg_replace('/\n|\r|<p>|<\/p>|<br>|<br \/>/','',$content);
	return $content;
}
add_shortcode("mdao_neighborhood_gallery_list", "mdao_neighborhood_gallery_func_list");

