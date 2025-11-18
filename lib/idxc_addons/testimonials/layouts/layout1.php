<div class="md_testimonials_cont">
	<div class="md_testimonials_cont_wrap">
	<?php if ( $show_thumbnail == "y") { if ( has_post_thumbnail()) { ?><div class="md_custom_frame_small md_alignleft <?php if ($show_shadow == 'y') {echo ' md_custom_frame_shadow';} ?>"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail_testimonials' ); ?></a></div><?php }} ?>
	<div class="md_testimonials_excerpt"><span class="md_testimonials_rightquote">"</span><?php the_content_limit_textonly($number_of_characters); ?><span class="md_testimonials_leftquote">"</span><span>&nbsp;<a href="<?php bloginfo('url'); ?>/testimonials/" class="md_morelink_in" aria-label="view all testimonials">view testimonials</a></span></div>
	<div class="md_testimonials_title_cont"><span class="md_testimonials_sigmark">- </span><?php the_title(); ?></div>
	<div class="clearfix"></div>
	</div>
</div>