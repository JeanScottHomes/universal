<?php

/**
 * 09/15/25 Moved to universal/shortcodes/front-page-header-logos.php
 */

function header_logo_shortcode()
{
    ob_start();
?>
    <style>
        /* === Flex container for logo layout === */
        .front-page-logo-bar {
            display: flex;
            flex-wrap: nowrap;
            align-items: flex-end;
            justify-content: center;
            gap: 2rem;
            padding: 0.5rem 1rem;
        }

        .front-page-logo-bar img {
            display: block;
            height: auto;
            width: 100%;
            max-width: 400px;
            margin-top: 4px;
        }
    </style>

    <div class="front-page-logo-bar">
       <a href="<?php echo home_url('/'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/JSH-KWA-Combined-Logo.png"
                alt="Jean Scott Homes, REALTORS at Keller Williams Advantage Realty"
                width="400" height="60">
        </a>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('header_logo', 'header_logo_shortcode');
