<?php
function make_tags_hierarchical()
{
    // Unregister the existing non-hierarchical tags taxonomy
    unregister_taxonomy('post_tag');

    // Re-register tags as a hierarchical taxonomy (so checkboxes appear)
    register_taxonomy('post_tag', array('post', 'page'), array(
        'hierarchical'       => true, // Enables checkboxes
        'labels'             => array(
            'name'          => 'Tags',
            'singular_name' => 'Tag',
        ),
        'query_var'          => true,
        'rewrite'            => array('slug' => 'tag'), // Ensure proper filtering
        'show_admin_column'  => true, // Show in admin columns
        'show_ui'            => true, // Show in post editor
        'show_in_nav_menus'  => true, // Allow use in menus
    ));
}
add_action('init', 'make_tags_hierarchical', 11);

// Fix filtering issue on edit.php list
function filter_pages_by_tag($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    global $pagenow;
    if ($pagenow === 'edit.php' && isset($_GET['post_tag']) && isset($_GET['post_type']) && $_GET['post_type'] === 'page') {
        $query->set('tax_query', array(
            array(
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['post_tag']),
            ),
        ));
    }
}
add_action('pre_get_posts', 'filter_pages_by_tag');
