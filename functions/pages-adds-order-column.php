<?php
// Add custom column for 'Order' in the Pages list
add_filter('manage_pages_columns', function ($columns) {
    $columns['menu_order'] = 'Order';
    return $columns;
});

// Display the 'Order' column value
add_action('manage_pages_custom_column', function ($column_name, $post_id) {
    if ($column_name === 'menu_order') {
        echo get_post_field('menu_order', $post_id);
    }
}, 10, 2);

// Make the 'Order' column sortable
add_filter('manage_edit-page_sortable_columns', function ($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
});
