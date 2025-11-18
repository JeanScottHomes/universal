<?php

/* ******** DO NOT HIT CMD + SAVE. ********
 * PRETTIER WILL FORMAT AND THROW AN ERROR. 
 ***************************** ************/ 

add_action( 'genesis_meta', 'idxc_home_genesis_meta' );

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */

/*
 * 🎥 Hero Video Banner
 * - Displays as the hero section on desktop only.
 * - Uses a poster image for lazy-load (optimized screenshot shown until playback).
 * - Supports either Vimeo or YouTube, never both (decided by settings).
 * - Intentional design choice for site aesthetics and performance.
 */

function idxc_home_genesis_meta() {

	if ( is_active_sidebar( 'ict_header_left' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		// Check for video banner option
		$vimeo_video_id = cmb2_get_option( 'md_main_options', 'vimeo_id' );
		$youtube_video_id = cmb2_get_option( 'md_main_options', 'youtube_id' );

		if ($youtube_video_id != '' || $vimeo_video_id != ''){
			add_action( 'genesis_before_loop', 'idxc_home_loop_helper_video', 1 );						// add video content inside Main landmark element
		} elseif ($youtube_video_id == '' && $vimeo_video_id == '') {
			add_action( 'genesis_before_loop', 'idxc_home_loop_helper_banner', 1 ); 					// add banner image(s) inside Main landmark element
		}
		
		add_action( 'genesis_before_loop', 'idxc_home_loop_helper_features', 2 );                       // add content inside Main landmark element
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );		// force full width content layout
        add_filter( 'genesis_markup_site-inner', '__return_null' );                                     // remove site-inner markup
        add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );                    // remove site-inner structural wrap markup
        add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );                           // remove content-sidebar markup
        
        
		
		// Enqueue scripts for full screen image (simply comment this section if client does not want the full screen image)
        $banner_type = cmb2_get_option( 'md_main_options', 'homepage_banner_height' );
		/**/
        
        if( $banner_type == 'fullscreen' ) {
            // Add body class for fullscreen banner
            add_filter( 'body_class', function ( $classes ) {
                $classes[] = 'banner_fullscreen';
                return $classes;
            } );
            
            add_action( 'wp_enqueue_scripts', 'idxcentral_enqueue_scripts_homepg' );
            function idxcentral_enqueue_scripts_homepg() {
                wp_enqueue_script( 'home-script', get_bloginfo( 'stylesheet_directory' ) . '/lib/js/home.js', array( 'jquery' ), '1.0.0' );
                wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/lib/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
                wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/lib/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
            }
        } else {
            
            // Add body class for fixed banner
            add_filter( 'body_class', function ( $classes ) {
                $classes[] = 'banner_fixed';
                return $classes;
            } );
            
        }
				
	}
}

/**
 * Display widget content for "Slider" (Banner) section.
 *
 */	
function idxc_home_loop_helper_banner() {
	
	echo '<div class="slider_wrap"><div class="slider">';
    
    // Add Slider widget area
	genesis_widget_area( 'slider', array(
		'before' => '',
		'after' => '',
	) );
    
    // Include Banner Image Slider
    ob_start(); // turn on output buffering
    include(get_stylesheet_directory()."/lib/idxc_addons/site_options/includes/banner_image.php");  
    $fileStr = ob_get_contents(); // get the contents of the output buffer
    ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering
    
    
	genesis_widget_area( 'slider_content', array(
		'before' => '<div class="slider_content_container"><div class="slider_content_inner qs_compact">',
		'after' => '</div>'. $fileStr .'</div>',
	) );
    
	echo '</div>';
	
	genesis_widget_area( 'under_banner', array(
		'before' => '<div class="under_banner_area">',
		'after' => '</div>',
	) );
	
	echo '</div><div class="md_clearfix"></div>';
		    
}


/** Video banner **/
function idxc_home_loop_helper_video() {
	
	$vimeo_video_id = cmb2_get_option( 'md_main_options', 'vimeo_id' );
    $youtube_video_id = cmb2_get_option( 'md_main_options', 'youtube_id' );
	$video_poster = cmb2_get_option( 'md_main_options', 'video_banner' );
	$video_alt = cmb2_get_option( 'md_main_options', 'video_alt' );
	$video_option = cmb2_get_option( 'md_main_options', 'video_option' );
	
	if ( $video_option == 'on' ) {

		add_action( 'genesis_after_footer', 'mobile_video_script' );

		function mobile_video_script() {
			wp_enqueue_script( 'mobile-script', get_bloginfo( 'stylesheet_directory' ) . '/lib/js/mobile_video_script.js', array( 'jquery' ), '1.0.15' );

		}
	}
	
	echo '<div class="banner_outer"><div class="banner_row_1">';
	echo '<div class="feature_wrapper">';

	genesis_widget_area( 'slider_content', array(
		'before' => '<div class="slider_content_container"><div class="slider_content_inner qs_compact">',
		'after' => '</div></div>',
	) );

	echo '<div class="feature video"><div class="video_bg cover video_option_'.$video_option.'">';
	
	// Get first image from banner image list
	$files = cmb2_get_option( 'md_main_options', 'banner_image_list', 1 );
	$first_id = key($files);
	$first_url = reset($files);
	?>
	
	<img src="<?php echo esc_url( $first_url ); ?>" sizes="(max-width: 768px) 800px,(max-width: 1200px) 1400px, (max-width: 1600px) 1600px, 100vw" class="vimg video_poster_mobile" alt="">
	<?php if ( $video_poster != '' ) { ?>
		
	<img src="<?php echo esc_url( $video_poster ); ?>" sizes="(max-width: 768px) 800px,(max-width: 1200px) 1400px, (max-width: 1600px) 1600px, 100vw" class="vimg video_poster" alt="<?php echo $video_alt; ?>">
	<?php ;} ?>

    <div id="video" class="animate video_wrapper fadein" style="transform: translate(-50%, -50%) scale(1);">
      	<div id="player" class="video_banner" >
		  
		<?php // Vimeo video container
			if ($vimeo_video_id != '' && $youtube_video_id == '') { 
		echo '<iframe src="https://player.vimeo.com/video/'.$vimeo_video_id.'?h=f99fa401c1&autoplay=1&loop=1&title=0&byline=0&portrait=0&background=1&dnt=1" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="video_banner" role="none"></iframe><script src="https://player.vimeo.com/api/player.js"></script>'
		 ;} ?>
		  
		</div>
		
       <?php // YouTube video container script will add necessary player to the #player ID 
			if ($youtube_video_id != '' && $vimeo_video_id == '') { ?>
		<script type="text/javascript">
			
			var myvid = '<?php echo $youtube_video_id; ?>';
			
			var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
			var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var player;
            var playerWrapper = document.querySelector('#video');
			
            function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					videoId: myvid,  // youtube video id
					allowfullscreen: 1,
					playerVars: {
						'enablejsapi': 1,
						'autoplay': 1,
						'rel': 0,
						'iv_load_policy': 3,
						'showinfo': 0,
						'modestbranding': 1,
						'playsinline': 1,
						'showinfo': 0,
						'rel': 0,
						'controls': 0,
						'color':'white',
						'loop': 0,
						'mute':1,
						'wmode': 'opaque',
						'vq': 'hd720'
					},
                	events: {
						'onReady': onPlayerReady,
						'onStateChange': onPlayerStateChange
					}
				});
			}
			function onPlayerReady() {
				player.playVideo();
              	player.mute();
			}
            function onPlayerStateChange(el) {
				if(el.data === 1) {
					playerWrapper.classList.add('fadein')
				} else if(el.data === 0) {
                // playerWrapper.classList.remove('fadein')
                player.playVideo();
                player.mute();
              }
            }
         // }
        </script>
		
		<?php ;} ?>
		</div>
	<!-- end video container -->
<?php
	
	echo '</div></div></div><!-- end feature_wrapper -->';
	echo '</div><!-- end banner_row_1 -->';
	
	genesis_widget_area( 'under_banner', array(
		'before' => '<div class="under_banner_area">',
		'after' => '</div>',
	) );
	
	echo '</div><!-- end banner_outer -->';
	echo '<div class="md_clearfix"></div>';
	
}
// end video banner function


function idxc_home_loop_helper_features() {

	genesis_widget_area( 'home-feature-1', array(
		'before' => '<div class="home_feature_row home_feature_1"><div class="wrap">',
		'after' => '</div></div>',
	) );
		
	genesis_widget_area( 'home-feature-2', array(
		'before' => '<div class="home_feature_row home_feature_2"><div class="wrap">',
		'after' => '</div></div>',
	) );
	
	genesis_widget_area( 'home-feature-3', array(
		'before' => '<div class="home_feature_row home_feature_3"><div class="wrap">',
		'after' => '</div></div>',
	) );
	
	genesis_widget_area( 'home-feature-footer', array(
		'before' => '<div class="home_feature_row home_feature_footer"><div class="wrap">',
		'after' => '</div></div>',
	) );	
}

genesis();