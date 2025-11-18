<?php
// 🔹 TJS 09/16/2025 — Schema loads on geo page + Optima Express virtual pages for Avalon Park

// Only output on the Avalon Park geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('avalon-park')
    || site_has_geo_term('avalon-park')
    || is_page(array(
        'homes-listing-report/Orlando-Florida-s-Avalon-Park/2885976',
        'homes-open-houses/Orlando-Florida-s-Avalon-Park/2885976',
        'homes-market-report/Orlando-Florida-s-Avalon-Park/2885976'
    ))
) {
    $canon = home_url('/central-florida/orlando/avalon-park/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Avalon Park',
        'description' => 'Avalon Park is a master-planned community (PUD) featuring single-family homes, parks, clubhouse, and a community pool.',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1gmMV0f9eDytTOIliXDjFnIfGf1pCGR8&usp=sharing',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Orlando',
            'addressRegion' => 'FL',
            'postalCode' => '32828',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Pool', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Bike trails', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Community centers', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Avalon Elementary School',
                'url' => 'https://avalones.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32828',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Avalon Middle',
                'url' => 'https://www.avalonmiddle.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32828',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Timber Creek High School',
                'url' => 'https://www.tchs.ocps.net/',
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
        $poly = geo_taxonomy_polygon('orlando', 'avalon-park');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
