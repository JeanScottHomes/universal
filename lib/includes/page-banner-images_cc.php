<?php
// Register a custom image size for hero images on single Posts
add_image_size('pb-image', 1920, 1080, true);


// Add body class if page banner image is active
add_filter('body_class', 'add_pb_body_class');
function add_pb_body_class($classes)
{
	global $post;
	if (is_singular(array('page', 'idxc_neighborhood', 'idxc_featlist', 'idxc_rentals')) && has_post_thumbnail() && ! is_page_template('page_idxc_landing.php') && ! is_page_template('page_idxc_directory.php')) {	// Options
		$classes[] = 'pb_image_active';
	}
	return $classes;
}

// Add body class if page banner image is active
add_filter('body_class', 'add_pb_body_class2');
function add_pb_body_class2($classes)
{
	global $post;
	if (is_singular(array('idxc_agent')) && has_post_thumbnail()) {	// Options
		$classes[] = 'pb_image_active';
	}
	return $classes;
}


// Add page banner image if featured image has been selected for approved pages
add_action('genesis_after_header', 'genesiskit_singular_hero_title_section');
function genesiskit_singular_hero_title_section()
{

	// if we are not on a single Post, abort.
	if (! is_singular(array('post', 'page', 'idxc_neighborhood', 'idxc_featlist', 'idxc_rentals', 'idxc_agent')) || is_front_page()) {
		return;
	}

	// set $image to URL of featured image. If featured image is not present, do nothing.
	if (is_singular(array(/*'post',*/'page', 'idxc_neighborhood', 'idxc_featlist', 'idxc_rentals')) && has_post_thumbnail() && ! is_page_template('page_idxc_landing.php') && ! is_page_template('page_idxc_directory.php')) {

			$secondary_image_id = get_post_meta(get_the_ID(), 'secondary_featured_image_id', true);
			$secondary_image_url = '';
			$image = '';

			if (!empty($secondary_image_id)) {
				$img_arr = wp_get_attachment_image_src($secondary_image_id, 'pb-image');
				if (is_array($img_arr) && isset($img_arr[0])) {
					$image = $img_arr[0];
				}
			}

			if (empty($image)) {
				$secondary_image_url = get_post_meta(get_the_ID(), 'secondary_featured_image', true);
				if (!empty($secondary_image_url)) {
					$image = $secondary_image_url;
				}
			}

			if (empty($image)) {
				$image = genesis_get_image('format=url&size=pb-image');
			}
	
	// 🔹 TJS 09/16/2025 — Disabled debug logging of IDs and image data. This was only for debugging image logic.
	// echo '<script>';
	// echo 'console.log("Current Post ID: ", ' . get_the_ID() . ');';
	// echo 'console.log("Secondary Image ID: ", ' . json_encode( $secondary_image_id ) . ');';
	// echo 'console.log("Featured Img: ", ' . json_encode( $image ) . ');';
	// echo '</script>';

/**
 * 
 */

	//// set $image to URL of featured image. If featured image is not present, do nothing.
	//if ( is_singular( array (/*'post',*/'page','idxc_neighborhood','idxc_featlist','idxc_rentals') ) && has_post_thumbnail() && ! is_page_template ( 'page_idxc_landing.php' ) && ! is_page_template ( 'page_idxc_directory.php' )  )
	//{
	//$secondary_image_id = get_post_meta( get_the_ID(), 'secondary_featured_image', true );
	//
	//
	//
	////secondary featured image (custom cmb2 field)
	//if ( ! empty( $secondary_image_id ) ) 
	//{
	//$image = wp_get_attachment_image_src( $secondary_image_id, 'pb-image' );
	//if ( is_array( $image ) && isset( $image[0] ) ) {
	//$image = $image[0]; // Use the URL from the array
	//} 
	//
	////standard featured image
	//else
	//{
	//$image = genesis_get_image( 'format=url&size=pb-image' );		
	//}
	//// end if ( ! empty( $secondary_image_id ) ) 
	//
	//
	//
	//
	//}
	////end( is_singular( array (/*'post',*/'page','idxc_neighborhood','idxc_featlist','idxc_rentals') ) ...
	//


	// set $image to URL of featured image. If featured image is not present, do nothing.
	if (is_singular(array('idxc_agent')) && has_post_thumbnail()) {
		$image = cmb2_get_option('md_main_options', 'agent_header_image');
	}


	if (!empty($image)) {


?>
		<section class="pb_title" id="pb_title" role="complementary" style="background-image: url('<?php echo $image; ?>')">
			<div class="wrap testing">

				<?php

				//if (is_page() && !is_page_template('page_cc_area.php')) {
				//    echo '<h1 class="pb_title">' . get_the_title() . '</h1>';
				//
				//    if (has_excerpt()) { 
				//        echo '<p class="pb_excerpt">' . get_the_excerpt() . '</p>';
				//    }
				//}

				?>

				<?php //echo '<h1 class="pb_title">' . get_the_title() . '</h1>'; 
				?>
				<?php //if ( has_excerpt() ) { echo '<p class="pb_excerpt">' . get_the_excerpt() . '</p>'; } 
				?>


			</div>
		</section>

<?php
		//* Remove entry title.
		remove_action('genesis_entry_header', 'genesis_do_post_title');
		//* Reposition the breadcrumbs
		remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
		} else {
			// do nothing
		}
	}
}
