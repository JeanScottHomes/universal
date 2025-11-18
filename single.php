<?php

/**
 * Template Name: Sitewide Single Post (Default)
 * Template Post Type: post
 * DEFAULT SITEWIDE SINGLE POST TEMPLATE
 * TJS 092924
 */

/* SINGLE COLUMN TEMPLATE */
add_filter('genesis_pre_get_option_site_layout', function ($layout) {
    // Force single column on Sitewide Single Post template
    return 'full-width-content'; // Genesis single-column layout for all posts

    // Still force single column on iHomefinder report pages (redundant but left for clarity)
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

    <!-- SITEWIDE DEFAULT POST WRAP (single.php) -->
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
