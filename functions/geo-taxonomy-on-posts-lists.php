<?php
function add_geo_taxonomy_column($columns)
{
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'categories' || $key === 'date') {
            $new_columns['geo_taxonomy'] = __('Geo Taxonomy', 'textdomain');
        }
    }
    return $new_columns;
}
add_filter('manage_edit-post_columns', 'add_geo_taxonomy_column');
add_filter('manage_edit-page_columns', 'add_geo_taxonomy_column');
add_filter('manage_edit-idxc_featlist_columns', 'add_geo_taxonomy_column');

function get_full_geo_taxonomy_slug($term)
{
    $slug_path = [];
    while ($term && !is_wp_error($term)) {
        $slug_path[] = $term->slug;
        $term = get_term($term->parent, 'geo_taxonomy');
    }
    return !empty($slug_path) ? '/geo/' . implode('/', array_reverse($slug_path)) . '/' : null;
}

function populate_geo_taxonomy_column($column, $post_id)
{
    if ($column === 'geo_taxonomy') {
        $terms = get_the_terms($post_id, 'geo_taxonomy');
        if (!empty($terms) && !is_wp_error($terms)) {
            $full_slugs = array_filter(array_map('get_full_geo_taxonomy_slug', $terms));
            if (!empty($full_slugs)) {
                echo esc_html(implode(', ', $full_slugs));
            } else {
                echo __('—', 'textdomain');
            }
        } else {
            echo __('—', 'textdomain');
        }
    }
}
add_action('manage_post_posts_custom_column', 'populate_geo_taxonomy_column', 10, 2);
add_action('manage_page_posts_custom_column', 'populate_geo_taxonomy_column', 10, 2);
add_action('manage_idxc_featlist_posts_custom_column', 'populate_geo_taxonomy_column', 10, 2);

function add_geo_taxonomy_search_to_editor()
{
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        let taxonomyBox = document.querySelector("#geo_taxonomydiv .inside");
        if (taxonomyBox) {
            let searchBox = document.createElement("input");
            searchBox.setAttribute("type", "text");
            searchBox.setAttribute("placeholder", "Search Geo Tags...");
            searchBox.setAttribute("style", "margin-bottom:5px;width:100%;");
            taxonomyBox.insertBefore(searchBox, taxonomyBox.firstChild);
            searchBox.addEventListener("keyup", function() {
                let filter = this.value.toLowerCase();
                let termsList = taxonomyBox.querySelectorAll("ul li");
                termsList.forEach(function(term) {
                    if (term.textContent.toLowerCase().includes(filter)) {
                        term.style.display = "list-item";
                    } else {
                        term.style.display = "none";
                    }
                });
            });
        }
    });
    </script>';
}
add_action('admin_footer', 'add_geo_taxonomy_search_to_editor');
