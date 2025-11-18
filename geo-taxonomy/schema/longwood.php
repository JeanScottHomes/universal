<?php
if (
    site_is_geo_taxonomy('longwood')
    || site_has_geo_term('longwood')
    || is_page(array(
        'homes-listing-report/Longwood-Florida/2877197',
        'homes-open-houses/Longwood-Florida/2877197',
        'homes-market-report/Longwood-Florida/2877197'
    ))
) {
    $canon = home_url('/central-florida/longwood/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Longwood',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1KsVwH92yksehi50Vu5_z31XthJvSljw&usp=sharing',
        'description' => 'Longwood is a historic and picturesque city located in Seminole County, Florida. Nestled in the northern part of the Orlando Metropolitan Area, Longwood is known for its small-town charm, rich history, and family-friendly atmosphere. The city blends natural beauty with modern amenities, making it a popular choice for families, professionals, and retirees.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Longwood',
            'addressRegion' => 'FL',
            'postalCode' => '32750',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://www.longwoodfl.org/',
            'https://en.wikipedia.org/wiki/Longwood,_Florida',
            'https://www.tripadvisor.com/Tourism-g34400-Longwood_Florida-Vacations.html',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Small-town charm', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Rich history', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Family-friendly atmosphere', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Modern amenities', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Woodlands Elementary School',
                'url' => 'https://wdes.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1420 E.E. Williamson Rd',
                    'addressLocality' => 'Longwood',
                    'addressRegion' => 'FL',
                    'postalCode' => '32750',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Rock Lake Middle School',
                'url' => 'https://rocklakemiddle.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '250 Slade Dr',
                    'addressLocality' => 'Longwood',
                    'addressRegion' => 'FL',
                    'postalCode' => '32750',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'One School of The Arts & Sciences',
                'url' => 'https://www.oneschool.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1675 Dixon Rd #2762',
                    'addressLocality' => 'Longwood',
                    'addressRegion' => 'FL',
                    'postalCode' => '32779',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('longwood');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
