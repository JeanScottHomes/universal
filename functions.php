<?php

//* Start the engine
include_once(get_template_directory() . '/lib/init.php');

//* Setup Theme
include_once(get_stylesheet_directory() . '/lib/theme-defaults.php');

//* Add Image upload to WordPress Theme Customizer
require_once(get_stylesheet_directory() . '/lib/customize.php');

//* Child theme (do not remove)
define('CHILD_THEME_NAME', 'IDXCentral');
define('CHILD_THEME_URL', 'http://www.idxcentral.com/');
define('CHILD_THEME_VERSION', '24.4.19');

if (!function_exists('site_is_geo_taxonomy')) {
  /**
   * True when the current query matches the geo taxonomy (legacy or current slug).
   */
  function site_is_geo_taxonomy($term = '')
  {
    $taxonomies = array('geo_taxonomy', 'geo');
    if ($term === '') {
      return is_tax($taxonomies);
    }

    return is_tax($taxonomies, $term);
  }
}

// Any requires or initial setup
require_once get_template_directory() . '/lib/init.php';
require_once __DIR__ . '/functions/nextgen-imagely-activity-logger.php';
require_once __DIR__ . '/functions/optima-idx-yoast-seo.php';

// 🔻 Replace Genesis default header
remove_action('genesis_header', 'genesis_do_header');
add_action('genesis_header', 'child_do_header');

function child_do_header()
{

  echo '<div class="header_inner_wrap">';

  // Right widget
  echo '<div class="widget-area header-widget-area">';
  genesis_widget_area('header-right', array(
    'before' => '<div id="header_right_widget" class="header_right_widget"><div class="wrap">',
    'after' => '</div></div>',
  ));

  // Left widget
  genesis_widget_area('ict_header_left', array(
    'before' => '<div id="header_left_widget" class="header_left_widget">',
    'after' => '</div>',
  ));

  // Primary nav container with hamburger and menu
  //    echo '<div class="primary_nav_container">';
  //    echo '<button id="primary-nav-hamburger" aria-label="Menu Toggle" class="primary-nav-button">☰</button>';
  //    echo genesis_do_nav(); // ✅ This is the primary menu
  //    echo '</div>'; // Close .primary_nav_container

  echo '</div>'; // Close .header-widget-area

  echo '<div class="primary_nav_container">';
  echo '<button id="primary-nav-hamburger" aria-label="Menu Toggle" class="primary-nav-button">☰</button>';
  echo '<button type="button" id="close_side_nav" class="close-btn" aria-label="close navigation"><i class="fa fa-times"></i></button>';

  echo genesis_do_nav(); // ✅ This is the primary menu
  echo '</div>'; // Close .primary_nav_container

  echo '</div>'; // Close .header_inner_wrap
}

// TODO(Vision): Remove once Cloudflare view sync is ready.
// Post Views Counter is disabled, so we no longer need to prime the front-page
// post object for the plugin.
// $__jsh_inc = __DIR__ . '/functions/front-page-views-count.php';
// if (file_exists($__jsh_inc)) {
//   require_once $__jsh_inc;
// }

/* Do we need this? TJS 09/22/25

Force-hide PHP notices/warnings/deprecated messages in Local
Hardened to avoid undefined HTTP_HOST during CLI/cron on .local

{
  $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
  if (defined('WP_LOCAL_DEV') || ($host !== '' && strpos($host, '.local') !== false)) {
    @ini_set('display_errors', 0);
    error_reporting(0);
  }
}
  */

//* Testing - Temp Code (use as needed)
define('RANDOM_TESTER', mt_rand(10000, 99999));

/**
 * Return a consistent mmddyy_hhmm version string for a local file.
 * Falls back to the theme version when the file is missing or unreadable.
 */
function css_file_version_stamp($absolute_path)
{
  if (!file_exists($absolute_path))
    return CHILD_THEME_VERSION;

  $mtime = filemtime($absolute_path);
  if (!$mtime)
    return CHILD_THEME_VERSION;

  return wp_date('mdy_Hi', $mtime);
}

//* Set theme color body class
add_filter('body_class', 'set_theme_custom_classes');
function set_theme_custom_classes($classes)
{
  $classes[] = 'precision_classic smb_header_3 smb_footer_single smb_sc_5 smb_ubc_2 ihf_image_centric smb_header_dark';
  return $classes;
}

add_action('genesis_meta', 'enqueue_idx_addon_master_styles');

add_action('wp_enqueue_scripts', function () {
  $addons_path = get_stylesheet_directory() . '/lib/idxc_addons/css/styles_addons.css';
  wp_enqueue_style(
    'idxc-addon-master-styles',
    get_stylesheet_directory_uri() . '/lib/idxc_addons/css/styles_addons.css',
    [],
    css_file_version_stamp($addons_path),
    'all'
  );
  // Breadcrumbs + H1 bar styles (versioned by file mtime for cache-busting)
  $breadcrumbs_h1_path = get_stylesheet_directory() . '/styles/breadcrumbs-h1.css';
  wp_enqueue_style(
    'breadcrumbs-h1-styles',
    get_stylesheet_directory_uri() . '/styles/breadcrumbs-h1.css',
    [],
    css_file_version_stamp($breadcrumbs_h1_path),
    'all'
  );
});

/*
wp_enqueue_style('idxc-addon-master-styles', get_stylesheet_directory_uri() . '/lib/idxc_addons/css/styles_addons.css', array(), CHILD_THEME_VERSION, 'all');
*/

// Force full-width layout on the homepage so the hero video can span edge-to-edge.
add_filter('genesis_site_layout', function ($layout) {
  if (is_front_page()) {
    return 'full-width-content';
  }

  return $layout;
}, 5);

// 🔹 Enqueue IDX Addon Styles (still required)
add_action('genesis_meta', 'enqueue_idx_addon_master_styles');
function enqueue_idx_addon_master_styles()
{
  $addons_path = get_stylesheet_directory() . '/lib/idxc_addons/css/styles_addons.css';
  wp_enqueue_style(
    'idxc-addon-master-styles',
    get_stylesheet_directory_uri() . '/lib/idxc_addons/css/styles_addons.css',
    array(),
    css_file_version_stamp($addons_path),
    'all'
  );

  $site_index_css_path = get_stylesheet_directory() . '/styles/site-index-pages.css';
  if (file_exists($site_index_css_path)) {
    wp_enqueue_style(
      'site-index-pages',
      get_stylesheet_directory_uri() . '/styles/site-index-pages.css',
      array(),
      css_file_version_stamp($site_index_css_path)
    );
  }
}

// 🔷 TJS – Enqueue External Fonts and Slick Slider Styles
add_action('wp_enqueue_scripts', 'jsh_enqueue_external_styles');
function jsh_enqueue_external_styles()
{
  // Google Fonts (sitewide usage)
  wp_enqueue_style(
    'google-fonts',
    '//fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Montserrat:ital@0;1&display=swap&subset=latin',
    array(),
    null
  );

  /* wp_enqueue_style(
    'google-fonts',
    '//fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Montserrat:ital@0;1&display=swap',
    array(),
    null
  );\
  */

  // Slick Slider (used in IDXCentral carousels)
  wp_enqueue_style(
    'idx-style-slick',
    '//cdn.idxcentral.net/assets/slick-accessibility/slick/slick.min.css',
    array(),
    null
  );

  /** TJS 09/09/25
   * Uupdated code to exclude foreign font styles
   */
  wp_enqueue_style(
    'idx-style-slick-theme',
    '//cdn.idxcentral.net/assets/slick-accessibility/slick/accessible-slick-theme.min.css',
    array(),
    null
  );
}

// 🔹 Enqueue Scripts (unchanged – placeholder for your JS enqueues)
add_action('wp_enqueue_scripts', 'idxcentral_enqueue_scripts');


//* Enqueue Scripts
add_action('wp_enqueue_scripts', 'idxcentral_enqueue_scripts');
function idxcentral_enqueue_scripts()
{
  //wp_enqueue_script('idxcentral-responsive-menu', get_bloginfo('stylesheet_directory') . '/scripts/footer/responsive-menu.js', array('jquery'), CHILD_THEME_VERSION); // included via footer js scripts below
  //wp_enqueue_script( 'waypoints-script', get_bloginfo( 'stylesheet_directory' ) . '/lib/js/waypointanim.js', array( 'jquery' ), CHILD_THEME_VERSION );
  wp_enqueue_script('custom_script', get_bloginfo('stylesheet_directory') . '/lib/js/custom_script.js', array('jquery'), CHILD_THEME_VERSION);
  wp_enqueue_script('jarallax_main', get_bloginfo('stylesheet_directory') . '/lib/js/jarallax/jarallax.js', array('jquery'), CHILD_THEME_VERSION);
  wp_enqueue_script('jarallax_video', get_bloginfo('stylesheet_directory') . '/lib/js/jarallax/jarallax-video.js', array('jquery'), CHILD_THEME_VERSION);
  wp_enqueue_script('idx-js-ihf', '//cdn.idxcentral.net/assets/ihomefinder/js-ihf-core.js', array(), CHILD_THEME_VERSION); // iHomefinder
  //wp_enqueue_script( 'idx-js-idxb', '//cdn.idxcentral.net/assets/idxbroker/js-idxb.js', array(), CHILD_THEME_VERSION ); // IDX Broker

  // 🔹 TJS - Local Contact CTA Popup
  wp_enqueue_script('jsh-contact-cta', get_stylesheet_directory_uri() . '/scripts/footer/contact-cta.js', array(), CHILD_THEME_VERSION, true);
  wp_enqueue_style('jsh-contact-cta-style', get_stylesheet_directory_uri() . '/styles/contact-cta.css', array(), CHILD_THEME_VERSION);
}

// 🔧 Route Featured Listings single template from /templates/
add_filter('single_template', function ($template) {
  if (is_singular('idxc_featlist')) {
    $path = get_stylesheet_directory() . '/templates/featured-listings-idxc.php';
    if (file_exists($path))
      return $path;
  }
  return $template;
});

// (replaced below) Per-file styles enqueue handled by jsh_enqueue_additional_styles

//* Load scripts before closing the body tag
add_action('genesis_after_footer', 'idxcentral_script_managment');
function idxcentral_script_managment()
{
  wp_register_script('jarallax_init', get_bloginfo('stylesheet_directory') . '/lib/js/jarallax_init.js');
  wp_enqueue_script('jarallax_init', get_bloginfo('stylesheet_directory') . '/lib/js/jarallax_init.js', array('jquery'), CHILD_THEME_VERSION);
  wp_enqueue_script('idx-slick-js', '//cdn.idxcentral.net/assets/slick-accessibility/slick/slick.min.js', array(), CHILD_THEME_VERSION);
}

// Registers the responsive menus.
if (function_exists('genesis_register_responsive_menus')) {
  genesis_register_responsive_menus(genesis_get_config('responsive-menus'));
}

//* Add HTML5 markup structure
add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

//* Add Accessibility support
add_theme_support('genesis-accessibility', array('404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links'));

//* Add viewport meta tag for mobile browsers
add_theme_support('genesis-responsive-viewport');

//* Add support for custom background

add_theme_support('custom-background');

//* Add support for structural wraps
add_theme_support('genesis-structural-wraps', array(
  'header',
  'nav',
  'subnav',
  'site-inner',
  'footer-widgets',
  'footer',
));

//* Add support for 2-column footer widgets
add_theme_support('genesis-footer-widgets', 1);

//* Add new image sizes
add_image_size('home-slider', 1600, 900, TRUE);        // Change per design
add_image_size('custom_1', 500, 500, TRUE);            // Custom size ususally used for CTA or Featured Image

//* Remove unused theme settings
add_action('genesis_theme_settings_metaboxes', 'child_remove_metaboxes');
function child_remove_metaboxes($_genesis_theme_settings_pagehook)
{
  remove_meta_box('genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main');
  remove_meta_box('genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main');
  //remove_meta_box( 'genesis-theme-settings-feeds', $_genesis_theme_settings_pagehook, 'main' );
  //remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
  remove_meta_box('genesis-theme-settings-layout', $_genesis_theme_settings_pagehook, 'main');
  //remove_meta_box( 'genesis-theme-settings-comments', $_genesis_theme_settings_pagehook, 'main' );
  //remove_meta_box( 'genesis-theme-settings-posts', $_genesis_theme_settings_pagehook, 'main' );
  //remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );
  //remove_meta_box( 'genesis-theme-settings-scripts', $_genesis_theme_settings_pagehook, 'main' );
}

//* Set Default Layout
genesis_set_default_layout('full-width-content');
//genesis_set_default_layout( 'content-sidebar' );


//* Unregister layout settings
genesis_unregister_layout('sidebar-content');
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');
genesis_unregister_layout('sidebar-content-sidebar');

//* Unregister unused sidebar(s)
//unregister_sidebar( 'header-right' );
//unregister_sidebar( 'sidebar' );
unregister_sidebar('sidebar-alt');

//* Remove Customizer Sections from Genesis Child Theme
add_action('customize_register', 'childprefix_remove_genesis_customizer_section', 99);
function childprefix_remove_genesis_customizer_section()
{
  global $wp_customize;
  $remove_customizer_section = array(
    //        'genesis_updates',
    'genesis_header',
    //        'genesis_adsense',
    //        'genesis_color_scheme',
    'genesis_layout',
    //        'genesis_breadcrumbs',
    //        'genesis_comments',
    //        'genesis_archives',
    //        'genesis_scripts',
    'genesis_footer',
    'agentpress-image',
    'background_image',
    'colors',
  );

  foreach ($remove_customizer_section as $section):
    $wp_customize->remove_section($section);
  endforeach;
}

// Remove the default Edit page link located at the bottom of the page
add_filter('edit_post_link', '__return_empty_string');

//* Modify the WordPress read more link
add_filter('the_content_more_link', 'idxcentral_read_more');
function idxcentral_read_more()
{
  return '<a class="more-link" href="' . get_permalink() . '">' . __('Continue Reading', 'idxcentral') . '</a>';
}

//* Modify the content limit read more link
add_action('genesis_before_loop', 'idxcentral_more');
function idxcentral_more()
{
  add_filter('get_the_content_more_link', 'idxcentral_read_more');
}

add_action('genesis_after_loop', 'idxcentral_remove_more');
function idxcentral_remove_more()
{
  remove_filter('get_the_content_more_link', 'idxcentral_read_more');
}

//* Remove entry meta in entry footer
add_action('genesis_before_entry', 'idxcentral_remove_entry_meta');
function idxcentral_remove_entry_meta()
{

  //* Remove if not single post
  if (!is_single()) {
    remove_action('genesis_entry_footer', 'genesis_entry_footer_markup_open', 5);
    remove_action('genesis_entry_footer', 'genesis_post_meta');
    remove_action('genesis_entry_footer', 'genesis_entry_footer_markup_close', 15);
  }
}

//* Remove comment form allowed tags
add_filter('comment_form_defaults', 'idxcentral_remove_comment_form_allowed_tags');
function idxcentral_remove_comment_form_allowed_tags($defaults)
{
  $defaults['comment_notes_after'] = '';
  return $defaults;
}


//* Register widget areas
genesis_register_sidebar(array(
  'id' => 'ict_header_left',
  'name' => 'Header Left',
  'description' => 'This is a sidebar that is located inside the header on the left.',
));
/*
genesis_register_sidebar( array(
  'id'			=> 'slider',
  'name'			=> __( 'Slider / Banner', 'idxcentral' ),
  'description'	=> __( 'This is the slider / banner section.', 'idxcentral' ),
) );
*/
genesis_register_sidebar(array(
  'id' => 'slider_content',
  'name' => __('Slider / Banner Content', 'idxcentral'),
  'description' => __('This is the content that will overlay the slider / banner section.', 'idxcentral'),
));
genesis_register_sidebar(array(
  'id' => 'under_banner',
  'name' => __('Under Banner Area', 'idxcentral'),
  'description' => __('This is the widget for the quicksearch or under banner content', 'idxcentral'),
));
genesis_register_sidebar(array(
  'id' => 'home-feature-1',
  'name' => __('Home Feature #1', 'idxcentral'),
  'description' => __('Home Feature - Section 1', 'idxcentral'),
));
genesis_register_sidebar(array(
  'id' => 'footer-top',
  'name' => __('Footer Top', 'idxcentral'),
  'description' => __('Section located just above the primary footer.', 'idxcentral'),
));

//* Unregister Secondary, by only specifying the Primary navigation menu
add_theme_support('genesis-menus', array('primary' => __('Primary Navigation Menu', 'genesis')));

//* Reposition the navigation - Remove here and add where needed below
remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');


/* IDXCentral Standard Modifications */

/** Remove the WordPress version information from source code AND rss feed */
function idxcentral_remove_version()
{
  return '';
}
add_filter('the_generator', 'idxcentral_remove_version');

/** Allow shortcodes in text widgets */
add_filter('widget_text', 'do_shortcode');
// add_filter( 'widget_text', 'shortcode_unautop');

/** Customize footer */
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
remove_action('genesis_footer', 'genesis_do_footer');
add_action('genesis_footer', 'child_do_footer');
function child_do_footer()
{

  // If Footer top does not include content, then don't display
  if (is_active_sidebar('footer-top')) {
    echo '<div id="footer_top" class="footer_top_widget jarallax"><div class="wrap"><div class="wrap_overlay">';

    genesis_widget_area('footer-top', array(
      'before' => '',
      'after' => '',
    ));

    echo '</div></div></div>';
  }

  echo genesis_footer_widget_areas();

  // Check if DRE field contains a value from the Site Options page
  $license_number = cmb2_get_option('md_main_options', 'license_number');

?>
  <div class="disclaimer_info">
    <div class="disclaimer_inner">
      <p><?php if ($license_number) {
            echo 'DRE# ' . $license_number . ' &nbsp;&nbsp;&#8226;&nbsp;&nbsp; ';
          } ?><a href="<?php bloginfo('url'); ?>/sitemap/">sitemap</a> &nbsp;&nbsp;&#8226;&nbsp;&nbsp; <a
          href="<?php bloginfo('url'); ?>/privacy-policy/">privacy policy</a> &nbsp;&nbsp;&#8226;&nbsp;&nbsp; <a
          href="<?php bloginfo('url'); ?>/dashboard/">admin</a> &nbsp;&nbsp;&#8226;&nbsp;&nbsp;
        &copy;<?php echo date("Y"); ?> All Rights Reserved &nbsp;&#8226;&nbsp; <a href="https://www.idxcentral.com/"
          target="_blank">Real Estate Website Design <span class="screen-reader-text">opens in new window</span></a> by
        IDXCentral.com</p>
      <!--<div class="disclaimer_legal">
    <p>Disclaimer legal text</p>
  </div>-->
    </div>
  </div>
<?php
}

/** Add special class to first and last menu items (regardless of heirarchy */
function idxc_first_and_last_menu_class($items)
{
  $items[1]->classes[] = 'menu_first';
  $items[count($items)]->classes[] = 'menu_last';
  return $items;
}
add_filter('wp_nav_menu_objects', 'idxc_first_and_last_menu_class');


// Add special class to top level items only
function idxc_add_first_and_last_top_level($items)
{
  $topitems = [];
  foreach ($items as $menu_item) {
    if ($menu_item->menu_item_parent == 0) {
      $topitems[] = $menu_item->menu_order;
    }
  }
  $itemcount = end($topitems);
  $items[1]->classes[] = 'menu-item-first';
  $items[$itemcount]->classes[] = 'menu-item-last';
  return $items;
}

add_filter('wp_nav_menu_objects', 'idxc_add_first_and_last_top_level');


// Get Add-on scripts and custom functions
require_once(get_stylesheet_directory() . '/lib/idxc_addons/init.php');
require_once(get_stylesheet_directory() . '/lib/includes/common.php');

// Add Support for Fluid Videos
function responsive_video_js()
{
  wp_register_script('fluidvids', get_stylesheet_directory_uri() . '/lib/js/fluidvids.js', array(), CHILD_THEME_VERSION, true);
  wp_enqueue_script('fluidvids'); // Enqueue it!
}
add_action('wp_head', 'responsive_video_js');

//* Hide primary menu when loading responsive menu
//* Hide elements with:: body.no-on-load elementName {display:none;}
add_filter('body_class', function ($classes) {
  $classes[] = 'no-on-load';
  return $classes;
});
// Add script to remove temporary class to hide elements
add_action('genesis_after', function () {
?>
  <script>
    //<![CDATA[
    (function(jQuery) {
      jQuery(document).ready(function() {
        jQuery("body").removeClass("no-on-load")
      });
    }(jQuery));
    //]]>
  </script>
<?php
}, 10);


//* Disable the superfish script
/*
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
wp_deregister_script( 'superfish' );
wp_deregister_script( 'superfish-args' );
}
*/

// Enqueue Inline Styles (original script from Bill Erickson: http://www.billerickson.net/code/enqueue-inline-styles/)
function idxc_enqueue_inline_styles()
{
  $css = '';

  // Default Variables
  $neighborhood_image = cmb2_get_option('md_main_options', 'neighborhood_image_home');
  $accent_image = cmb2_get_option('md_main_options', 'accent_image_home');
  $footer_image = cmb2_get_option('md_main_options', 'footer_image');
  $interior_header_image = cmb2_get_option('md_main_options', 'interior_header_image');


  // Add override css rules
  if ($neighborhood_image) {
    $css .= '.community-right-content { background-image: url(' . $neighborhood_image . ');}';
  }
  if ($accent_image) {
    $css .= '.homepage-mosiac-image {background-image: url(' . $accent_image . ');}';
  }
  if ($footer_image) {
    $css .= '#footer_top { background-image: url(' . $footer_image . ');}';
  }
  if ($interior_header_image) {
    //$css .= '.site-header {background-image: linear-gradient(rgba(250, 250, 250, 0.85), rgba(250, 250, 250, 0.85)),url(' . $interior_header_image . ');}';
    $css .= '.site-header {background-image: url(' . $interior_header_image . ');}';

    // Add body class if header image exists
    add_filter('body_class', function ($classes) {
      $classes[] = 'sh_image';
      return $classes;
    });
  }

  //remove slider bottom border if under banner widget exists
  if (is_active_sidebar('under_banner')) {
    $css .= '.slider_wrap {border-bottom: none;}';
  }

  if (!empty($css))
    wp_register_style('idxcentral', false);
  wp_enqueue_style('idxcentral');
  wp_add_inline_style('idxcentral', $css);
}
add_action('wp_enqueue_scripts', 'idxc_enqueue_inline_styles');


// Add support for video banner
add_action('genesis_after_footer', 'idxc_video_script');
function idxc_video_script()
{
  $vimeo = cmb2_get_option('md_main_options', 'vimeo_id');
  $youtube = cmb2_get_option('md_main_options', 'youtube_id');

  if (is_front_page() && ($vimeo != '' || $youtube != '')) {
    wp_enqueue_script('video-script', get_bloginfo('stylesheet_directory') . '/lib/js/video-script.js', array('jquery'), '1.0.0', false);
    wp_register_script('video-script', get_bloginfo('stylesheet_directory') . '/lib/js/video-script.js');
  }
}

add_action('wp_enqueue_scripts', 'idxcentral_enqueue_scripts_preconnect');
function idxcentral_enqueue_scripts_preconnect()
{
  $vimeo = cmb2_get_option('md_main_options', 'vimeo_id');
  $youtube = cmb2_get_option('md_main_options', 'youtube_id');

  // Add vimeo specific support
  if (is_front_page() && $vimeo != '') {
    wp_enqueue_style('preconnect-vimeo', "https://player.vimeo.com", array(), null);
    wp_enqueue_style('preconnect-vimeo-i', "https://i.vimeocdn.com", array(), null);
    //wp_enqueue_style('preconnect-vimeo-f', "https://f.vimeocdn.com", array(), null);

    function custom_function_to_preload($html, $handle)
    {
      if (strpos($handle, 'preconnect') === 0) {
        return str_replace("rel='stylesheet'", "rel='preconnect'", $html);
      }
      return $html;
    }
  }
}

// Get first image found in post content (initially used for the featured posts add-on. may consider moving to the addon_core file)
function catch_that_image()
{
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $post_content = $post->post_content;
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $find_images);
  $output2 = preg_match_all('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $find_img_alts);

  $first_img = $find_images[1][0];
  $first_img_alt = $find_img_alts[1][0];

  // Check if an image is found in the post content and get image if one exists.
  if (empty($first_img)) { // Defines a default image
    $first_img = "";
    //$first_img = "/images/default.jpg"; // Set default image if desired
    $final_output = "";
  } else {
    $final_output = '<img src="' . $first_img . '" alt="Background image of ' . $first_img_alt . '" loading="lazy"/>';
  }
  return $final_output;
}

// Add attributes to Contact Links in the Primary and Side menu to open the contact page modal
function add_custom_class_to_menu_items($atts, $item, $args)
{
  // Replace 2095,2096 with your actual menu item IDs
  $menu_items_to_modify = array(2095, 2096);

  if (in_array($item->ID, $menu_items_to_modify)) {
    // Add the custom class
    if (empty($atts['class'])) {
      $atts['class'] = 'md_modal_trigger';
    } else {
      $atts['class'] .= ' md_modal_trigger';
    }

    // Add custom attributes
    $atts['data-modal'] = 'modal_contact1';
    $atts['role'] = 'button';
    $atts['aria-haspopup'] = 'dialog';
    $atts['aria-controls'] = 'modal_contact1';
  }

  return $atts;
}
add_filter('nav_menu_link_attributes', 'add_custom_class_to_menu_items', 10, 3);


// Feature that adds a large Banner image to the top of a page with the title showing over the top
// ORIGINAL require_once( get_stylesheet_directory() . '/lib/includes/page-banner-images.php' );


add_action('template_redirect', function () {
  if (
    is_page() &&
    (is_page_template('page_cc_area.php') || is_page_template('page_cc_no_title.php'))
  ) {
    require_once(get_stylesheet_directory() . '/lib/includes/page-banner-images_cc.php');
  } else {
    require_once(get_stylesheet_directory() . '/lib/includes/page-banner-images_cc.php');
  }
});


// Site Options styles to hide certain sections during initial setup. Comment this out when setup completed.
//require_once( get_stylesheet_directory() . '/lib/idxc_addons/site_options/includes/wp_admin_styles.php' );

/*								*/
/* Custom Modifications 		*/
/*								*/

// Cities widget area
genesis_register_sidebar(array(
  'id' => 'cc_widget_cities',
  'name' => __('Cities Widget', 'genesis'),
  'description' => __('Section for cities results', 'genesis'),
));


add_action('cmb2_admin_init', 'add_nexgen_gallery_field');
function add_nexgen_gallery_field()
{
  $cmb = new_cmb2_box(array(
    'id' => 'nexgen_gallery_metabox',
    'title' => 'NexGen Gallery',
    'object_types' => array('page'), // Post type
    'context' => 'side', // Context: 'normal', 'side', or 'advanced'
    'priority' => 'high', // Priority: 'high', 'core', 'default', or 'low'
  ));

  $cmb->add_field(array(
    'name' => 'NexGen Gallery',
    'id' => 'nexgen_gallery_id',
    'type' => 'text',
    'description' => 'Enter NexGen Gallery ID',
  ));
}

function get_nggalleries()
{
  $galleries = get_terms('nggallery', array('hide_empty' => true));
  $options = array();
  foreach ($galleries as $gallery) {
    $options[$gallery->term_id] = $gallery->name;
  }
  return $options;
}

add_action('init', function () {
  if (is_admin() && isset($_GET['post'])) {
    $post_id = intval($_GET['post']);
    $template = get_post_meta($post_id, '_wp_page_template', true);

    if ($template === 'page_cc_area.php') {
      add_post_type_support('page', 'excerpt');
    }
  }
});


add_action('cmb2_admin_init', 'add_ihomefinder_market_report_field');

function add_ihomefinder_market_report_field()
{
  $cmb = new_cmb2_box(array(
    'id' => 'area_pages_custom_fields',
    'title' => 'Custom Fields for Area Pages',
    'object_types' => array('page'), // Post type
    'context' => 'normal', // Below the content editor
    'priority' => 'high', // High priority
  ));

  $cmb->add_field(array(
    'name' => 'Market Report Shortcode',
    'id' => 'ihomefinder_market_report_shortcode',
    'type' => 'textarea',
    'description' => 'Enter the shortcode for the IHomefinder Market Report.',
  ));
}


add_action('cmb2_admin_init', 'add_second_featured_image');

function add_second_featured_image()
{
  $cmb = new_cmb2_box(array(
    'id' => 'jsh_custom_fields',
    'title' => 'JSH Additional Fields',
    'object_types' => array('page'),
    'context' => 'normal',
    'priority' => 'high',
  ));

  $cmb->add_field(array(
    'name' => 'Secondary Featured Image',
    'id' => 'secondary_featured_image',
    'type' => 'file',
    'description' => 'Add additional featured image, this will override standard version.',
    'options' => array(
      'url' => false,
    ),
    'preview_size' => 'medium',
    'save_id' => true,
  ));
}

add_action('init', function () {
  if (is_admin() && isset($_GET['post'])) {
    $post_id = intval($_GET['post']);
    $template = get_post_meta($post_id, '_wp_page_template', true);

    if ($template === 'page_cc_area.php') {
      add_post_type_support('page', 'excerpt');
    }
  }
});

/**
 * 🔹 TJS 06/12/25 – Enqueue infinite scroll JS with ajax localization.
 */

function sitewide_enqueue_infinite_scroll_script()
{
  $script_path = get_stylesheet_directory_uri() . '/scripts/footer/sitewide-grid-infinite-scroll.js';

  wp_enqueue_script('infinite-scroll', $script_path, [], '1.0', true);
  wp_localize_script('infinite-scroll', 'infinite_scroll_ajax_object', [
    'ajax_url' => admin_url('admin-ajax.php'),
  ]);
}

add_action('wp_enqueue_scripts', 'sitewide_enqueue_infinite_scroll_script');

// 🔷 TJS – Load main stylesheet LAST for maximum override power
add_action('wp_enqueue_scripts', 'enqueue_universal_main_styles', 999);
function enqueue_universal_main_styles()
{
  wp_enqueue_style(
    'universal-main-style',
    get_stylesheet_directory_uri() . '/style.css',
    array('idxc-addon-master-styles'), // Load this AFTER addons
    css_file_version_stamp(get_stylesheet_directory() . '/style.css'),
    'all'
  );
}

// Ensure Genesis does not enqueue the default theme stylesheet with a static version.
add_action('after_setup_theme', function () {
  remove_action('genesis_meta', 'genesis_load_stylesheet');
  remove_action('wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet');
  remove_action('wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 5);
});

// 🔄 TJS 07/07/25 – Inject hamburger menu before primary nav

// 🔻 Add class to body via inline JS (used to trigger CSS)
add_action('wp_head', function () {
  echo "<script>document.addEventListener('DOMContentLoaded',function(){document.body.classList.add('has-hamburger-menu');});</script>";
});

// ✅ Safely add class to body for JS styling logic
add_action('wp_footer', function () {});


/** 🚨🚨🚨🚨🚨🚨🚨🚨🚨🚨
 * WARNING, WILL ROBINSON:
 * Keep this block at the *bottom* of functions.php to ensure 
 * all enqueues and shortcodes load after everything else.
 *  🚨🚨🚨🚨🚨🚨🚨🚨🚨🚨
 */


// LOAD FRONT PAGE CONTENT (moved to /shortcodes via auto-loader below)


/**
 * ======================================
 * 🔧 Enqueue Custom JS (Head vs Footer)
 * ======================================
 */

function jsh_enqueue_all_custom_scripts()
{
  $js_base_dir = get_stylesheet_directory() . '/scripts/';
  $js_base_url = get_stylesheet_directory_uri() . '/scripts/';
  $js_head_dir = $js_base_dir . 'head/';
  $js_footer_dir = $js_base_dir . 'footer/';
  $js_head_url = $js_base_url . 'head/';
  $js_footer_url = $js_base_url . 'footer/';

  // Head scripts
  if (is_dir($js_head_dir)) {
    foreach (glob($js_head_dir . '*.js') as $file) {
      $handle = 'jsh-head-' . basename($file, '.js');
      wp_enqueue_script($handle, $js_head_url . basename($file), [], filemtime($file), false);
    }
  }

  // Footer scripts from /scripts/footer/
  if (is_dir($js_footer_dir)) {
    foreach (glob($js_footer_dir . '*.js') as $file) {
      // Skip sitewide-grid-infinite-scroll.js (handled with localization elsewhere)
      if (basename($file) === 'sitewide-grid-infinite-scroll.js')
        continue;
      $handle = 'jsh-footer-' . basename($file, '.js');
      wp_enqueue_script($handle, $js_footer_url . basename($file), [], filemtime($file), true);
    }
  }

  // Footer scripts directly in /scripts/
  foreach (glob($js_base_dir . '*.js') as $file) {
    $handle = 'jsh-root-' . basename($file, '.js');
    wp_enqueue_script($handle, $js_base_url . basename($file), [], filemtime($file), true);
  }
}
add_action('wp_enqueue_scripts', 'jsh_enqueue_all_custom_scripts');


$function_files = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator(get_stylesheet_directory() . '/functions/', RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($function_files as $file) {
  if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    require_once $file;
  }
}


// ============================
// Load Additional Stylesheets
// ============================
function jsh_enqueue_additional_styles()
{
  $styles_dir = get_stylesheet_directory() . '/styles/';
  $styles_uri = get_stylesheet_directory_uri() . '/styles/';

  if (!is_dir($styles_dir))
    return;

  // Loop through all .css files in /styles/ and version by file timestamp (mmddyy_hhmm)
  foreach (glob($styles_dir . '*.css') as $css_file) {
    $base = basename($css_file);
    if ($base === 'error-404.css')
      continue; // handled separately
    if ($base[0] === '.')
      continue; // skip dotfiles

    $handle = 'jsh-' . pathinfo($base, PATHINFO_FILENAME);
    $ver = css_file_version_stamp($css_file);

    wp_enqueue_style(
      $handle,
      $styles_uri . $base,
      array(),
      $ver,
      'all'
    );
  }
}
add_action('wp_enqueue_scripts', 'jsh_enqueue_additional_styles');

// Conditionally enqueue 404-only stylesheet
add_action('wp_enqueue_scripts', function () {
  if (!is_404())
    return;
  $css_file = get_stylesheet_directory() . '/styles/error-404.css';
  if (file_exists($css_file)) {
    wp_enqueue_style('jsh-error-404', get_stylesheet_directory_uri() . '/styles/error-404.css', array(), css_file_version_stamp($css_file));
  }
});

// TJS 09/08/25 — Override Redirection IP links to ipinfo.io on the Redirection admin screen only
add_action('admin_enqueue_scripts', function ($hook) {
  // Redirection plugin main admin page hook is 'tools_page_redirection'
  if ($hook !== 'tools_page_redirection')
    return;

  $script_path = get_stylesheet_directory() . '/scripts/footer/redirection-ipinfo.io-url.js';
  if (!file_exists($script_path))
    return; // nothing to load – script retired

  // Enqueue the tiny override that rewrites the IP links
  wp_enqueue_script(
    'redirection-ipinfo',
    get_stylesheet_directory_uri() . '/scripts/footer/redirection-ipinfo.io-url.js',
    [],
    '1.0',
    true
  );
});

/**
 * Admin Bar: Show CSS versions loaded on the current page (front-end only, admins).
 * Lists theme styles in /styles plus main style.css with their ?ver values.
 */

/* TJS 2025-09-02 — Admin Bar CSS Versions: show only /style.css and /styles/*, de-duplicate by URL
 */
add_action('admin_bar_menu', function ($wp_admin_bar) {
  if (is_admin())
    return; // only front-end
  if (!is_user_logged_in() || !current_user_can('manage_options'))
    return;

  global $wp_styles;
  if (!isset($wp_styles) || empty($wp_styles->queue))
    return;

  $parent_id = 'jsh-css-versions';
  $wp_admin_bar->add_node([
    'id' => $parent_id,
    'title' => 'CSS Versions',
    'href' => false,
  ]);

  $theme_uri = untrailingslashit(get_stylesheet_directory_uri());
  $styles_uri = $theme_uri . '/styles/';

  $seen_paths = [];
  $items = [];
  foreach ($wp_styles->queue as $handle) {
    if (!isset($wp_styles->registered[$handle]))
      continue;
    $reg = $wp_styles->registered[$handle];
    $src = isset($reg->src) ? $reg->src : '';
    $ver = isset($reg->ver) ? $reg->ver : '';

    // Normalize relative src to absolute
    if ($src && strpos($src, '//') === false && strpos($src, 'http') !== 0) {
      $src = $wp_styles->base_url . $src;
    }

    // Only show main style.css and files under /styles/
    $is_theme_style = false;
    if ($src) {
      if (strpos($src, $styles_uri) === 0) {
        $is_theme_style = true;
      } elseif (strpos($src, $theme_uri . '/style.css') === 0) {
        $is_theme_style = true;
      }
    }

    if (!$is_theme_style)
      continue;

    // De-duplicate by path
    $path_key = parse_url($src, PHP_URL_PATH);
    if (isset($seen_paths[$path_key]))
      continue;
    $seen_paths[$path_key] = true;

    $label = basename(parse_url($src, PHP_URL_PATH));
    $display = $label . ($ver ? ' — ver ' . esc_html($ver) : '');

    $items[] = [
      'order' => strtolower($label),
      'id' => $parent_id . '-' . sanitize_key($handle),
      'title' => $display,
      'href' => $src,
    ];
  }

  if (!empty($items)) {
    usort($items, function ($a, $b) {
      return strcmp($a['order'], $b['order']);
    });

    foreach ($items as $item) {
      $wp_admin_bar->add_node([
        'id' => $item['id'],
        'title' => $item['title'],
        'href' => $item['href'],
        'parent' => $parent_id,
      ]);
    }
  }
}, 100);


// =====================
// Load Shortcode Files
// =====================

$shortcode_dir = get_stylesheet_directory() . '/shortcodes/';

// Load all .php files directly in /universal/shortcodes/
foreach (glob($shortcode_dir . '*.php') as $file) {
  require_once $file; // Top-level shortcode
}

// Load all .php files in one-level subfolders of /universal/shortcodes/
foreach (glob($shortcode_dir . '*/' . '*.php') as $file) {
  require_once $file; // Shortcode in /shortcodes/some-folder/
}

// ============================================
// Load all PHP files in /universal/functions/
// ============================================
foreach (glob(get_stylesheet_directory() . '/universal/functions/*.php') as $file) {
  require_once $file;
}

/**
 * TJS 2025-08-30 19:35 UTC — WP Rocket filter hardening
 * Context: Flywheel PHP logs showed warnings from FooBox's WP Rocket compatibility
 *  (Array to string conversion). Some plugins assume these filters always receive
 *  arrays; in rare cases a string/null can be passed, triggering notices.
 *
 * Goal: Normalize the filter inputs to arrays to prevent noisy warnings without
 *  touching plugin code. Safe no-ops for proper array inputs.
 *
 * Rollback: Remove this block if not needed; it is isolated and additive only.
 */

if (!function_exists('jsh_force_array')) {
  function jsh_force_array($value)
  {
    if (is_array($value))
      return $value;
    if ($value === null || $value === false || $value === '')
      return [];
    return [$value];
  }
}

add_filter('rocket_delay_js_exclusions', 'jsh_force_array', 1);
add_filter('rocket_exclude_defer_js', 'jsh_force_array', 1);

// (Rolled back) Admin bar edit-link rewrite — removed due to breadcrumb issues
add_filter('rocket_exclude_js', 'jsh_force_array', 1);
add_filter('rocket_defer_inline_exclusions', 'jsh_force_array', 1);
add_filter('rocket_excluded_inline_js_content', 'jsh_force_array', 1);
