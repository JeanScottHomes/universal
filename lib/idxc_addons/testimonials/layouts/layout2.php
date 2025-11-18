<div class="isc_card">
	<div class="isc_wrap"> 
		<!-- Author Info -->
		<div class="isc_accent">
			<?php if (!empty($author_initials)) { echo '<div class="isc_author_initials">' . $author_initials . '</div>';}  ?>
			<?php if (empty($author_initials)) { echo '<div class="isc_quotation_mark">&#8220;</div>';} ?>
		</div>
		<div class="isc_content comments-space" data-show-char="<?php echo $number_of_characters ;?>">
			<?php the_content(); ?>
		</div>
		<div class="isc_author_name"><?php echo !empty($author_name) ? $author_name : get_the_title(); ?></div>

	</div>
</div>
