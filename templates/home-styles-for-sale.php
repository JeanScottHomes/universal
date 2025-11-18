<?php
// TODO: Breadcrumbs placement causing CLS. Needs review. (TJS 08/22/25)

/**
 * Template Name: Home Styles for Sale
 * Template Post Type: page
 *
 * TJS 08/03/25
 */

/** 
 * NOTE: THIS TEMPLATE FOLLOWS SITEWIDE PAGE (page.php) FORMAT & STYLING:
 * • universal/styles/sitewide-page.css.
 * 
 * THE ONLY EDIT IS NOTED BELOW. 
 * SEE: *HOME STYLES EDIT* Line 41
 */

/* FORCE SINGLE COLUMN */
add_filter('genesis_pre_get_option_site_layout', function ($layout) {
    if (is_page_template('templates/home-styles-for-sale.php')) {
        return 'full-width-content';
    }
    return $layout;
});

// Handle "breadcrumb-bar" pseudo-URLs (TJS 08/27/25)
if (preg_match('#/breadcrumb-bar/?$#', $_SERVER['REQUEST_URI'])) {
    $new = preg_replace('#/breadcrumb-bar/?$#', '', $_SERVER['REQUEST_URI']);
    wp_safe_redirect($new . '#breadcrumb-bar');
    exit;
}

// Scroll-to-top anchor placed safely at the top (TJS 08/27/25)
add_action('genesis_before_content_sidebar_wrap', function () {
    echo '<div id="breadcrumb-bar"></div>';
}, 1);

/* BREADCRUMBS BAR (breadcrumbs-h1-php) */
add_action('genesis_before_content_sidebar_wrap', function () {
    echo do_shortcode('[breadcrumbs_h1]');
}, 5);

remove_action('genesis_loop', 'genesis_do_loop');

/* OPEN CITY PAGE WRAPPER AND OUTPUT TOP BUTTON BEFORE CONTENT */

add_action('genesis_before_loop', function () {
    $market_id = get_field('optima_express_market_id', get_the_ID());
?>

    <div class="sitewide-page-content"> <!-- SITEWIDE DEFAULT PAGE WRAP (page.php) -->
        <div class="button-link-sitewide-wrap">
            <!-- *HOME STYLES EDIT* -->
            <a class="button-link-sitewide" href="#homes-for-sale">
                🏡 Explore <?php echo esc_html(get_the_title()); ?>
            </a>
        </div>


        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content();
            }
        }
        ?>

        <!-- USE THIS CODE IN iHomeFinder Markets: https://account idxhome.com/markets Under each section, Listing Report, Open Houses, and Market Report.
		
        <h3>Photos on the Way</h3>
        <p>Listings showing <em>No Property Photo Available</em> are brand-new listings. Photos are on the way! Please check back shortly.</p>

        <div style="text-align: left; margin: 1.5rem 0;">
	        <a href=""
		        class="breadcrumb-bar"
		        style="display: inline-block; padding: 0.5rem 1.25rem; background-color: rgba(255, 255, 0, 0.05); color: rgba(0, 0, 0, 0.75); border: 1px solid rgba(0, 125, 184, 1); border-radius: 5px; font-weight: 400; letter-spacing: 0.5px; text-decoration: none; text-transform: uppercase;">
 		        &#129517; Discover More About 
            </a>
        </div>
        -->

    </div>

    <div class="sitewide-page-spacer"></div>

    <div id="homes-for-sale"></div>

    <?php
    $shortcode = get_post_meta(get_the_ID(), 'ihomefinder_market_report_shortcode', true);

    if (!empty($shortcode)) {
        echo '<div class="ihomefinder_market_report_wrap">';
        echo do_shortcode($shortcode);
        echo '</div>';
    }
    ?>

<?php
});

genesis();
