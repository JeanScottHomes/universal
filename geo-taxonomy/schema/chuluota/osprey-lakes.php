<?php
if (
    site_is_geo_taxonomy('osprey-lakes')
    || site_has_geo_term('osprey-lakes')
) {
    $canon = home_url('/central-florida/chuluota/osprey-lakes/');
    $map = 'https://www.google.com/maps/d/viewer?mid=13mf9p8rkd-mNbbdlGu_gnbjywnE1PgM&usp=sharing';
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Osprey Lakes',
        'description' => 'Osprey Lakes is a picturesque, gated community surrounded by natural conservation areas and scenic water views. The neighborhood features spacious single-family homes with large lots. Residents enjoy a peaceful environment complemented by nearby walking trails, parks, and opportunities for outdoor activities.',
        'url' => $canon,
        'hasMap' => $map,
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Chuluota',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Gated access', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Nature and conservation areas', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking trails', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Large lots', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Proximity to parks', 'value' => true ),
        ),
        'containedInPlace' => array(
            '@type' => 'City',
            'name' => 'Chuluota',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.6415,
            'longitude' => -81.1093,
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Walker Elementary School',
                'url' => 'https://walker.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '3101 Snow Hill Rd',
                    'addressLocality' => 'Chuluota',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lawton Chiles Middle School',
                'url' => 'https://lcms.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1240 Sanctuary Dr',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Hagerty High School',
                'url' => 'https://hagertyhigh.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '3225 Lockwood Blvd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );

    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('chuluota', 'osprey-lakes');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
