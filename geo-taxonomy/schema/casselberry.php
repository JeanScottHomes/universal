<?php
// Output only on Casselberry geo archive, posts with the term, or Optima Express virtual pages
if (
    site_is_geo_taxonomy('casselberry')
    || site_has_geo_term('casselberry')
    || is_page(array(
        'homes-listing-report/Casselberry-Florida/2877180',
        'homes-open-houses/Casselberry-Florida/2877180',
        'homes-market-report/Casselberry-Florida/2877180'
    ))
) {
    $canon = home_url('/central-florida/casselberry/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Casselberry',
        'description' => 'Casselberry is a vibrant suburban city located in central Florida, part of the Orlando–Kissimmee–Sanford Metropolitan Area. Known for its natural beauty and laid-back atmosphere, it is a popular choice for families and retirees alike.',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1FAU50QWsq-VbnkIJbIrqkZucjUEKVR8&usp=sharing',
        'sameAs' => array(
            'https://www.casselberry.org/',
            'https://en.wikipedia.org/wiki/Casselberry,_Florida',
            'https://www.tripadvisor.com/Tourism-g34125-Casselberry_Florida-Vacations.html',
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Casselberry',
            'addressRegion' => 'FL',
            'postalCode' => '32707',
            'addressCountry' => 'US',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Casselberry Elementary School',
                'url' => 'https://casselberry.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Casselberry',
                    'addressRegion' => 'FL',
                    'postalCode' => '32707',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'South Seminole Middle Academy',
                'url' => 'https://ssa.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Casselberry',
                    'addressRegion' => 'FL',
                    'postalCode' => '32707',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lyman High School',
                'url' => 'https://lyman.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Longwood',
                    'addressRegion' => 'FL',
                    'postalCode' => '32750',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('casselberry');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
