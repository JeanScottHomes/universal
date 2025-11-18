<?php

/**
 * Template: Index
 * 🔹 TJS 09/16/2025 — Restores WP template fallback; safe if Genesis is missing.
 */

if (function_exists('genesis')) {
    genesis();
    return;
}

// Fallback if Genesis isn't loaded.
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        get_template_part('content', get_post_format());
    endwhile;

    the_posts_navigation();
else :
    get_template_part('content', 'none');
endif;

get_sidebar();
get_footer();
