<?php

/**
 * 🔹 TJS 5/7/25
 * Rename admin labels for the 'listing_category' taxonomy used with IDX featured listings.
 *
 * ✅ What it does:
 * - Overrides the default label text in the WordPress admin for the 'listing_category' taxonomy.
 * - Changes things "Categories" to "Listings Categories" in menu items, headings, and buttons to avoid confusion.
 *
 * ❌ What it does NOT do:
 * - It does NOT rename the actual taxonomy slug ('listing_category') or affect URLs.
 * - It does NOT impact templates, permalinks, queries, or how listings behave publicly.
 * - It is NOT a one-time change — this must run on every page load to take effect.
 */

function tjs_rename_listings_category_labels()
{
    global $wp_taxonomies;

    if (isset($wp_taxonomies['listing_category'])) {
        $wp_taxonomies['listing_category']->labels->name = 'Listings Categories';
        $wp_taxonomies['listing_category']->labels->singular_name = 'Listings Category';
        $wp_taxonomies['listing_category']->labels->menu_name = 'Listings Categories';
        $wp_taxonomies['listing_category']->labels->all_items = 'All Listings Categories';
        $wp_taxonomies['listing_category']->labels->edit_item = 'Edit Listings Category';
        $wp_taxonomies['listing_category']->labels->view_item = 'View Listings Category';
        $wp_taxonomies['listing_category']->labels->update_item = 'Update Listings Category';
        $wp_taxonomies['listing_category']->labels->add_new_item = 'Add New Listings Category';
        $wp_taxonomies['listing_category']->labels->new_item_name = 'New Listings Category';
        $wp_taxonomies['listing_category']->labels->search_items = 'Search Listings Categories';
        $wp_taxonomies['listing_category']->labels->not_found = 'No Listings Categories found';
    }
}
add_action('init', 'tjs_rename_listings_category_labels', 100);
