<?php
/* 
Add-on: Featured Listings
Layout: Original (original layout)
Created: 2022-01-01 (estimated date)
Author: Mark Moineau
Version: 1.0.0
*/
?>

<div class="gen_results_c">	
    <a href="<?php the_permalink() ?>" rel="bookmark" class="gen_results_link" aria-label="Listing details: <?php the_title(); ?>, <?php if ($price != '') { echo $price . ", ";} ?> <?php if ($beds != '') { echo $beds . "beds, ";} ?> <?php if ($baths != '') { echo $baths . "baths, ";} ?> <?php if ($sqft != '') { echo $sqft . "square feet";} ?>">
    <div class="gen_results_wrap_inner clearfix">
	<div class="gen_results_imgth">  	
		<?php if ($thumbnail != '' && is_numeric($thumbnail)) : ?>
            <img src="<?php echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=' . $image_height . ' crop=1 float= display_view="custom/idxcimgonly-view.php" quality=60 ]'); ?>" alt="<?php the_title(); ?>" loading="lazy"/>
        <?php else: ?>
            <img src="<?php echo get_stylesheet_directory_uri() ?>/images/no-photo-available-325x215.jpg" alt="<?php the_title(); ?>" loading="lazy"/>
        <?php endif; ?>
        
		<?php if (strtolower($status) != 'active' && $status != '') { ?><div class="gen_status_sm"><?php if ($status_other != '') { echo $status_other; } else { echo $status;} ?></div><?php } ?>
	</div>
	<h2><?php the_title(); ?></h2>
	<?php if ($price != '') { echo "<strong>Priced&nbsp;at&nbsp;$" . number_format(intval($price), 0, '', ',') . "</strong>&nbsp;&nbsp;&nbsp;";} ?>
	<?php if ($property_type == 'Land') { // Land Fields (add as needed)?>
		Land Listing
	<?php } else { // Residential fields ?>	
		<?php if ($beds != '' || $sqft != '') {?>
			<?php if ($beds != '') { echo "<strong>Beds:</strong>&nbsp;" . $beds . "&nbsp;&nbsp;&nbsp;";} ?>
			<?php if ($baths != '') { echo "<strong>Baths:</strong>&nbsp;" . $baths . "&nbsp;&nbsp;&nbsp;";} ?>
			<?php if ($sqft != '') { echo "<strong>Sq.&nbsp;Feet:</strong>&nbsp;" . $sqft;} ?>
			<br />
		<?php } ?>
	<?php } ?>	
	<?php /* <div class="idxc_fl_description"><?php the_content_limit(100); ?></div> */ ?>
	<div style="clear:both;"></div>
    </div>
    </a>
</div>