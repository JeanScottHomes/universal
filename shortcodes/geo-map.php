<?php
/**
 * Shortcode: [geo-map]
 * Strategy
 * - Store polygons as GeoJSON at /universal/geo-taxonomy/json/{city}/{slug}.geo.json
 * - JSON-LD uses GeoShape.polygon from the same KML/KMZ source
 * - This shortcode renders that GeoJSON with Leaflet; schema never forces UI
 *
 * Usage
 * - Auto-detect geo term on archive/singular: [geo-map]
 * - Explicit slug/city: [geo-map slug="live-oak-reserve" city="oviedo" height="420px"]
 * - Optional tiles: [geo-map tile="mapbox" id="mapbox/streets-v11" token="YOUR_TOKEN"]
 *   Token fallback order: shortcode token="..." → constant MAPBOX_ACCESS_TOKEN → filter 'jsh_mapbox_token'.
 */

add_shortcode('geo-map', function ($atts = []) {
    $atts = shortcode_atts([
        'slug' => '',
        'city' => '', // optional; if omitted we'll attempt to infer parent geo term as city
        'height' => '360px',
        'tile' => 'osm', // 'osm' (default) or 'mapbox'
        'id' => 'mapbox/streets-v11', // mapbox style id when tile=mapbox
        'token' => '', // optional Mapbox token; see fallback order in doc
    ], $atts, 'geo-map');

    $slug = sanitize_title($atts['slug']);
    $city = sanitize_title($atts['city']);

    // Infer slug/city from context if not provided
    if (!$slug) {
        if (site_is_geo_taxonomy()) {
            $term = get_queried_object();
        } elseif (is_singular()) {
            $terms = get_the_terms(get_queried_object_id(), 'geo_taxonomy');
            if ($terms && !is_wp_error($terms)) {
                // pick deepest term (child preferred)
                usort($terms, function ($a, $b) { return ($b->parent ? 1 : 0) - ($a->parent ? 1 : 0); });
                $term = $terms[0];
            }
        }
        if (!empty($term->slug)) {
            $slug = $term->slug;
            if (!$city && $term->parent) {
                $parent = get_term($term->parent, 'geo_taxonomy');
                if ($parent && !is_wp_error($parent)) {
                    $city = $parent->slug;
                }
            }
        }
    }

    if (!$slug) {
        return '<!-- geo-map: no slug found -->';
    }

    // If city still empty, try to find a parent via get_term_by('slug', ...)
    if (!$city) {
        // Fallback: many sites use {city}/{neighborhood} slugs; leave blank to try direct file at /json/{slug}.geo.json
    }

    $base_path = get_stylesheet_directory() . '/geo-taxonomy/json/';
    $base_url  = get_stylesheet_directory_uri() . '/geo-taxonomy/json/';

    $candidates = [];
    if ($city) {
        $candidates[] = [$base_path . $city . '/' . $slug . '.geo.json', $base_url . $city . '/' . $slug . '.geo.json'];
    }
    $candidates[] = [$base_path . $slug . '.geo.json', $base_url . $slug . '.geo.json'];

    $json_url = '';
    foreach ($candidates as [$p, $u]) {
        if (file_exists($p)) { $json_url = $u; break; }
    }

    if (!$json_url) {
        // Nothing found; fail silently but leave a comment for admins
        if (current_user_can('manage_options')) {
            return '<!-- geo-map: GeoJSON not found for slug=' . esc_attr($slug) . ' city=' . esc_attr($city) . ' -->';
        }
        return '';
    }

    // Enqueue Leaflet (tiles selected below: OSM default, Mapbox optional)
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

    $map_id = 'geo-map-' . uniqid();
    $height = esc_attr($atts['height']);

    ob_start();
    echo '<div class="geo-map" id="' . esc_attr($map_id) . '" style="height:' . $height . '; width:100%;"></div>';

    // Determine tile layer
    $tile = strtolower($atts['tile']);
    $token = $atts['token'];
    if (!$token && defined('MAPBOX_ACCESS_TOKEN')) $token = MAPBOX_ACCESS_TOKEN;
    if (!$token) $token = apply_filters('jsh_mapbox_token', '');
    $style_id = $atts['id'];

    $tile_js = " L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:19, attribution:'&copy; OpenStreetMap' }).addTo(map);\n";
    if ($tile === 'mapbox' && $token) {
        $tile_js = " L.tileLayer('https://api.mapbox.com/styles/v1/" . esc_js($style_id) . "/tiles/{z}/{x}/{y}?access_token=" . esc_js($token) . "', {\n"
                . " tileSize:512, zoomOffset:-1, maxZoom:19, attribution:'&copy; Mapbox &copy; OpenStreetMap'\n" . " }).addTo(map);\n";
    }

    $js = "(function(){\n"
        . "function ready(fn){if(document.readyState!='loading'){fn()}else{document.addEventListener('DOMContentLoaded',fn)}}\n"
        . "ready(function(){\n"
        . " var map = L.map('{$map_id}');\n"
        . $tile_js
        . " fetch('" . esc_url($json_url) . "').then(r=>r.json()).then(fc=>{\n"
        . "  var layer = L.geoJSON(fc, { style: { color:'#0288d1', weight:2, fillColor:'#0288d1', fillOpacity:0.2 } }).addTo(map);\n"
        . "  try { map.fitBounds(layer.getBounds(), { padding:[12,12] }); } catch(e) { map.setView([28.65,-81.2], 12); }\n"
        . " }).catch(()=>{ /* no-op */ });\n"
        . "});\n"
        . "})();";

    wp_add_inline_script('leaflet-js', $js);

    return ob_get_clean();
});
