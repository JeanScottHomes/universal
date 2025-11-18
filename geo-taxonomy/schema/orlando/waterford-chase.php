<?php
// 🔹 TJS 09/16/2025 — Schema loads on geo page + Optima Express virtual pages for Waterford Chase

// Only output on the Waterford Chase geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('waterford-chase')
    || site_has_geo_term('waterford-chase')
    || is_page(array(
        'homes-listing-report/Orlando-Florida-s-Waterford-Chase/2886991',
        'homes-open-houses/Orlando-Florida-s-Waterford-Chase/2886991',
        'homes-market-report/Orlando-Florida-s-Waterford-Chase/2886991'
    ))
) {
    $canon = home_url('/central-florida/orlando/waterford-chase/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Waterford Chase',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1d0BBdu_osL6S4WoMzNok9g2lebXeQYk&usp=sharing',
        'description' => 'Waterford Chase is a vibrant residential community which offers a mix of single-family homes in well-maintained, tree-lined streets. Residents enjoy access to top-rated schools, numerous parks, and recreational facilities, fostering an active lifestyle.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Orlando',
            'addressRegion' => 'FL',
            'postalCode' => '32828',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Playgrounds', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Basketball courts', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Tennis courts', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking trails', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Camelot Elementary School',
                'url' => 'https://camelotes.ocps.net/',
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
                'name' => 'Timber Springs Middle School',
                'url' => 'https://timberspringsms.ocps.net/',
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
        $poly = geo_taxonomy_polygon('orlando', 'waterford-chase');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
