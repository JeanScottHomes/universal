<?php
if (
    site_is_geo_taxonomy('winter-park')
    || site_has_geo_term('winter-park')
    || is_page(array(
        'homes-listing-report/Winter-Park-Florida/2877203',
        'homes-open-houses/Winter-Park-Florida/2877203',
        'homes-market-report/Winter-Park-Florida/2877203'
    ))
) {
    $canon = home_url('/central-florida/winter-park/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Winter Park',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=15-9vQ2UGvJjN43x--dSlI54r-gbkdhU&usp=sharing',
        'description' => 'Winter Park is a vibrant city known for its boutique shops, art galleries, and fine dining along the iconic Park Avenue. The city features numerous parks, including the picturesque Central Park, and a chain of lakes ideal for boating. Cultural highlights include the Charles Hosmer Morse Museum of American Art and annual festivals celebrating art, music, and food.',
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.5994,
            'longitude' => -81.3392,
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Winter Park',
            'addressRegion' => 'FL',
            'postalCode' => '32789',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://cityofwinterpark.org/',
            'https://en.wikipedia.org/wiki/Winter_Park,_Florida',
            'https://www.tripadvisor.com/Attraction_Review-g34747-d12484775-Reviews-Winter_Park-Winter_Park_Florida.html',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Eastbrook Elementary School',
                'url' => 'https://eastbrook.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '400 N Edgemon Ave',
                    'addressLocality' => 'Winter Park',
                    'addressRegion' => 'FL',
                    'postalCode' => '32792',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Tuskawilla Middle School',
                'url' => 'https://tuskawilla.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1801 Tuskawilla Rd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lake Howell High School',
                'url' => 'https://lakehowell.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '4200 Dike Rd',
                    'addressLocality' => 'Winter Park',
                    'addressRegion' => 'FL',
                    'postalCode' => '32792',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('winter-park');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
