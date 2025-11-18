<?php
/* 
Add-on: Featured Posts
Layout: Layout1 (originally created for Starter theme 2023)
Created: 2023-07-24
Author: Mark Moineau
Version: 1.0.0
*/
?>

<div class="iul_post1 isc_container<?php if ($class != "") { echo " " . $class;} ?>">
		
	<?php if ($title != "") { ?>
		<h2><?php echo $title; ?></h2>
	<?php } ?>
	<?php $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();

		// Check for featured image echo get_the_post_thumbnail( $post_id, 'post-thumbnail', array( 'loading' => 'lazy' ) );
		$image_found = '';	
		if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
				$image_found = get_the_post_thumbnail($post->ID, $thumbnail_size, array( 'loading' => 'lazy' ));
			} else {
				$image_found = catch_that_image();
		}
		?>
		<div class="isc_item" role="article"> 
			<a href="<?php the_permalink() ?>">
				<?php if ( ($show_thumbnail == "y") && $image_found != '' ) {  ?>
					<div class="isc_img_container"><?php echo $image_found; ?></div>
				<?php } ?>
				<div class="isc_content_wrap">
					<h2 class="isc_title"><?php the_title(); ?></h2>
					<div class="isc_content"><?php the_content_limit_textonly($number_of_characters); ?></div>
					<div class="isc_button">Read More</div>
				</div>
			</a>
		</div>

	<?php endwhile; ?>
</div>
