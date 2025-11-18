<?php
/* 
Add-on: Featured Posts
Layout: list (originally created for Starter 2023 theme)
Created: 2023-07-20
Author: Mark Moineau
Version: 1.0.0
*/
?>


<ul class="ao_featured_posts<?php if ($class != "") { echo " " . $class;} ?>">
	<?php if ($title != "") { ?>
		<h2><?php echo $title; ?></h2>
	<?php } ?>
	<?php $recent = new WP_Query($args); while($recent->have_posts()) : $recent->the_post(); ?>
		<li class="isc_item"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
</ul>
