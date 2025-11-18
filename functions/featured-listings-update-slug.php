<?php
function update_existing_slugs() {
$args = [
'post_type' => 'idxc_featlist',
'posts_per_page' => -1,
'post_status' => 'publish'
];

$posts = get_posts($args);

foreach ($posts as $post) {
$new_slug = str_replace('-sold', '', $post->post_name);

if ($new_slug !== $post->post_name) {
wp_update_post([
'ID' => $post->ID,
'post_name' => $new_slug
]);
}
}
}
update_existing_slugs();