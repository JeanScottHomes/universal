<?php
if (
    site_is_geo_taxonomy('winter-springs')
    || site_has_geo_term('winter-springs')
    || is_page(array(
        'homes-listing-report/Winter-Springs-Florida/2877205',
        'homes-open-houses/Winter-Springs-Florida/2877205',
        'homes-market-report/Winter-Springs-Florida/2877205'
    ))
) {
    $canon = home_url('/central-florida/winter-springs/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Winter Springs',
        'url' => $canon,
        'description' => 'Winter Springs, Florida, is a family-friendly suburban city known for its excellent schools, scenic parks, and outdoor recreation opportunities. The city offers a peaceful environment with nature trails, lakes, and easy access to major highways.',
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.6989,
            'longitude' => -81.3081,
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Winter Springs',
            'addressRegion' => 'FL',
            'postalCode' => '32708',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://www.winterspringsfl.org/',
            'https://www.winterspringsfl.org/community/page/about-us',
            'https://en.wikipedia.org/wiki/Winter_Springs,_Florida',
            'https://www.tripadvisor.com/Tourism-g34748-Winter_Springs_Florida-Vacations.html',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Rainbow Elementary School',
                'url' => 'https://rainbow.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1412 Rainbow Trail',
                    'addressLocality' => 'Winter Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => '32708',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Winter Springs High School',
                'url' => 'https://winterspringshs.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '130 Tuskawilla Road',
                    'addressLocality' => 'Winter Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => '32708',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('winter-springs');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
