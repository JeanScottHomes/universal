<?php /* Custom post type template to display results (archives) */

// Default Variables
$page_title = 'Testimonials';
$total_posts = 25; 	// -1 to display all 
							//	Pagination will be used if total_posts is set to a number less than total posts retrieved. 
							// Pagination will not work properly if total_posts is lower than the Settings > posts per page in the admin
$post_type = 'idxc_testimonials'; // This does not need to be changed

//* Modify the WordPress read more link
/**/
add_filter( 'get_the_content_more_link', 'idxcentral_read_more_info' );
function idxcentral_read_more_info() {
	return '&nbsp;... <a class="idxao-more-link" href="' . get_permalink() . '">' . __( 'More testimonial from ' . get_the_title(), 'idxcentral' ) . '</a>';
}


/* Query Posts */	
		global $post;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; // allows for paging to work
		query_posts(array(
			'post_type' => array($post_type),
			'posts_per_page'=> $total_posts,
			'paged'=> $page,
		));
?>
<h1 class="idxc_posttype_pageheading entry-title"><?php echo $page_title ;?></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php // Variables needed for display 
		$bodyclass = "idxc_test_body";
	 ?>
	<div class="idxc_test_cont">
		<?php // check if the post has a Post Thumbnail assigned to it.
				if ( has_post_thumbnail() ) { $bodyclass = "idxc_test_body idxc_test_body_wthumb"; ?>
			<div class="idxc_test_imgc"><?php the_post_thumbnail( 'thumbnail_testimonials' ); ?></div>
		<?php } else { ?>
			<!-- no image -->
		<?php } ?>
		 <div class="<?php echo $bodyclass; ?>">
			  <div class="idxc_test_bodyi">
                  <?php  the_content_limit(200); ?>
			  </div>
			  <div class="idxc_test_name"><?php the_title(); ?></div>
		 </div>
		 <div class="idxc_test_clearfix"></div>
	</div>
<?php endwhile; else: ?>
<p>
	<?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif; ?>
<!-- Page Navigation -->
<?php genesis_posts_nav(); ?>