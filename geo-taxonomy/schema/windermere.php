<?php
if (
    site_is_geo_taxonomy('windermere')
    || site_has_geo_term('windermere')
    || is_page(array(
        'homes-listing-report/Windermere-Florida/2877202',
        'homes-open-houses/Windermere-Florida/2877202',
        'homes-market-report/Windermere-Florida/2877202'
    ))
) {
    $canon = home_url('/central-florida/windermere/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Windermere',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1lhwMxL6HUW6x7QRC5ajKnlxHFCddORs&usp=sharing',
        'description' => 'Windermere is a charming and affluent town in Orange County, Florida, known for its tranquil atmosphere, scenic landscapes, and luxurious homes. The town offers a blend of small-town charm and modern amenities, with exclusive neighborhoods and proximity to some of Florida’s most iconic attractions.',
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.4958,
            'longitude' => -81.5345,
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Windermere',
            'addressRegion' => 'FL',
            'postalCode' => '34786',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://town.windermere.fl.us/',
            'https://en.wikipedia.org/wiki/Windermere,_Florida',
            'https://www.tripadvisor.com/Tourism-g34743-Windermere_Florida-Vacations.html',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Windermere Elementary School',
                'url' => 'https://windermerees.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '11125 Park Ave',
                    'addressLocality' => 'Windermere',
                    'addressRegion' => 'FL',
                    'postalCode' => '34786',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Gotha Middle School',
                'url' => 'https://gothams.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '9155 Gotha Rd',
                    'addressLocality' => 'Windermere',
                    'addressRegion' => 'FL',
                    'postalCode' => '34786',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Windermere High School',
                'url' => 'https://windermerehs.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '5523 Winter Garden Vineland Rd',
                    'addressLocality' => 'Windermere',
                    'addressRegion' => 'FL',
                    'postalCode' => '34786',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('windermere');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
