<?php
/*
*
* Miscellaneous functions
*
*/

// Add Search form above blog posts on official Blog page
add_action( 'genesis_before_loop', 'add_search_widget_on_blog_page' );
function add_search_widget_on_blog_page() {
    if ( is_home() ) {
		echo '<div class="iul_search_posts1">
    <form role="search" method="get" class="isc_search_form" action="' . esc_url( home_url( '/' ) ) . '">
        <label for="search_input_field" class="screen-reader-text visuallyhidden">
            <span class="isc_search_label">' . _x( 'Search Posts:', 'label' ) . '</span>
        </label>
        <div class="isc_search_fields">
            <input id="search_input_field" type="search" class="isc_search_input" placeholder="' . esc_attr_x( 'Search Posts', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
            <input type="submit" class="isc_search_submit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
        </div>
        <input type="hidden" name="post_type" value="post" />
    </form>
</div>';
    }
}

// Shortcode which will output the full <img> tag with lazy load attribute, alt text and appropriate size from just the ID of the image.<br>
// If the requested size does not exist, it will pull the full size image
// Use: [custom_img id="123" size="medium" class="my-custom-class" alt_text="Custom alt text to override default"]
// Updated: 2024-02-08 9:32 PST
function custom_img_shortcode($atts) {
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'id' => '', // Image ID
            'size' => 'full', // Default to 'full' size
            'class' => '', // Optional class name
            'alt_text' => '', // Optional custom alt text
        ),
        $atts,
        'custom_img'
    );

    // Get image URL
    $image_info = wp_get_attachment_image_src($atts['id'], $atts['size']);

    // Fallback to full size if specified size doesn't exist
    if (!$image_info) {
        $image_info = wp_get_attachment_image_src($atts['id'], 'full');
    }

    if ($image_info) {
        $image_url = $image_info[0];
        // Use custom alt text if provided, otherwise get the default alt text
        $alt_text = !empty($atts['alt_text']) ? $atts['alt_text'] : get_post_meta($atts['id'], '_wp_attachment_image_alt', true);
        $class_attr = $atts['class'] ? ' class="' . esc_attr($atts['class']) . '"' : '';

        $img_tag = '<img src="' . esc_url($image_url) . '"' . $class_attr . ' alt="' . esc_attr($alt_text) . '" loading="lazy">';

        return $img_tag;
    }

    // Return empty if no image is found
    return '';
}

add_shortcode('custom_img', 'custom_img_shortcode');



// Get Large and Medium Image URL for display for the client
// Adds a new field labeled "Large Size URL" and "Medium Size URL" in the Media Library.
// Updated: 2024-03-04 2:13 PST
add_filter('attachment_fields_to_edit', 'custom_image_sizes_urls_field', 10, 2);

function custom_image_sizes_urls_field($form_fields, $post) {
    // Get URLs for both 'large' and 'medium' size images
    $large_image_data = wp_get_attachment_image_src($post->ID, 'large');
    $medium_image_data = wp_get_attachment_image_src($post->ID, 'medium');
    
    // Large size URL
    if ($large_image_data) {
        $form_fields['custom_large_image_url'] = array(
            'label' => 'Large Size URL',
            'input' => 'html',
            'html' => "<input type='text' class='widefat' readonly='readonly' value='{$large_image_data[0]}'/>",
            'value' => $large_image_data[0],
            'helps' => 'Copy this URL to use the large size image.',
        );
    }
    
    // Medium size URL
    if ($medium_image_data) {
        $form_fields['custom_medium_image_url'] = array(
            'label' => 'Medium Size URL',
            'input' => 'html',
            'html' => "<input type='text' class='widefat' readonly='readonly' value='{$medium_image_data[0]}'/>",
            'value' => $medium_image_data[0],
            'helps' => 'Copy this URL to use the medium size image.',
        );
    }

    return $form_fields;
}


// Add Modal for Contact Information to every page
add_action('genesis_before_footer', 'add_contact_modal');
function add_contact_modal() {
    $image = cmb2_get_option('md_main_options', 'contact_modal_image');
    
    // Check if $image exists and is not empty
    $styleAttribute = $image ? "background-image: url($image);background-size: cover;" : "background-color:#111;";

    $shortcodeOutput = do_shortcode('[contact1_modal]');
    $customHtml = <<<HTML
<div class="md_modal isc_modal_contact1" id="modal_contact1" aria-hidden="true" aria-label="Contact Information" tabindex="-1" role="dialog" style="$styleAttribute">
    <div class="isc_modal_content">
        <button class="md_modal_close" data-modal-close="modal_contact1" aria-label="Close Modal">X</button>
        <div class="md_modal_dialog">
            <div class="md_modal_body">
                <div class="iul_form_transparent">$shortcodeOutput</div>
                <a href="#" class="visuallyhidden" aria-hidden="true">End of Modal</a>
            </div>
        </div>
    </div>
</div>
HTML;

    echo $customHtml;
}

