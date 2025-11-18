<?php
// Moved from theme root: single-idxc_featlist.php
// TJS 2025-09-02 — Relocated into /universal/templates/ for organization.

// 🔹 TJS 05/03/25 — Exact backup copy of the template in place on 05-03-25.

// Add Custom Body class to page if defined
add_filter('body_class', function ($classes) {
    $custom_class = get_post_meta(get_the_ID(), '_custom_body_class', true);
    if (!empty($custom_class)) {
        $classes[] = sanitize_html_class($custom_class);
    }
    return $classes;
});

// Remove the standard loop
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'mychild_replacement_loop');

function mychild_replacement_loop()
{
    global $post;
    echo '<article class="entry">';
    include(get_stylesheet_directory() . "/lib/idxc_addons/featured_listings/dsp_single.php");
    echo '</article>';
}

remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); // Remove Breadcrumb Trail
remove_action('genesis_before_post_content', 'genesis_post_info');
remove_action('genesis_after_post_content', 'genesis_post_meta');
remove_action('genesis_after_post', 'genesis_do_author_box_single');
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

// Check if the 'featured' parameter exists in the URL
if (isset($_GET['featured'])) {
    // Removes footer widgets.
    remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
    remove_action('genesis_before_footer', 'child_add_footertop', 1);

    // Removes site footer elements.
    remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
    remove_action('genesis_footer', 'genesis_do_footer');
    remove_action('genesis_footer', 'child_do_footer');
    remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

    function add_custom_body_class_singleprop($classes)
    {
        $classes[] = 'single_property';
        return $classes;
    }
    add_filter('body_class', 'add_custom_body_class_singleprop');

    // Replace Genesis Header with a custom one that adds an additional widget area
    remove_action('genesis_header', 'child_do_header');
    add_action('genesis_header', 'listing_do_header');

    function listing_do_header()
    {
        global $post;
        $prefix = "_idxc_mb_featuredlistings_";

        $address = get_post_meta($post->ID, $prefix . "address", true);
        $thegallerynumber = get_post_meta($post->ID, $prefix . "gallery_id", true);
        $tour_url = get_post_meta($post->ID, $prefix . "tour_url", true);
        $tour_image = get_post_meta($post->ID, $prefix . "tour_image", true);

        echo '<div class="header_inner_wrap">';

        genesis_widget_area('ict_header_left', array(
            'before' => '<div id="header_left_widget" class="header_left_widget">',
            'after' => '</div>',
        ));

        echo '<div class="widget-area header-widget-area">';

        echo '<div class="primary_nav_container">';
        echo '<nav class="nav-primary genesis-responsive-menu" aria-label="Main" id="genesis-nav-primary" style="">';
        echo '<div class="wrap">';
        echo '<ul id="menu-primary" class="menu genesis-nav-menu menu-primary js-superfish sf-js-enabled sf-arrows" style="touch-action: pan-y;">';
        echo '<li class="menu-item menu_first menu-item-first"><a href="#details"><span>Details</span></a></li>';
        if (!empty($thegallerynumber)) {
            echo '<li class="menu-item"><a href="#photos"><span>Photos</span></a></li>';
        }
        if (!empty($tour_url) && !empty($tour_image)) {
            echo '<li class="menu-item"><a href="#video"><span>Video</span></a></li>';
        }
        echo '<li class="menu-item"><a href="#contact"><span>Contact</span></a></li>';
        if (!empty($address)) {
            echo '<li class="menu-item menu_last menu-item-last"><a href="#map"><span>Map</span></a></li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</nav>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    add_action('genesis_footer', 'listing_do_footer');
    function listing_do_footer()
    {
        if (is_active_sidebar('footer-top')) {
            echo '<div id="footer_top" class="footer_top_widget jarallax"><div class="wrap"><div class="wrap_overlay">';
            genesis_widget_area('footer-top', array('before' => '', 'after' => ''));
            echo '</div></div></div>';
        }

        $license_number = cmb2_get_option('md_main_options', 'license_number');

        echo '<div class="disclaimer_info">';
        echo '<p>';
        if ($license_number) {
            echo 'DRE# ' . $license_number . ' &nbsp;&nbsp;&#8226;&nbsp;&nbsp; ';
        }
        echo '&copy;' . date('Y') . ' All Rights Reserved';
        echo '</p>';
        echo '</div>';
    }
}

genesis();

