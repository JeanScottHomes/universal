<?php

// 🔹 TJS 2025-09-22 — Resources index grouped by section pages
add_shortcode('resources_index', function () {
    $cache_key = 'resources_index_html';
    $cached = get_transient($cache_key);
    if (false !== $cached) {
        return $cached;
    }

    $root = get_page_by_path('resources');
    if (!$root instanceof WP_Post) {
        return '';
    }

    $top_level = get_pages([
        'post_type'   => 'page',
        'parent'      => $root->ID,
        'sort_column' => 'menu_order,post_title',
        'sort_order'  => 'ASC',
    ]);

    if (!$top_level) {
        return '';
    }

    ob_start();

    echo '<div class="site-index-pages">';

    foreach ($top_level as $section) {
        echo '<section class="site-index-pages__section">';
        printf('<h2 class="site-index-pages__heading"><a href="%s">%s</a></h2>', esc_url(get_permalink($section)), esc_html(get_the_title($section)));

        $children = get_pages([
            'post_type'   => 'page',
            'parent'      => $section->ID,
            'sort_column' => 'post_title',
            'sort_order'  => 'ASC',
        ]);

        if (!$children) {
            echo '</section>';
            continue;
        }

        echo '<ul class="site-index-pages__list">';
        foreach ($children as $child) {
            printf('<li class="site-index-pages__item"><a class="site-index-pages__link" href="%s">%s</a></li>', esc_url(get_permalink($child)), esc_html(get_the_title($child)));
        }
        echo '</ul>';
        echo '</section>';
    }

    echo '</div>';

    $output = ob_get_clean();
    set_transient($cache_key, $output, 12 * HOUR_IN_SECONDS);

    return $output;
});
