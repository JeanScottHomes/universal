<?php

/**
 * 🔹 TJS 08/23/25 – Sitewide grid infinite scroll: AJAX endpoint
 */

/*
add_action('wp_ajax_nopriv_sitewide_grid_load_more', 'sitewide_grid_load_more');
add_action('wp_ajax_sitewide_grid_load_more', 'sitewide_grid_load_more');
*/

function sitewide_grid_load_more()
{
    if (!defined('DOING_AJAX') || !DOING_AJAX) {
        wp_die();
    }

    // Inputs (defaults match [sitewide_grid post_types="idxc_featlist"])
    $count = isset($_POST['count']) ? max(1, intval($_POST['count'])) : 12;
    $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 2;
    $sort = isset($_POST['sort']) ? strtolower(sanitize_text_field($_POST['sort'])) : 'date';
    $offset0 = isset($_POST['offset']) ? max(0, intval($_POST['offset'])) : 0;
    $post_types = isset($_POST['post_types']) ? array_filter(array_map('trim', explode(',', sanitize_text_field($_POST['post_types'])))) : array('idxc_featlist');
    $post_tags = isset($_POST['post_tags']) ? array_filter(array_map('trim', explode(',', sanitize_text_field($_POST['post_tags'])))) : array();
    $post_cats = isset($_POST['post_cats']) ? array_filter(array_map('trim', explode(',', sanitize_text_field($_POST['post_cats'])))) : array();

    $offset = $offset0 + (($page - 1) * $count);

    // Sort
    $orderby = 'date';
    $order = 'DESC';
    $meta_key = '';
    $meta_query = array();
    switch ($sort) {
        case 'views':
            $orderby = 'meta_value_num';
            $meta_key = 'post_views_count';
            $meta_query[] = ['key' => 'post_views_count', 'compare' => 'EXISTS'];
            break;
        case 'abc':
            $orderby = 'title';
            $order = 'ASC';
            break;
        case 'date-asc':
            $orderby = 'date';
            $order = 'ASC';
            break;
        case 'rand':
            $orderby = 'rand';
            break;
    }

    $args = [
        'post_type' => $post_types,
        'posts_per_page' => $count,
        'offset' => $offset,
        'orderby' => $orderby,
        'order' => $order,
        'no_found_rows' => true,
    ];
    if ($meta_key) $args['meta_key'] = $meta_key;
    if ($meta_query) $args['meta_query'] = $meta_query;

    // Tax query
    $tax_query = [];
    if (!empty($post_cats)) {
        foreach ($post_types as $pt) {
            foreach (get_object_taxonomies($pt, 'objects') as $tax) {
                if (!empty($tax->hierarchical)) {
                    $tax_query[] = ['taxonomy' => $tax->name, 'field' => 'slug', 'terms' => $post_cats];
                }
            }
        }
    }
    if (!empty($post_tags)) {
        $tax_query[] = ['taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => $post_tags];
    }
    if ($tax_query) $args['tax_query'] = $tax_query;

    $q = new WP_Query($args);

    ob_start();
    echo '<div class="sitewide-grid">';
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            echo '<div class="sitewide-grid__item">';
            echo '<a href="' . esc_url(get_permalink()) . '">';
            echo '<div class="signature-image-container">';
            echo get_the_post_thumbnail(get_the_ID(), 'medium', [
                'loading' => 'lazy',
                'class' => 'signature-image',
                'alt' => esc_attr(get_the_title())
            ]);
            echo '</div></a>';

            echo '<a href="' . esc_url(get_permalink()) . '">';
            echo '<div class="sitewide-grid__text">';
            // Title formatting to match shortcode
            $title = get_the_title();
            if (get_post_type() === 'idxc_featlist') {
                $decoded = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $decoded = preg_replace('/, /', '<br>', $decoded, 1);
                $decoded = preg_replace('/\s*[–—-]\s*/u', '<br>', $decoded);
                $title = $decoded;
            }
            echo '<h3 class="sitewide-grid__title">' . $title . '</h3>';

            // Excerpt + views to match shortcode output
            echo '<div class="sitewide-grid__excerpt">';
            echo '<p>' . esc_html(wp_trim_words(get_the_excerpt(), 100, '...')) . '</p>';
            // TODO(Vision): Restore Cloudflare-synced view counts when available.
            // $views = intval(get_post_meta(get_the_ID(), 'post_views_count', true));
            // echo '<p class="sitewide-grid__views">Views: ' . $views . '</p>';
            echo '</div>'; // .sitewide-grid__excerpt

            // Close wrappers
            echo '</div>'; // .sitewide-grid__text
            echo '</a>';

            echo '</div>';
        }
        wp_reset_postdata();
    }
    echo '</div>';
    echo ob_get_clean();

    wp_die();
}
