<?php

/**
 * 🔹 Shortcode: [sitewide_grid]
 */

/**
 * Helper: Format views with commas, k, or M
 */
function sitewide_grid_format_views($views)
{
    if ($views >= 1000000) {
        return number_format($views / 1000000, 1) . 'M';
    } elseif ($views >= 10000) {
        return number_format($views / 1000, 1) . 'k';
    } else {
        return number_format($views);
    }
}

function sitewide_grid_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'number'       => -1,
        'offset'       => 0,
        'sort'         => 'date',
        'post_types'   => '',
        'post_tags'    => '',
        'category'     => '',
        'debug'        => 'no',
        'excerpt'      => 'yes',
        'views'        => 'yes',
        'scroll'       => 'no',
        'paged'        => 'yes',
        'show_all'     => 'yes',
        'show_pagination' => 'yes'
    ), $atts);

    $number      = intval($atts['number']);
    $offset      = intval($atts['offset']);
    $sort        = strtolower(trim($atts['sort']));
    $debug       = (isset($_GET['debug']) && $_GET['debug'] === 'yes') ? 'yes' : $atts['debug'];
    $show_excerpt = ($atts['excerpt'] === 'yes');
    $show_views   = ($atts['views'] === 'yes');
    $show_all     = ($atts['show_all'] === 'yes');
    $show_pagination = ($atts['show_pagination'] === 'yes');

    $post_types = array_filter(array_map('trim', explode(',', $atts['post_types'])));
    $post_tags  = array_filter(array_map('trim', explode(',', $atts['post_tags'])));
    $category   = array_filter(array_map('trim', explode(',', $atts['category'])));

    $paged = max(1, (get_query_var('paged') ?: get_query_var('page')));

    if (empty($post_types)) {
        $post_types = array_values(get_post_types(['public' => true], 'names'));
    }

    if (!empty($post_tags)) {
        $post_types = array_filter($post_types, function ($post_type) {
            return is_object_in_taxonomy($post_type, 'post_tag');
        });
        $post_types = array_values($post_types);
    }

    $orderby    = 'date';
    $order      = 'DESC';
    $meta_key   = '';
    $meta_query = [];

    switch ($sort) {
        case 'views':
            $orderby    = 'meta_value_num';
            $meta_key   = 'post_views_number';
            $meta_query[] = array(
                'key'     => 'post_views_number',
                'compare' => 'EXISTS',
            );
            break;
        case 'abc':
            $orderby = 'title';
            $order   = 'ASC';
            break;
        case 'date-asc':
            $orderby = 'date';
            $order   = 'ASC';
            break;
        case 'rand':
            $orderby = 'rand';
            break;
        default:
            $orderby = 'date';
            $order   = 'DESC';
    }

    $posts_per_page = intval($number);
    $derived_offset = intval($offset) + ($paged - 1) * max(1, $posts_per_page);

    $args = array(
        'post_type'      => $post_types,
        'posts_per_page' => $posts_per_page,
        'offset'         => $derived_offset,
        'orderby'        => $orderby,
        'order'          => $order,
    );

    if ($meta_key) {
        $args['meta_key'] = $meta_key;
    }
    if ($meta_query) {
        $args['meta_query'] = $meta_query;
    }

    $tax_query = [];

    if (!empty($category)) {
        foreach ($post_types as $post_type) {
            $taxonomies = get_object_taxonomies($post_type, 'objects');
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->hierarchical) {
                    $matching_terms = get_terms([
                        'taxonomy'   => $taxonomy->name,
                        'slug'       => $category,
                        'hide_empty' => false
                    ]);
                    if (!is_wp_error($matching_terms) && !empty($matching_terms)) {
                        $tax_query[] = [
                            'taxonomy'         => $taxonomy->name,
                            'field'            => 'slug',
                            'terms'            => $category,
                            'include_children' => false,
                        ];
                    }
                }
            }
        }
    }

    if (!empty($post_tags)) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => $post_tags,
        ];
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    if ($debug === "yes") {
        echo "<b>Debug mode is active!</b><br/>";
        echo 'Post Types: ' . implode(', ', $post_types) . '<br />';
        echo 'Post Cats: ' . implode(', ', $category) . '<br />';
        echo 'Post Tags: ' . implode(', ', $post_tags) . '<br />';
        echo 'Number: ' . $number . '<br />';
        echo 'Offset: ' . $offset . '<br />';
        echo 'Sort: ' . $sort . '<br />';
        echo 'Orderby: ' . $orderby . '<br />';
        echo 'Order: ' . $order . '<br />';
        if ($meta_key) echo 'Meta Key: ' . $meta_key . '<br />';
        echo 'Paged: ' . $paged . '<br />';
        echo 'Derived Offset: ' . $derived_offset . '<br />';
    }

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        $output .= '<div class="sitewide-grid">';

        while ($query->have_posts()) {
            $query->the_post();

            $output .= '<div class="sitewide-grid__item">';
            $output .= '<a href="' . get_permalink() . '">';
            $output .= '<div class="signature-image-container">';
            $output .= get_the_post_thumbnail(get_the_ID(), 'medium', [
                'loading' => 'lazy',
                'class'   => 'signature-image',
                'alt'     => esc_attr(get_the_title())
            ]);
            $output .= '</div>';
            $output .= '</a>';

            $output .= '<a href="' . get_permalink() . '">';
            $output .= '<div class="sitewide-grid__text">';
            $output .= '<h3 class="sitewide-grid__title">' . get_the_title() . '</h3>';

            if ($show_excerpt || $show_views) {
                $output .= '<div class="sitewide-grid__excerpt">';

                if ($show_excerpt) {
                    $output .= '<p>' . esc_html(wp_trim_words(get_the_excerpt(), 100, '...')) . '</p>';
                }

                if ($show_views) {
                    // TODO(Vision): Re-enable view display after Cloudflare nightly sync writes
                    // updated counts back into WordPress. Legacy values remain for sorting.
                    // $views = intval(get_post_meta(get_the_ID(), 'post_views_number', true));
                    // $output .= '<p class="sitewide-grid__views">';
                    // $output .= 'Views: ' . sitewide_grid_format_views($views);
                    // $output .= '</p>';
                }

                $output .= '</div>';
            }

            $output .= '</div>'; // .sitewide-grid__text
            $output .= '</div>'; // .sitewide-grid__item
            $output .= '</a>';
        }

        $output .= '</div>';

        if ($show_pagination) {
            $total_posts = max(0, intval($query->found_posts) - intval($offset));
            $total_pages = ($posts_per_page > 0) ? (int) ceil($total_posts / $posts_per_page) : 1;

            if ($total_pages > 1) {
                $output .= '<div class="sitewide-grid__pagination">';
                $big = 999999999;
                $base = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));
                $format = get_option('permalink_structure') ? 'page/%#%/' : '?paged=%#%';
                $output .= paginate_links(array(
                    'base'      => $base,
                    'format'    => $format,
                    'current'   => $paged,
                    'total'     => $total_pages,
                    'show_all'  => $show_all,
                    'prev_text' => __('« Prev'),
                    'next_text' => __('Next »'),
                ));
                $output .= '</div>';
            }
        }

        wp_reset_postdata();
        return $output;
    } else {
        return '<h3>No Pages Found.</h3>';
    }
}

add_shortcode('sitewide_grid', 'sitewide_grid_shortcode');
