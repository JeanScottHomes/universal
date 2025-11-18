<?php

// 🔹 TJS 2025-09-21 — Text-only history (index for SEO) of every featured listing grouped by year
add_shortcode('featured_listings_history', function () {
    $cache_key = 'featured_listings_history_html';
    $cached = get_transient($cache_key);
    if (false !== $cached) {
        return $cached;
    }

    $listings = get_posts([
        'post_type'      => 'idxc_featlist',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    if (!$listings) {
        return '';
    }

    ob_start();
    echo '<div class="site-index-pages">';

    $current_year = null;
    foreach ($listings as $post_id) {
        $year = get_the_date('Y', $post_id);
        if ($year !== $current_year) {
            if ($current_year !== null) {
                echo '</ul></section>';
            }
            $current_year = $year;
            printf('<section class="site-index-pages__section"><h2 class="site-index-pages__heading">%s</h2><ul class="site-index-pages__list">', esc_html($current_year));
        }

        $title = get_the_title($post_id);
        $permalink = get_permalink($post_id);
        printf('<li class="site-index-pages__item"><a class="site-index-pages__link" href="%s">%s</a></li>', esc_url($permalink), esc_html($title));
    }

    if ($current_year !== null) {
        echo '</ul></section>';
    }

    echo '</div>';

    $output = ob_get_clean();
    set_transient($cache_key, $output, 12 * HOUR_IN_SECONDS);

    return $output;
});
