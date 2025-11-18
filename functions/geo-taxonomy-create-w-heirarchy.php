<?php
function create_geo_taxonomy()
{
    $labels = array(
        'name'              => __('Geo Taxonomy', 'textdomain'),
        'singular_name'     => __('Geo Taxonomy', 'textdomain'),
        'menu_name'         => __('Geo Taxonomy', 'textdomain'),
        'all_items'         => __('All Geo Taxonomies', 'textdomain'),
        'edit_item'         => __('Edit Geo Taxonomy', 'textdomain'),
        'view_item'         => __('View Geo Taxonomy', 'textdomain'),
        'update_item'       => __('Update Geo Taxonomy', 'textdomain'),
        'add_new_item'      => __('Add New Geo Taxonomy', 'textdomain'),
        'new_item_name'     => __('New Geo Taxonomy Name', 'textdomain'),
        'parent_item'       => __('Parent Geo Taxonomy', 'textdomain'),
        'parent_item_colon' => __('Parent Geo Taxonomy:', 'textdomain'),
        'search_items'      => __('Search Geo Taxonomy', 'textdomain'),
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'hierarchical'      => true, // Enables parent-child relationships
        'show_ui'           => true,
        'show_admin_column' => true, // Shows the column in the post/page list
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => 'geo',
            'with_front'   => false,
            'hierarchical' => true,
        ),
        'show_in_rest'      => true, // Enables REST API support (Gutenberg, AJAX, etc.)
    );

    // Register Geo Taxonomy for posts, pages, and your custom post type 'idxc_featlist'.
    // Existing terms live under the `geo_taxonomy` slug, so register with that
    // internal name while exposing the human-friendly rewrite slug `/geo/...`.
    register_taxonomy('geo_taxonomy', array('post', 'page', 'idxc_featlist'), $args);
}
add_action('init', 'create_geo_taxonomy');
