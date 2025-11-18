<?php

// Add custom body class to WordPress Admin Dashboard to hide sections during initial setup - idxc_setupDISABLED
add_filter( 'admin_body_class', 'idxc_admin_body_class' );
function idxc_admin_body_class( $classes )
{
    // Check if user is "idxcentral" ... if not add idxc_setup class to body tag so we can target and hide elements we don't want client to see during the setup phase
    $user = wp_get_current_user();
    if($user && isset($user->user_login) && 'idxcentral' != $user->user_login) {
        $classes .= ' idxc_setup';
        return $classes;
    }
}

// Add Custom CSS to WordPress Admin Dashboard to hide certain elements from client during setup phase
add_action('admin_head', 'my_custom_css');

function my_custom_css() {
  echo '<style>
.idxc_setup #adminmenu #toplevel_page_md_main_options {display: list-item;}
.idxc_setup #adminmenu > li {display: none;}
.idxc_setup div#wpadminbar, .idxc_setup p div#wpadminbar, .idxc_setup #screen-meta-links {display:none;}
.idxc_setup .setup_hidden, .idxc_setup .cmb2-id-banner-image-list, .idxc_setup .cmb2-id-neighborhood-image-home, .idxc_setup .cmb2-id-accent-image-home, .idxc_setup .cmb2-id-footer-image, .idxc_setup .cmb2-id-interior-header-image, .idxc_setup .cmb2-id-homepage-banner-height, .idxc_setup .cmb2-id-neighborhood-results, .idxc_setup .cmb2-id-vimeo-id, .idxc_setup .cmb2-id-youtube-id, .idxc_setup .cmb2-id-video-banner, .idxc_setup .cmb2-id-video-alt, .idxc_setup .cmb2-id-video-option {display:none;}
</style>';
}