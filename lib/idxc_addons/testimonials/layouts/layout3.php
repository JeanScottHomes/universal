<div class="md_testimonials_cont">
	<div class="md_testimonials_cont_wrap">
	<div class="md_testimonials_excerpt comments-space" data-show-char="<?php echo $number_of_characters ;?>">
		<?php the_content(); ?>
	</div>
	<div class="md_testimonials_title_cont"><span class="md_testimonials_sigmark">- </span><?php echo !empty($author_name) ? $author_name : get_the_title(); ?></div>
	<div class="clearfix"></div>
	</div>
</div>