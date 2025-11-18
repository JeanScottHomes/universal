<?php
// 🔹 TJS 05/19/25 – Add sortable "Last Updated" column with US date format
add_filter('manage_pages_columns', function ($columns) {
    $columns['last_updated'] = 'Last Updated';
    return $columns;
});

add_action('manage_pages_custom_column', function ($column_name, $post_id) {
    if ($column_name === 'last_updated') {
        echo get_the_modified_date('Y/m/d', $post_id);
    }
}, 10, 2);

add_filter('manage_edit-page_sortable_columns', function ($columns) {
    $columns['last_updated'] = 'modified';
    return $columns;
});
