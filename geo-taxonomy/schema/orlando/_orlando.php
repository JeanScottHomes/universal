<?php
// 🔹 TJS 09/16/2025 — Schema loads on geo page + Optima Express virtual pages for Orlando

// Only output on the Orlando geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('orlando')
    || site_has_geo_term('orlando')
    || is_page(array(
        'homes-listing-report/Orlando-Florida/2870465',
        'homes-open-houses/Orlando-Florida/2870465',
        'homes-market-report/Orlando-Florida/2870465'
    ))
) {
    $canon = home_url('/central-florida/orlando/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Orlando',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1kvtEug1eEdd2GkOm4Y1sHoGTL05VCR0&usp=sharing',
        'description' => 'Orlando, Florida, is a vibrant city known for its world-famous theme parks, warm climate, and diverse attractions. Walt Disney World, Universal Studios, and SeaWorld, Orange County Convention Center.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Orlando',
            'addressRegion' => 'FL',
            'postalCode' => '32801',
            'addressCountry' => 'US',
        ),
        // Move schools to containsPlace for correctness
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Pinecrest Preparatory Charter School',
                'url' => 'https://www.pinecrestorlando.org/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32827',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Judson B Walker Middle School',
                'url' => 'https://walkerms.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32809',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Cypress Creek High School',
                'url' => 'https://cypresscreekhs.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32824',
                    'addressCountry' => 'US',
                ),
            ),
        ),
        'sameAs' => array(
            'https://www.orlando.gov/Home',
            'https://en.wikipedia.org/wiki/Orlando,_Florida',
            'https://www.tripadvisor.com/Tourism-g34515-Orlando_Florida-Vacations.html',
        ),
    );

    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('orlando');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
