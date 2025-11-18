<?php
// TODO 2025-09-29 tjs: Remove once single.php styling matches page.php again.

/**
 * Video appearance
 * White background. Should be transparent
 * Make single.php the default for posts once it looks right.
 */

add_filter('single_template', function ($template) {
    if (is_singular('post')) {
        $page_template = get_stylesheet_directory() . '/page.php';
        if (file_exists($page_template)) {
            return $page_template;
        }
    }

    return $template;
}, 99999);

add_filter('template_include', function ($template) {
    if (is_singular('post')) {
        $page_template = get_stylesheet_directory() . '/page.php';
        if (file_exists($page_template)) {
            $template = $page_template;
        }
    }

    return $template;
}, PHP_INT_MAX - 1);
