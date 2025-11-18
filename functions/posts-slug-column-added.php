<?php
// Add a new column to the posts/pages list
function add_slug_column($columns)
{
    $columns['slug'] = 'Slug';
    return $columns;
}
add_filter('manage_posts_columns', 'add_slug_column');
add_filter('manage_pages_columns', 'add_slug_column');

// Populate the slug column with data
function show_slug_column_content($column_name, $post_id)
{
    if ($column_name === 'slug') {
        $post = get_post($post_id);
        echo esc_html($post->post_name);
    }
}
add_action('manage_posts_custom_column', 'show_slug_column_content', 10, 2);
add_action('manage_pages_custom_column', 'show_slug_column_content', 10, 2);

// Make the column sortable (optional)
function make_slug_column_sortable($columns)
{
    $columns['slug'] = 'slug';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'make_slug_column_sortable');
add_filter('manage_edit-page_sortable_columns', 'make_slug_column_sortable');
