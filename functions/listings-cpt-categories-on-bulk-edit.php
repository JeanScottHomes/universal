<?php
function tjs_enable_bulk_edit_for_listing_category()
{
    global $wp_taxonomies;

    if (isset($wp_taxonomies['listing_category'])) {
        $wp_taxonomies['listing_category']->hierarchical = true; // ✅ enables checkbox UI
        $wp_taxonomies['listing_category']->show_in_quick_edit = true;
        $wp_taxonomies['listing_category']->show_ui = true;
        $wp_taxonomies['listing_category']->meta_box_cb = 'post_categories_meta_box';
    }
}
add_action('init', 'tjs_enable_bulk_edit_for_listing_category', 100);
