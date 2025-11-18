<?php
// 🔹 TJS 5/10/25 – Real-time sync: copy Post Views Counter into post meta for WP_Query sorting

// TODO(Vision): Replace with Cloudflare nightly sync once the new counter ships.
// We removed Post Views Counter because it stalled PHP workers; leave sorting meta
// in place for now but stop trying to sync counts on each page view.
// add_action('template_redirect', function () {
//     if (! is_singular(['post', 'page'])) return;
//     if (! function_exists('pvc_get_post_views')) return;
//
//     $post_id = get_the_ID();
//     $views   = pvc_get_post_views($post_id);
//
//     if ($views !== false) {
//         update_post_meta($post_id, 'post_views_number', intval($views));
//     }
// });
