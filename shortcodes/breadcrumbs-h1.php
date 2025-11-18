<?php

add_shortcode('breadcrumbs_h1', 'breadcrumbs_h1');

/*
 * TJS 05-03-2025
 * 🔄 Redirect posts to pages when slugs match.
 * This forces WordPress to load the page instead of the post when both exist with the same slug.
 */

/**
 * Attempt to locate a Central Florida breadcrumb target from the "Discover more about" button.
 * The button is rendered in content as an anchor with the class `breadcrumb-bar`.
 *
 * @param int $post_id Current post ID.
 * @return array|null Array with `url` and `label` when detected; null otherwise.
 */
function breadcrumbs_h1_resolve_central_florida_midcrumb($post_id)
{
    static $cache = [];

    if (isset($cache[$post_id])) {
        return $cache[$post_id];
    }

    if (!class_exists('DOMDocument')) {
        $cache[$post_id] = null;
        return null;
    }

    $raw_content = get_post_field('post_content', $post_id);
    if (empty($raw_content)) {
        $cache[$post_id] = null;
        return null;
    }

    $rendered_content = apply_filters('the_content', $raw_content);

    $libxml_previous_state = libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $rendered_content);
    libxml_clear_errors();
    libxml_use_internal_errors($libxml_previous_state);

    if (!$loaded) {
        $cache[$post_id] = null;
        return null;
    }

    $anchors = $dom->getElementsByTagName('a');
    foreach ($anchors as $anchor) {
        $class_attr = $anchor->getAttribute('class');
        if (!$class_attr || stripos($class_attr, 'breadcrumb-bar') === false) {
            continue;
        }

        $href_raw = html_entity_decode(trim($anchor->getAttribute('href')));
        if ($href_raw === '') {
            continue;
        }

        $href_base = preg_replace('/#.*$/', '', $href_raw);
        if ($href_base === '') {
            continue;
        }

        // Normalize to absolute URL on this site.
        if (strpos($href_base, 'http://') !== 0 && strpos($href_base, 'https://') !== 0) {
            $href_base = home_url('/' . ltrim($href_base, '/'));
        }

        $path = parse_url($href_base, PHP_URL_PATH);
        if (!$path || strpos($path, '/central-florida/') === false) {
            continue;
        }

        $normalized_url = home_url('/' . ltrim($path, '/'));
        $normalized_url = trailingslashit($normalized_url);

        $target_id = url_to_postid($normalized_url);
        if (!$target_id) {
            $target_page = get_page_by_path(trim($path, '/'));
            if ($target_page) {
                $target_id = (int) $target_page->ID;
            }
        }

        $label = '';
        if ($target_id) {
            $label_candidate = get_the_title($target_id);
            if (!empty($label_candidate)) {
                $label = $label_candidate;
                $normalized_url = get_permalink($target_id);
            }
        }

        if ($label === '') {
            $text_content = trim($anchor->textContent);
            if ($text_content !== '') {
                // Strip leading icon/symbols and helper text, keep the place name.
                $text_content = preg_replace('/^[\s\p{C}\p{P}\p{S}]+/u', '', $text_content);
                $text_content = preg_replace('/^Discover\s+more\s+about\s+/iu', '', $text_content);
                $label = trim($text_content);
            }
        }

        if ($label === '') {
            continue;
        }

        $cache[$post_id] = [
            'url' => $normalized_url,
            'label' => $label,
        ];

        return $cache[$post_id];
    }

    $cache[$post_id] = null;
    return null;
}

/**
 * Detect Optima Express listing detail virtual pages (homes-details URLs).
 *
 * @return bool
 */
function breadcrumbs_h1_is_idx_listing_detail()
{
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/homes-details/') !== false) {
        return true;
    }

    return false;
}

// Force Pages to resolve before Category archives on URL conflicts
add_filter('request', function ($query_vars) {
    if (!is_admin() && isset($query_vars['category_name'])) {
        $slug = $query_vars['category_name'];
        $page = get_page_by_path($slug);
        if ($page) {
            unset($query_vars['category_name']);
            $query_vars['pagename'] = $slug;
        }
    }
    return $query_vars;
});

function breadcrumbs_h1()
{
    if (is_front_page()) {
        return '';
    }

    // TODO[A]: Extend breadcrumbs scroll-anchor pattern and pseudo-URL
    //          handling to IDX/Optima Express pages once tested
    //          (see _tjs-files/checklist-and-roadmap.md).

    global $post;

    $position = 1;

    // Capture default H1 text and allow adjustments for virtual IDX pages.
    $h1_text = get_the_title();
    $is_saved_search_title = false;

    if ($h1_text && stripos($h1_text, '{savedSearchName}') !== false) {
        $is_saved_search_title = true;
        $saved_search_slug = get_query_var('savedSearchName');
        if (empty($saved_search_slug) && isset($_GET['savedSearchName'])) {
            $saved_search_slug = wp_unslash($_GET['savedSearchName']);
        }

        if (!empty($saved_search_slug)) {
            $decoded_name = rawurldecode($saved_search_slug);
            $decoded_name = str_replace(array('-', '+', '_'), ' ', $decoded_name);
            $decoded_name = preg_replace('/\s+/', ' ', $decoded_name);
            $decoded_name = trim($decoded_name);

            if ($decoded_name !== '') {
                $h1_text = str_ireplace('{savedSearchName}', $decoded_name, $h1_text);
            } else {
                $h1_text = str_ireplace('{savedSearchName}', '', $h1_text);
            }
        } else {
            $h1_text = str_ireplace('{savedSearchName}', '', $h1_text);
        }

        // Clean up any lingering double spaces or stray punctuation after replacement.
        $h1_text = preg_replace('/\s{2,}/', ' ', $h1_text);
        $h1_text = trim($h1_text);
    }

    // Wrapper that owns both the breadcrumbs and the H1
    $output  = '<section class="breadcrumbs-h1-bar" aria-label="Page header"><div class="breadcrumbs-h1-bar__inner"><div class="breadcrumbs-h1-bar__content">';

    // Breadcrumb trail with Schema.org microdata
    $output .= '<nav class="breadcrumbs-h1-bar__trail" itemscope itemtype="https://schema.org/BreadcrumbList" aria-label="Breadcrumbs">';

    // Special case: 404 page — use the same text for the crumb and the H1
    if (is_404()) {
        $h1_text = apply_filters('breadcrumbs_404_title', 'That Home or Page Was Not Found');
        // Home
        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<a itemprop="item" href="' . home_url() . '"><span itemprop="name">Home</span></a>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

        // Current
        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . esc_html($h1_text) . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';

        // Close breadcrumbs and output H1
        $output .= '</nav>';
        $output .= '<h1 class="breadcrumbs-h1-bar__title">' . esc_html($h1_text) . '</h1>';
        $output .= '</div></div></section>';
        return $output;
    }

    // Home
    $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    $output .= '<a itemprop="item" href="' . home_url() . '"><span itemprop="name">Home</span></a>';
    $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

    // Market News posts
    if (in_category('central-florida-single-family-home-sales', $post)) {
        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<a itemprop="item" href="' . home_url('/real-estate-market-news/') . '"><span itemprop="name">Real Estate Market News</span></a>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<a itemprop="item" href="' . home_url('/real-estate-market-news/central-florida-single-family-home-sales/') . '"><span itemprop="name">Central Florida Single Family Home Sales</span></a>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

        $slug = basename(get_permalink($post));
        if (preg_match('/^([a-z]+)-(\d{4})$/', $slug, $matches)) {
            $month = ucfirst($matches[1]);
            $year = $matches[2];
            $final_label = $month . ' ' . $year;
        } else {
            $final_label = get_the_title($post);
        }

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . $final_label . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';
    } elseif (breadcrumbs_h1_is_idx_listing_detail()) {
        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<a itemprop="item" href="' . esc_url(home_url('/central-florida-home-search/')) . '"><span itemprop="name">Home Search</span></a>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . esc_html($h1_text) . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';
    } elseif (is_page()) {
        $ancestors = array_reverse(get_post_ancestors($post));

        $rendered_midcrumb = false;

        if ($is_saved_search_title) {
            $midcrumb = breadcrumbs_h1_resolve_central_florida_midcrumb($post->ID);

            if (!$midcrumb) {
                $midcrumb = [
                    'url' => home_url('/central-florida/'),
                    'label' => 'Central Florida',
                ];
            }

            if (!empty($midcrumb['url']) && !empty($midcrumb['label'])) {
                $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                $output .= '<a itemprop="item" href="' . esc_url($midcrumb['url']) . '"><span itemprop="name">' . esc_html($midcrumb['label']) . '</span></a>';
                $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';
                $rendered_midcrumb = true;
            }
        }

        if (!$rendered_midcrumb) {
            if (!empty($ancestors)) {
                foreach ($ancestors as $ancestor_id) {
                    $ancestor = get_post($ancestor_id);
                    $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                    $output .= '<a itemprop="item" href="' . get_permalink($ancestor) . '"><span itemprop="name">' . get_the_title($ancestor) . '</span></a>';
                    $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';
                }
            } else {
                // Fallback for pages organized by URL structure (categories on pages) without WP parent/child
                $permalink_path = trim(parse_url(get_permalink($post), PHP_URL_PATH), '/');
                $home_path      = trim(parse_url(home_url('/'), PHP_URL_PATH), '/');
                if ($home_path !== '' && str_starts_with($permalink_path, $home_path)) {
                    $permalink_path = ltrim(substr($permalink_path, strlen($home_path)), '/');
                }
                $segments = explode('/', $permalink_path);
                array_pop($segments); // remove current page slug
                $accum = '';
                foreach ($segments as $seg) {
                    $accum = $accum === '' ? $seg : $accum . '/' . $seg;
                    $page_obj = get_page_by_path($accum);
                    $label    = null;
                    $href     = null;
                    if ($page_obj) {
                        $label = get_the_title($page_obj);
                        $href  = get_permalink($page_obj);
                    } else {
                        // If not a real parent page, still render breadcrumb from URL
                        $label = ucwords(str_replace('-', ' ', $seg));
                        $href  = home_url('/' . $accum . '/');
                    }
                    $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                    $output .= '<a itemprop="item" href="' . esc_url($href) . '"><span itemprop="name">' . esc_html($label) . '</span></a>';
                    $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';
                }
            }
        }

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . esc_html($h1_text) . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';
    } elseif (is_single()) {
        $categories = get_the_category($post->ID);
        $primary_category = null;
        $primary_depth = -1;

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $depth = count(get_ancestors($category->term_id, 'category'));
                if ($depth > $primary_depth) {
                    $primary_category = $category;
                    $primary_depth = $depth;
                }
            }
        }

        if ($primary_category) {
            $ancestor_ids = array_reverse(get_ancestors($primary_category->term_id, 'category'));
            $ancestor_ids[] = $primary_category->term_id;

            $accum = '';
            foreach ($ancestor_ids as $term_id) {
                $term = get_term($term_id, 'category');
                if (!$term || is_wp_error($term)) {
                    continue;
                }

                $accum = $accum === '' ? $term->slug : $accum . '/' . $term->slug;
                $page_obj = get_page_by_path($accum);

                if ($page_obj) {
                    $label = get_the_title($page_obj);
                    $href = get_permalink($page_obj);
                } else {
                    $label = ucwords(str_replace('-', ' ', $term->slug));
                    $href = home_url('/' . $accum . '/');
                }

                $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                $output .= '<a itemprop="item" href="' . esc_url($href) . '"><span itemprop="name">' . esc_html($label) . '</span></a>';
                $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';
            }
        }

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . get_the_title($post) . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';
    } elseif (is_singular('idxc_featlist')) {
        // 🔹 05/03/25 — Breadcrumb for IDX Featured Listing CPT TJS
        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<a itemprop="item" href="' . home_url('/featured-listings/') . '"><span itemprop="name">Featured Listings</span></a>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span> › ';

        $output .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span class="breadcrumb-current" itemprop="name">' . get_the_title($post) . '</span>';
        $output .= '<meta itemprop="position" content="' . $position++ . '" /></span>';
    }

    // Close the breadcrumb trail
    $output .= '</nav>';

    // Add the H1 title (kept here so this block fully owns styling/markup)
    $output .= '<h1 class="breadcrumbs-h1-bar__title">' . esc_html($h1_text) . '</h1>';

    // Close the wrapper
    $output .= '</div></div></section>';

    return $output;
}
