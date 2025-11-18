<div class="gen_results_c">
    
    
    
    <a href="<?php the_permalink() ?>" class="gen_results_link_wrap" rel="bookmark" aria-label="<?php the_title(); ?>">
        <div class="gen_results_wrap_inner">
            
				<?php if ($thumbnail != '' && is_numeric($thumbnail)) : ?>
                	<img src="<?php echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=' . $image_height . ' crop=1 float= display_view="custom/idxcimgonly-view.php" quality=60 ]'); ?>" alt="" />
                <?php else: ?>
                	<img src="<?php echo get_stylesheet_directory_uri() ?>/images/no-photo-available.jpg" alt="" />
                <?php endif; ?>
            
            <?php /* Option - Link Overlay :: START */ ?>
            <div class="ao_fn_text_overlay">
            	<div class="ao_fn_text_overlay_wrap">
                        <h2><?php the_title(); ?></h2>
                </div>
            </div>
            <?php /* Option - Link Overlay :: END */ ?>
            <?php /* <div class="idxc_fn_description"><?php the_content_limit($desc_characters, "Details"); ?></div>  */ ?>
            <div style="clear:both;"></div>
        </div>
    
    </a>
    
    
</div>