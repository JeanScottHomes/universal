<?php 
/*
Project: Featured Posts 
Description: Return a query of posts / pages to display
Version: 3.0.2
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2022 Moineau Design
Last Updated: 2023-08-14
*/




// Shortcode: Display Queried Posts
// Requires: Limit Posts (modified) plugin (typically we keep this in the mu-plugins directory)
// Useage: Shortcode to be used in a Page or Post. Get query attributes from http://codex.wordpress.org/Class_Reference/WP_Query
//         [mdao_query_posts title="My Recent Posts" category_ids="" class=""]
      
function mdao_query_posts_func($atts, $content = null) {
	extract(shortcode_atts(array(
		"layout" => '',
		"title" => '',
		"show_more_link" => 'outside',		// optional: (inside|outside|no) inside exerpt div, outside excerpt div or No for no link
		"show_thumbnail" => 'y',
		"thumbnail_size" => 'medium',				//	optional: (small|med) medium size is default
		"number_of_characters" => '200',
		"class" => '',								// optional: (md_qposts_minimal|any_custom_name)
		"category_ids" => '',					// Will only show posts listed in these categories (accepts CatIDs)
		"exclude_category_ids" => '',			// Will exclude posts listed in these categories (accepts CatIDs)
		"number_of_posts" => '3',
		"post_offset" => '0',
		"order_by" => 'date',
		"order" => 'desc',
		"post_type" => 'post',
	), $atts));



	// Validate variables
	if ($number_of_posts >= 35) { $number_of_posts = 35; } 	// set max number of posts that can be retrieved
	if ($thumbnail_size == "thumbnail") { $thumbnail_size = "thumbnail"; } elseif ($thumbnail_size == "medium") { $thumbnail_size = "medium"; } else { $thumbnail_size = "large"; } 	// set thumbnail size
	$cat_ids_array = explode(",", $category_ids); 				// create array of category ids
	if ($category_ids != "") { $conditional_category_ids = 'category__in';} else { $conditional_category_ids = 'category__not_in';}
	if ($exclude_category_ids != "") { 
		$conditional_category_ids = 'category__not_in';
		$cat_ids_array = explode(",", $exclude_category_ids); // create array of category ids
		}
	 
	$args = array(
		$conditional_category_ids => $cat_ids_array,				// category ids to include if defined, otherwise include them all
		'post_type' => $post_type,									// post type
		'posts_per_page'=> $number_of_posts,						// -1 to show all posts, otherwise set max number of posts to show (set limit max below)
		'offset'=> $post_offset,									// offset
		'orderby'=> $order_by,										// sort by
		'order'=> $order,											// order value
		
	);
	
	
	// Determine layout setting based upon client option set in the Site Options page
	if ($layout == 'list1'){ 
		$layout_include = 'layouts/list1.php';  	// Basic unordered list
		$class .= '';   							// Add ready class 
	} elseif ($layout == 'layout1'){ 
		$layout_include = 'layouts/layout1.php';  	// Grid, 3x1, Image/Title/Content
		$class .= '';   							// Add ready class 
	} else {
		$layout_include = 'layouts/base1.php';  	// Show text links with no images
		$class .= '';   							// Add ready class
	}
	
	ob_start();
	
	include $layout_include;

	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();
	// remove new line, carriage returns, p & br tags from content
	$content = preg_replace('/\n|\r|<p>|<\/p>|<br>|<br \/>/','',$content);
	return $content;
}
add_shortcode("mdao_query_posts", "mdao_query_posts_func");
