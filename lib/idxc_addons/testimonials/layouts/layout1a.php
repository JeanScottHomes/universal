<div class="md_testimonials_cont">
	<div class="md_testimonials_cont_wrap">
	<?php if ( $show_thumbnail == "y") { if ( has_post_thumbnail()) { ?><div class="md_custom_frame_small md_alignleft <?php if ($show_shadow == 'y') {echo ' md_custom_frame_shadow';} ?>"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail_testimonials' ); ?></a></div><?php }} ?>
	<div class="md_testimonials_excerpt"><span class="md_testimonials_rightquote">"</span><?php the_content_limit_textonly($number_of_characters); ?><?php if ($show_more_link == "inside" && $length_of_string > $number_of_characters) { ?><span>&nbsp;<a href="<?php the_permalink() ?>" class="md_morelink_in" aria-label="continue to testimonial">continue</a></span><?php } ?><span class="md_testimonials_leftquote">"</span></div>
	<div class="md_testimonials_title_cont"><span class="md_testimonials_sigmark">- </span><?php the_title(); ?></div>
	<div class="clearfix"></div>
	</div>
</div>