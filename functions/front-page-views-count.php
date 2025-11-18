<?php
/**
 * Legacy helper for Post Views Counter. The include is disabled while we migrate view
 * tracking to Cloudflare (see universal/functions.php TODO).
 *
 * TODO(Vision): Remove once Cloudflare-synced view counts are live.
 */
add_action('template_redirect', function () {
    if (! is_front_page()) {
        return;
    }

    $front_id = (int) get_option('page_on_front');
    if (! $front_id) {
        return;
    }

    $front = get_post($front_id);
    if (! $front) {
        return;
    }

    global $post;
    $post = $front;
    setup_postdata($post);

    // Reset global state after the page renders so other templates are unaffected.
    add_action('wp_footer', function () {
        wp_reset_postdata();
    }, 0);
});
