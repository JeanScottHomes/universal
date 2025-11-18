<?php

/**
 * Automatically set the author of all new posts and pages to a specific user.
 *
 * This function checks if the post type is 'post' or 'page' and assigns the post to the user with ID 3 (Jean Scott).
 *
 * @param int $post_id The ID of the post being saved.
 * @param WP_Post $post The post object.
 */
function set_default_author($post_id, $post)
{
    // Check if the post type is 'post', 'page', or any other custom post type and if the post is being newly created
    if (($post->post_type == 'post' || $post->post_type == 'page' || $post->post_type == 'idxc_featlist') && $post->post_status == 'auto-draft') {
        // Set the author to user ID 3 (Jean Scott) for all new posts and pages
        $new_author_id = 3; // Jean's new user ID
        // Remove the action to prevent infinite loop
        remove_action('wp_insert_post', 'set_default_author', 10, 2);
        // Update the post author
        wp_update_post(array(
            'ID' => $post_id,
            'post_author' => $new_author_id
        ));
        // Re-add the action
        add_action('wp_insert_post', 'set_default_author', 10, 2);
    }
}
add_action('wp_insert_post', 'set_default_author', 10, 2);
