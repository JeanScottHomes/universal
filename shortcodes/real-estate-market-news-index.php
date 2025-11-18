<?php

// 🔹 TJS 2025-09-22 — Builds a year-by-year index of Real Estate Market News posts grouped by category
add_shortcode('real_estate_market_news_index', function () {
    $cache_key = 'real_estate_market_news_index_html';
    $cached = get_transient($cache_key);
    if (false !== $cached) {
        return $cached;
    }

    $root = get_category_by_slug('real-estate-market-news');
    if (!$root) {
        return '';
    }

    $terms = get_terms([
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'child_of'   => $root->term_id,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    // Prepend the root category so we show parent posts first.
    array_unshift($terms, $root);

    $markup = '';

    foreach ($terms as $term) {
        if (!$term instanceof WP_Term) {
            continue;
        }

        $posts = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => [
                [
                    'taxonomy'         => 'category',
                    'field'            => 'term_id',
                    'terms'            => $term->term_id,
                    'include_children' => false,
                ],
            ],
            'no_found_rows'  => true,
        ]);

        if (!$posts) {
            continue;
        }

        $section_markup = '<section class="site-index-pages__section">';
        $section_markup .= sprintf('<h2 class="site-index-pages__heading">%s</h2>', esc_html($term->name));

        $current_year = null;

        foreach ($posts as $post) {
            $title = get_the_title($post);
            $permalink = get_permalink($post);

            $year = null;
            if (preg_match('/\b(20\d{2}|19\d{2})\b/', $title, $match)) {
                $year = $match[1];
            }

            if (!$year) {
                $year = get_the_date('Y', $post);
            }

            if ($year !== $current_year) {
                if (null !== $current_year) {
                    $section_markup .= '</ul>';
                }
                $current_year = $year;
                $section_markup .= sprintf('<h3 class="site-index-pages__subheading">%s</h3><ul class="site-index-pages__list site-index-pages__list--nested">', esc_html($current_year));
            }

            $section_markup .= sprintf('<li class="site-index-pages__item"><a class="site-index-pages__link" href="%s">%s</a></li>', esc_url($permalink), esc_html($title));
        }

        if (null !== $current_year) {
            $section_markup .= '</ul>';
        }

        $section_markup .= '</section>';
        $markup .= $section_markup;
    }

    if ($markup === '') {
        return '';
    }

    $output = '<div class="site-index-pages">' . $markup . '</div>';
    set_transient($cache_key, $output, 12 * HOUR_IN_SECONDS);

    return $output;
});
