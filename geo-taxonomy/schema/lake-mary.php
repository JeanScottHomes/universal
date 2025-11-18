<?php
if (
    site_is_geo_taxonomy('lake-mary')
    || site_has_geo_term('lake-mary')
    || is_page(array(
        'homes-listing-report/Lake-Mary-Florida/2877196',
        'homes-open-houses/Lake-Mary-Florida/2877196',
        'homes-market-report/Lake-Mary-Florida/2877196'
    ))
) {
    $canon = home_url('/central-florida/lake-mary/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Lake Mary',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1aWIngMPmCtw5wlqFigEwuoJ_5hqsyXk&usp=sharing',
        'description' => "Lake Mary, Florida, is a charming and affluent city in Seminole County, known for its scenic lakes, safe neighborhoods, and vibrant community. Often called the 'City of Lakes,' it offers a family-friendly environment with excellent schools, lush parks, and a strong local economy fueled by technology and business hubs. Residents enjoy upscale living, recreational activities like golf and nature trails, and a variety of dining and shopping options.",
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Lake Mary',
            'addressRegion' => 'FL',
            'postalCode' => '32746',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://www.lakemaryfl.com/',
            'https://en.wikipedia.org/wiki/Lake_Mary,_Florida',
            'https://www.tripadvisor.com/Tourism-g34366-Lake_Mary_Florida-Vacations.html',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lake Mary Elementary School',
                'url' => 'https://www.lakemaryelem.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '132 S Country Club Rd',
                    'addressLocality' => 'Lake Mary',
                    'addressRegion' => 'FL',
                    'postalCode' => '32746',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Greenwood Lakes Middle School',
                'url' => 'https://greenwoodlakes.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '601 Lake Park Dr',
                    'addressLocality' => 'Lake Mary',
                    'addressRegion' => 'FL',
                    'postalCode' => '32746',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lake Mary High School',
                'url' => 'https://lakemaryhs.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '655 Longwood Lake Mary Rd',
                    'addressLocality' => 'Lake Mary',
                    'addressRegion' => 'FL',
                    'postalCode' => '32746',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('lake-mary');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
