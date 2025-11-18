<?php
// 🔹 TJS — Schema loads on geo page + Optima Express virtual pages for Waterford Lakes

// Only output on the Waterford Lakes geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('waterford-lakes')
    || site_has_geo_term('waterford-lakes')
    || is_page(array(
        'homes-listing-report/Orlando-Florida-s-Waterford-Lakes/2886990',
        'homes-open-houses/Orlando-Florida-s-Waterford-Lakes/2886990',
        'homes-market-report/Orlando-Florida-s-Waterford-Lakes/2886990'
    ))
) {
    $canon = home_url('/central-florida/orlando/waterford-lakes/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Waterford Lakes',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1rAXeWSEfXrxYekrYGOeZSa5gcs5quEM&usp=sharing',
        'description' => 'Waterford Lakes is a vibrant community located in Orlando, Florida, known for its family-friendly atmosphere, well-maintained neighborhoods, and a wide range of amenities.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Orlando',
            'addressRegion' => 'FL',
            'postalCode' => '32828',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Tree-lined streets', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Expansive parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking trails', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Sports fields', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Playgrounds', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Waterford Elementary School',
                'url' => 'https://waterfordes.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32828',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Discovery Middle School',
                'url' => 'https://discoveryms.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32828',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Timber Creek High School',
                'url' => 'https://timbercreekhs.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32828',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('orlando', 'waterford-lakes');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
