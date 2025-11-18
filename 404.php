<?php

/**
 * 404 Page
 * Matches the default page template (page.php).
 * This version is perfect! It exactly matches the output of this content in the page.php template built in the WordPress classic editor
 * TJS 09/10/25
 */


/* Force single-column layout on 404 */
add_filter('genesis_pre_get_option_site_layout', function ($layout) {
    if (is_404()) {
        return 'full-width-content';
    }
    return $layout;
});

/* Breadcrumbs bar (same as page.php pattern)
 * The breadcrumbs shortcode intentionally omits the H1 on 404 so it can live here.
*/

add_action('genesis_before_content_sidebar_wrap', function () {
    echo do_shortcode('[breadcrumbs_h1]');
}, 5);

/* Replace default loop with custom 404 content inside sitewide page wrapper */
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_before_loop', function () {
    // No hero image here; see genesis_before_content_sidebar_wrap.
?>
    <!-- SITEWIDE DEFAULT PAGE WRAP (match page.php) -->
    <div class="sitewide-page-content">

        <div class="entry-content">
            <?php

            // H1 rendering:
            // The H1 appears inside the breadcrumbs bar via [breadcrumbs_h1].
            // To customize the 404 H1 text, edit the filter below or remove it
            // to fall back to the default in universal/shortcodes/breadcrumbs-h1.php:39.

            // Ensure the 404 H1 text used by breadcrumbs matches exactly
            add_filter('breadcrumbs_404_title', function ($title) {
                return 'That Home or Page Was Not Found';
            }, 1);
            ?>

            <div class="button-link-sitewide-wrap">
                <a class="button-link-sitewide" href="/central-florida-home-search/">🏡 Explore More Homes for Sale <?php echo esc_html(get_the_title()); ?></a>
            </div>

            <!-- Image left, text right (wraps like front page) -->
            <div class="front-page-block front-page-block--image-left">
                <div class="signature-image-container alignleft">
                    <img
                        class="signature-image"
                        src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/Page-Not-Found-Lets-Keep-Looking-400x225.jpg' ); ?>"
                        alt="😎 It's Awesome Here. – Let’s Keep Looking!"
                        width="400"
                        height="225" />
                    <div class="signature-image__caption">😎 It's Awesome Here. Let’s Keep Looking!</div>
                </div>

                <!-- Text and Button on the right -->
                <div class="front-page-text">
                    <h2> 😎 Let’s Keep Looking!</h2>
                    <p>
                        If you landed here looking for a home for sale in Central Florida, it may be under contract or already sold.</p>
                    <p>Articles and pages on our site are occasionally retired as they become outdated.
                    </p>

                    <h2>😊 We’re Happy to Help</h2>
                    <p>Whether you're planning to sell your current home or looking to buy a new one, we offer a free, no-obligation consultation to learn what your goals are and, together, come up with a plan that works best for you and your family.
                    </p>

                    <p>📞 Call or text us at <a href="tel:407-564-2758">407-564-2758</a>, or visit our
                        <a href="/contact-us/">Contact Page</a> to get in touch.
                    </p>

                    <h2>🙏 Thank You!</h2>
                    <p>
                        When you're ready, we look forward to hearing from you, and appreciate the opportunity to earn your business!
                    </p>

                    <!-- START COMMENT OUT SECTION FOR 404.php
                        <!- - IDXCentral / Optima Express Search Results - ->
                        <div class="sitewide-page-spacer"></div>

                        <div class="ihomefinder_market_report_wrap">
                            <?php
                            /** COMMENT OUT PHP
                             * echo do_shortcode('[optima_express_search_results propertyType="SFR" sortBy="ds" resultsPerPage="48" header="true" includeMap="false" status="active"]'); 
                             * 
                             */
                            ?>
                        </div>
                    ** END COMMENT OUT SECTION FOR 404.php -->
                </div>
            </div>
        </div>
    <?php
});

// Note: Call genesis() after registering hooks below so they run.

/* Match page hero/header: output pb_title-style hero for 404 */
add_action('genesis_after_header', function () {
    // Try to pull a featured image from a designated Page so this
    // behaves like an editor page. Prefer the specified uploads image.
    $image_url = get_stylesheet_directory_uri() . '/images/Daytona-Beach-Florida-Umbrella-and-Chairs-1600x901.jpeg';

    // Attempt to find a Page commonly used for the 404 content
    // e.g., /that-home-or-page-was-not-found/
    $page = get_page_by_path('that-home-or-page-was-not-found');
    if ($page && has_post_thumbnail($page->ID)) {
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID), 'pb-image');
        if (!empty($src[0])) {
            $image_url = $src[0];
        }
    }

    // Fallback to a default interior header image in the theme
    if (empty($image_url)) {
        $fallbacks = [
            get_stylesheet_directory_uri() . '/images/Palm-Trees-in-Central-Florida.jpg.webp',
            get_stylesheet_directory_uri() . '/images/Palm-Trees-in-Central-Florida.jpg',
        ];
        foreach ($fallbacks as $fallback) {
            $image_url = $fallback;
            break;
        }
    }

    if (!empty($image_url)) {
        echo '<section class="pb_title" id="pb_title" role="complementary" style="background-image: url(\'' . esc_url($image_url) . '\')">';
        echo '<div class="wrap">';
        // Intentionally no H1 here; 404 H1 is rendered in breadcrumbs bar via [breadcrumbs_h1].
        echo '</div>';
        echo '</section>';
    }
}, 5);

// Add body class so hero spacing/styles match page templates
add_filter('body_class', function ($classes) {
    if (is_404()) {
        // Match page templates that have hero images
        $classes[] = 'pb_image_active';
        $classes[] = 'sh_image';
    }
    return $classes;
});

// Ensure header is transparent over hero on 404 (match editor pages)
add_action('wp_head', function () {
    if (is_404()) {
        echo '<style id="404-page-hero-fix">.pb_image_active.sh_image .site-header > .wrap{background:transparent;} </style>';
    }
});

// Remove legacy 404 hero added on genesis_before_content_sidebar_wrap priority 1
add_action('after_setup_theme', function () {
    remove_all_actions('genesis_before_content_sidebar_wrap', 1);
});

/* Legacy 404 hero removed in favor of pb_title */

// Render the page
genesis();
