<?php

/**
 * Template Name: Sitewide Page (Default)
 * Template Post Type: page
 * DEFAULT SIDEWIDE PAGE TEMPLATE
 * TJS 090224 0443
 */

/* SINGLE COLUMN TEMPLATE */
add_filter('genesis_pre_get_option_site_layout', function ($layout) {
    // Force single column on Sitewide Page template
    if (is_page_template('page.php')) {
        return 'full-width-content'; // Genesis single-column layout
    }

    // Force single column on iHomefinder report pages
    if (is_singular() && strpos($_SERVER['REQUEST_URI'], '/homes-') === 0) {
        return 'full-width-content';
    }

    return $layout;
});

/* BREADCRUMBS BAR (breadcrumbs-h1-php) */
add_action('genesis_before_content_sidebar_wrap', function () {
    echo do_shortcode('[breadcrumbs_h1]');
}, 5);

remove_action('genesis_loop', 'genesis_do_loop');

/* OPEN CITY PAGE WRAPPER AND OUTPUT TOP BUTTON BEFORE CONTENT */

add_action('genesis_before_loop', function () {
?>

    <!-- SITEWIDE DEFAULT PAGE WRAP (page.php) -->
    <div class="sitewide-page-content">

        <!-- <div class="button-link-sitewide-wrap">
            <a class="button-link-sitewide" href="#homes-for-sale">🏡 Explore Homes for Sale in <?php echo esc_html(get_the_title()); ?></a>
        </div> -->

        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content();
            }
        }
        ?>
    </div>

    <!-- THIS SECTION IS ONLY FOR IDX TEMPLATES:
    • universal/templates/cities-communities.php
    • universal/templates/home-styles-for-sale.php

    <div id="homes-for-sale"></div>

    <div class="sitewide-page-spacer"></div> 
    -->

    <?php
    /* CONTINUED

    $shortcode = get_post_meta(get_the_ID(), 'ihomefinder_market_report_shortcode', true);

    if (!empty($shortcode)) {
        echo '<div class="ihomefinder_market_report_wrap">';
        echo do_shortcode($shortcode);
        echo '</div>';
    }
    * END SECTION ONLY FOR IDX TEMPLATES: */
    ?>

<?php
});

genesis();

/**
 * HERO IMAGE AND BODY CLASSES (match 404.php/page.php behavior)
 * Adds a pb_title hero section above content to eliminate CLS.
 */

// Output hero after header using featured image from a reference page or a default theme image
add_action('genesis_after_header', function () {

    // Use the same hero image used in 404.php to ensure visual consistency
    $image_url = '/wp-content/uploads/Daytona-Beach-Florida-Umbrella-and-Chairs-1600x901.jpeg';

    if (!empty($image_url)) {
        echo '<section class="pb_title" id="pb_title" role="complementary" style="background-image: url(\'' . esc_url($image_url) . '\')">';
        echo '<div class="wrap"></div>';
        echo '</section>';
    }
}, 5);

// Add body classes so spacing/styles match page templates with heroes
add_filter('body_class', function ($classes) {
    // This file only loads for the Optima Express template, so unconditionally add classes
    $classes[] = 'pb_image_active';
    $classes[] = 'sh_image';
    return $classes;
});

// Ensure header overlay is transparent over hero like editor pages
add_action('wp_head', function () {
    echo '<style id="optima-idx-hero-fix">.pb_image_active.sh_image .site-header > .wrap{background:transparent;} </style>';
});
