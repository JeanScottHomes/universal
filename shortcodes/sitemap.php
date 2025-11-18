<?php

// 🔹 TJS 2025-08-24 — HTML sitemap for all content
add_shortcode('html_sitemap', function () {
    $sections = [];

    $page_items = wp_list_pages([
        'title_li' => '',
        'echo'     => 0,
    ]);

    if ($page_items) {
        $sections[] = '<section class="site-index-pages__section"><h2 class="site-index-pages__heading">Pages</h2><ul class="site-index-pages__list">' . $page_items . '</ul></section>';
    }

    $posts = get_posts([
        'numberposts' => -1,
        'post_type'   => 'post',
        'post_status' => 'publish',
    ]);

    if ($posts) {
        $post_list = '';
        foreach ($posts as $p) {
            $post_list .= sprintf('<li class="site-index-pages__item"><a class="site-index-pages__link" href="%s">%s</a></li>', esc_url(get_permalink($p)), esc_html(get_the_title($p)));
        }
        $sections[] = '<section class="site-index-pages__section"><h2 class="site-index-pages__heading">Blog Posts</h2><ul class="site-index-pages__list">' . $post_list . '</ul></section>';
    }

    $listings = get_posts([
        'numberposts' => -1,
        'post_type'   => 'idxc_featlist',
        'post_status' => 'publish',
    ]);

    if ($listings) {
        $listing_list = '';
        foreach ($listings as $l) {
            $listing_list .= sprintf('<li class="site-index-pages__item"><a class="site-index-pages__link" href="%s">%s</a></li>', esc_url(get_permalink($l)), esc_html(get_the_title($l)));
        }
        $sections[] = '<section class="site-index-pages__section"><h2 class="site-index-pages__heading">Featured Listings</h2><ul class="site-index-pages__list">' . $listing_list . '</ul></section>';
    }

    if (!$sections) {
        return '';
    }

    return '<div class="site-index-pages">' . implode('', $sections) . '</div>';
});
