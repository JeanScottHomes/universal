<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category IDXCentral Add-on Control Panel
 * @package  Add-ons
 * @license  Copyright IDXCentral
 * @link     https://www.idxcentral.com
 */
 
/* add css style sheet  */
add_action( 'wp_enqueue_scripts', 'idxc_enqueue_admin_styles' );
/**
* Enqueue admin style sheet for featured listings metabox.
*
* @since 1.0.0
*/
function idxc_enqueue_admin_styles() {
	$style_path = get_stylesheet_directory() . '/lib/idxc_addons/css/style.css';
	$version = function_exists('css_file_version_stamp')
		? css_file_version_stamp($style_path)
		: (file_exists($style_path) ? filemtime($style_path) : CHILD_THEME_VERSION);

	wp_enqueue_style(
		'idxc-featured-listings',
		get_stylesheet_directory_uri() . '/lib/idxc_addons/css/style.css',
		array(),
		$version
	);
}

/* Load Add-ons */
require_once(get_stylesheet_directory() . '/lib/idxc_addons/neighborhoods/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/featured_listings/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/rentals/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/testimonials/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/agent_roster/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/landing_pages/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/directory_pages/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/directory/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/featured_posts/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/site_options/addon_core.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/common/common.php');
require_once(get_stylesheet_directory() . '/lib/idxc_addons/shortcodes/init.php');
