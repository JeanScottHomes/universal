<?php
/* 
Add-on: Featured Neighborhoods
Layout: Standard Grid
Created: 2022-07-19
Author: Mark Moineau
Version: 1.0.0
*/
?>



<div class="ao_fn_wrap_outer">
	<div class="ao_fn_wrap_inner"> 
		<a href="<?php the_permalink() ?>" class="ao_fn_primary_link" >
			<div class="ao_fn_image_container">
				<?php // thumnail / single picture
				if ($thumbnail != '') { ?>
				<img class="ao_fn_image" src="<?php echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=' . $image_height . ' crop=1 float= display_view="custom/idxcimgonly-view.php" quality=60 ]'); ?>" alt="Learn more about <?php the_title(); ?>" loading="lazy"/>
				<?php } ?>
			</div>
			<div class="ao_fn_text_overlay">
				<div class="ao_fn_text_overlay_wrap">
					<div class="ao_fn_text_title"><?php the_title(); ?></div>
					<?php if ($button_text != '') { ?><span><?php echo $button_text; ?></span><?php } ?>
				</div>
			</div>
		</a>
	</div>
</div>