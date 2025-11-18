# Geo Taxonomy: Schema + Polygons + Map Shortcode

This directory holds two related pieces:

- `schema/` — PHP files that output JSON‑LD for cities and neighborhoods.
- `json/` — GeoJSON polygons used for rendering maps and for injecting `GeoShape.polygon` into JSON‑LD.

## How polygons flow into JSON‑LD

1) Source data is maintained as KML/KMZ (often inside a ZIP) in `tjs-files/google-maps-kmz/`.
2) We convert ZIP → KMZ → KML → `GeoJSON` and store under `json/{city-slug}/{neighborhood-slug}.geo.json`.
3) Schema files call `geo_taxonomy_polygon($city, $slug)` to get a `GeoShape.polygon` string and include it under the `geo` property.

Helper function: `universal/functions/geo-taxonomy-geo.php`
- `geo_taxonomy_polygon($city_slug, $place_slug = '')`
  - Reads the matching GeoJSON file
  - Extracts the first Polygon ring
  - Returns a space‑separated `"lat lon lat lon ..."` string as required by `https://schema.org/GeoShape`.

Notes:
- City outlines live at `json/{city}.geo.json`. Neighborhoods live at `json/{city}/{slug}.geo.json`.
- Rings are auto‑closed if needed (first coordinate is appended at end).

## Schema conventions

- Use PHP arrays + `wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)`.
- Types:
  - Cities → `City`
  - Neighborhoods → `Neighborhood` (or more precise like `GatedResidenceCommunity` when applicable)
  - Schools → `School` or `EducationalOrganization`
- Parent/child relation: use `containsPlace` for nested places (not `hasPart`).
- URLs:
  - `url` points to the canonical page on site
  - `@id` is a stable identifier (canonical URL + `#place` or `#city`)
  - `hasMap` is a public Google My Maps viewer URL (not edit URLs)
- For areas, prefer `geo` as `GeoShape` polygon. Do not mix in `GeoCoordinates` inside the same `geo` property.

## Shortcode: `[geo-map]`

Renders the polygon GeoJSON on a Leaflet map. Does not affect JSON‑LD.

- Auto‑detect geo term on archives/singular: `[geo-map]`
- Explicit params: `[geo-map slug="live-oak-reserve" city="oviedo" height="420px"]`
- Map tiles (default OSM; optional Mapbox):
  - `[geo-map tile="mapbox" id="mapbox/streets-v11" token="YOUR_TOKEN"]`
  - Token fallback order: shortcode `token` → `MAPBOX_ACCESS_TOKEN` constant → `jsh_mapbox_token` filter.

Template example:

```
<?php echo do_shortcode('[geo-map]'); ?>
```

## Adding or updating a polygon

1) Export from Google My Maps as KML/KMZ (or download layer as KMZ) and zip if needed.
2) Place the ZIP(s) in `tjs-files/google-maps-kmz/`.
3) Convert to GeoJSON (we used CLI helpers in the project; any KML→GeoJSON tool is fine).
4) Save as `json/{city-slug}/{neighborhood-slug}.geo.json` (or `json/{city}.geo.json` for city).
5) The schema file will pick it up automatically through `geo_taxonomy_polygon` if coded for that city/slug.

Slugging tips:
- Lowercase, letters/numbers/hyphens only
- City “Altamonte Springs” → `altamonte-springs`
- “Twin Rivers” → `twin-rivers`

## Troubleshooting

- If a map doesn’t render, ensure the GeoJSON path exists for the inferred `city/slug`.
- If JSON‑LD lacks a polygon, confirm the schema calls `geo_taxonomy_polygon(...)` and that the GeoJSON ring exists.
