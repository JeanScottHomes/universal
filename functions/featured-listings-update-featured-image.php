<?php

/**
 * Updates featured images for copied posts by matching originals
 * (category: featured-listings-original) to idxc_featlist posts.
 * Includes debugging output.
 */
function update_featured_images_for_copied_posts()
{
    $args = [
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category_name' => 'featured-listings-original',
    ];

    $specific_post_id = 46525; // Replace with your desired post ID

    if ($specific_post_id) {
        $args['p'] = $specific_post_id;
    }

    $old_posts = get_posts($args);

    foreach ($old_posts as $old_post) {
        $normalized_old_title = trim(str_replace(
            ["-", "–", "—", "&#8211;", "&#8212;"],
            "-",
            $old_post->post_title
        ));

        $query = new WP_Query([
            'post_type'      => 'idxc_featlist',
            'posts_per_page' => 1,
            's'              => $normalized_old_title,
        ]);

        if ($query->have_posts()) {
            $query->the_post();
            $new_post_id = get_the_ID();

            $original_thumbnail_id = get_post_thumbnail_id($old_post->ID); // Original post featured image ID
            $new_post_thumbnail_id = get_post_thumbnail_id($new_post_id); // New post featured image ID

            echo "<p><strong>Checking Post:</strong><br>Original Post ID: {$old_post->ID} | New Post ID: $new_post_id</p>";
            echo "<p><strong>Original Featured Image ID:</strong> $original_thumbnail_id | <strong>New Featured Image ID:</strong> $new_post_thumbnail_id</p>";

            // Debugging output: Check for the post meta manually
            $check_thumb_id = get_post_thumbnail_id($old_post->ID);
            echo "<p><strong>Original Post Thumbnail Check:</strong> $check_thumb_id</p>";

            if ($new_post_thumbnail_id) {
                echo "<p style='color: green;'>✅ New post already has a featured image set (ID: $new_post_thumbnail_id).</p>";
            } else {
                echo "<p style='color: orange;'>⚠️ No featured image in the new post.</p>";
            }

            if ($new_post_thumbnail_id) {
                $existing_image_url = wp_get_attachment_url($new_post_thumbnail_id);
                echo "<p style='color: green;'>✅ Featured Image already set for '{$normalized_old_title}': <a href='$existing_image_url' target='_blank'>View Image</a></p>";
            } else {
                if ($original_thumbnail_id) {
                    set_post_thumbnail($new_post_id, $original_thumbnail_id); // 🔹 TJS 09/16/2025 – Automatically update missing featured image
                    echo "<p style='color: red;'>❗ No featured image in the new post. Image ID: $original_thumbnail_id (Featured image would be updated)</p>";
                } else {
                    echo "<p>⚠️ No featured image for '{$old_post->post_title}'</p>";
                }
            }
        } else {
            echo "<p style='color: orange;'>❌ No match found for '{$old_post->post_title}' (Normalized: '{$normalized_old_title}')</p>";
        }

        wp_reset_postdata();
    }
}

// update_featured_images_for_copied_posts();
// 🔹 TJS 09/16/2025 — Disabled auto-run. This was a one-time migration script to copy featured images from posts to idxc_featlist CPT. Left here for reference; safe to remove if no longer needed.
