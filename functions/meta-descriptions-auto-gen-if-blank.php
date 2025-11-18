<?php
function auto_generate_meta_description() {
    if (is_single() || is_page()) {
        global $post;

        // Check if a meta description exists (e.g., from an SEO plugin)
        $meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true); // Example for Yoast SEO

        if (empty($meta_description)) {
            $content = strip_shortcodes($post->post_content); // Remove shortcodes
            $content = wp_strip_all_tags($content); // Remove HTML tags
            $content = preg_replace('/\s+/', ' ', $content); // Normalize whitespace

            // Remove <h1> and <h2> by stripping them out
            $content = preg_replace('/<h[12][^>]*>.*?<\/h[12]>/', '', $content);

            // Extract the first complete sentence
            preg_match('/(.*?\.)/', $content, $matches);
            if (!empty($matches[1])) {
                $meta_description = trim($matches[1]);
            }
            if (!empty($meta_description)) {
                echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
            }
        }
    }
}
add_action('wp_head', 'auto_generate_meta_description', 5);
