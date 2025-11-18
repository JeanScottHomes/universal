<?php
/* 
Add-on: Featured Posts
Layout: base1 (originally created for Napa theme)
Created: 2023-03-07
Author: Mark Moineau
Version: 1.0.0
*/
?>

<div class="ao_featured_posts_container<?php if ($class != "") { echo " " . $class;} ?>">
	<?php if ($title != "") { ?>
		<h2><?php echo $title; ?></h2>
	<?php } ?>
	<?php $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post();

		// Check for featured image
		$image_found = '';	
		if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
				$image_found = get_the_post_thumbnail($post->ID, $thumbnail_size, array( 'loading' => 'lazy' ));
			} else {
				$image_found = catch_that_image();
		}
		?>
		<div class="ao_featured_posts_item">
			<?php if ( ($show_thumbnail == "y") && $image_found != '' ) {  ?>
			<div class="ao_featured_posts_image"><a href="<?php the_permalink() ?>"><?php echo $image_found; ?></a></div>
			<?php } ?>
			<div class="ao_featured_posts_content">
			<div class="ao_featured_posts_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
			<div class="ao_featured_posts_text"><?php the_content_limit_textonly($number_of_characters); ?></div>
			<div class="ao_featured_posts_link"><a href="<?php the_permalink() ?>" class="iul_button">Full Story</a></div>
			</div>
		</div>

	<?php endwhile; ?>
</div>