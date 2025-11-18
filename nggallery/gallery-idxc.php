<?php

/**
 * @var \Imagely\NGG\DataStorage\Manager $storage
 * @var \Imagely\NGG\DataTypes\DisplayedGallery $displayed_gallery
 * @var \Imagely\NGG\DataTypes\Image[] $images
 * @var string $effect_code
 * @var string $id
 * @var string $thumbnail_size_name
 */

use Imagely\NGGPro\Display\HiDPI;

?>
<?php $this->start_element('nextgen_gallery.gallery_container', 'container', $displayed_gallery); ?>

<div class="nextgen_pro_sidescroll" id="gallery_<?php echo esc_attr($id); ?>">

	<div class="nextgen_pro_sidescroll_wrapper">

		<?php
		$this->start_element('nextgen_gallery.image_list_container', 'container', $images);

		$i = 0;

		foreach ($images as $image) {

			$template_params = [
				'index' => $i,
				'class' => 'image-wrapper',
				'image' => $image,
			];

			$this->start_element('nextgen_gallery.image_panel', 'item', $image); ?>

			<div id="<?php echo esc_attr('ngg-image-' . $i); ?>" class="image-wrapper">

				<?php $this->start_element('nextgen_gallery.image', 'item', $image); ?>

				<a href=""
					title="<?php echo esc_attr($image->description); ?>"
					data-ngg-captions-nostylecopy="1"
					data-src="<?php echo esc_attr($storage->get_image_url($image)); ?>"
					data-thumbnail="<?php echo esc_attr($storage->get_image_url($image, 'thumb')); ?>"
					data-image-id="<?php echo esc_attr($image->{$image->id_field}); ?>"
					data-title="<?php echo esc_attr($image->alttext); ?>"
					data-description="<?php echo esc_attr(stripslashes($image->description)); ?>"
					<?php echo $effect_code; ?>>
					<?php HiDPI::render_picture_element(
						$image,
						$thumbnail_size_name,
						['class' => 'nextgen_pro_sidescroll_image']
					);
					?>
				</a>

				<?php $this->end_element(); ?>
			</div>
			<?php $this->end_element(); ?>
		<?php
			++$i;
		}
		$this->end_element(); ?>
	</div>
</div>
<?php $this->end_element();
