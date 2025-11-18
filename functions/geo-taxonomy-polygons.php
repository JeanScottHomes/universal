<?php
/**
 * Geo Taxonomy polygon + helper utilities.
 *
 * geo_taxonomy_polygon($city_slug, $place_slug = '')
 * - Reads GeoJSON from /universal/geo-taxonomy/json/{city}/{slug}.geo.json
 *   or /universal/geo-taxonomy/json/{city}.geo.json (when $place_slug is empty)
 * - Returns a schema.org GeoShape polygon string: "lat lon lat lon ..."
 *
 * site_has_geo_term($term, $post = null)
 * - Checks whether the current query (or explicit post) carries a geo term
 *   in either the legacy `geo` taxonomy or the current `geo_taxonomy`. 
 */

if (!function_exists('geo_taxonomy_polygon')) {
    function geo_taxonomy_polygon($city_slug, $place_slug = '')
    {
        $base = get_stylesheet_directory() . '/geo-taxonomy/json';
        $path = '';

        $city_slug = sanitize_title($city_slug);
        $place_slug = $place_slug !== '' ? sanitize_title($place_slug) : '';

        if ($place_slug !== '') {
            $path = $base . '/' . $city_slug . '/' . $place_slug . '.geo.json';
        } else {
            $path = $base . '/' . $city_slug . '.geo.json';
        }

        if (!file_exists($path)) {
            return '';
        }

        $raw = file_get_contents($path);
        if ($raw === false) return '';
        $j = json_decode($raw, true);
        if (!is_array($j)) return '';

        // Expect FeatureCollection -> features[0] -> geometry -> coordinates[0] (Polygon)
        $coords = $j['features'][0]['geometry']['coordinates'][0] ?? null;
        if (!is_array($coords) || empty($coords)) return '';

        $parts = [];
        foreach ($coords as $pair) {
            if (!is_array($pair) || count($pair) < 2) continue;
            $lon = $pair[0];
            $lat = $pair[1];
            if (!is_numeric($lat) || !is_numeric($lon)) continue;
            $parts[] = $lat . ' ' . $lon;
        }
        if (empty($parts)) return '';

        // Ensure ring closure (first == last)
        if ($parts[0] !== end($parts)) {
            $parts[] = $parts[0];
        }

        return implode(' ', $parts);
    }
}

if (!function_exists('site_has_geo_term')) {
    /**
     * Detects whether the current query (or a provided post) carries the geo taxonomy term.
     * Handles both the legacy `geo` taxonomy and the current `geo_taxonomy` slug.
     */
    function site_has_geo_term($term = '', $post = null)
    {
        $post_obj = get_post($post);
        if (!$post_obj) {
            return false;
        }

        $taxonomies = array('geo_taxonomy', 'geo');

        // Manually inspect assignments to dodge the core warning triggered when has_term()
        // receives an array of taxonomies (WP core still expects a string here).

        // Normalise the term input to arrays of IDs, slugs and names for comparison.
        $term_ids   = array();
        $term_slugs = array();
        $term_names = array();

        if ('' === $term || $term === null) {
            // Empty input means "does it have any term" – mirror has_term() behaviour.
            $term_ids = $term_slugs = $term_names = null;
        } else {
            foreach ((array) $term as $candidate) {
                if (is_object($candidate) && isset($candidate->term_id, $candidate->slug)) {
                    $term_ids[]   = (int) $candidate->term_id;
                    $term_slugs[] = sanitize_title($candidate->slug);
                    if (isset($candidate->name)) {
                        $term_names[] = sanitize_text_field($candidate->name);
                    }
                    continue;
                }

                if (is_numeric($candidate)) {
                    $term_ids[] = (int) $candidate;
                    continue;
                }

                if (is_string($candidate)) {
                    $term_slugs[] = sanitize_title($candidate);
                    $term_names[] = sanitize_text_field($candidate);
                }
            }
        }

        foreach ($taxonomies as $taxonomy) {
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            $object_terms = get_the_terms($post_obj, $taxonomy);
            if (is_wp_error($object_terms) || empty($object_terms)) {
                continue;
            }

            // When no specific term requested, any match is sufficient.
            if ($term_ids === null && $term_slugs === null && $term_names === null) {
                return true;
            }

            foreach ($object_terms as $object_term) {
                $object_id   = isset($object_term->term_id) ? (int) $object_term->term_id : 0;
                $object_slug = isset($object_term->slug) ? sanitize_title($object_term->slug) : '';
                $object_name = isset($object_term->name) ? sanitize_text_field($object_term->name) : '';

                if (!empty($term_ids) && $object_id && in_array($object_id, $term_ids, true)) {
                    return true;
                }

                if (!empty($term_slugs) && $object_slug !== '' && in_array($object_slug, $term_slugs, true)) {
                    return true;
                }

                if (!empty($term_names) && $object_name !== '' && in_array($object_name, $term_names, true)) {
                    return true;
                }
            }
        }

        return false;
    }
}
