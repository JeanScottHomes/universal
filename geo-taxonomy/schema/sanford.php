<?php
if (
    site_is_geo_taxonomy('sanford')
    || site_has_geo_term('sanford')
    || is_page(array(
        'homes-listing-report/Sanford-Florida/2877199',
        'homes-open-houses/Sanford-Florida/2877199',
        'homes-market-report/Sanford-Florida/2877199'
    ))
) {
    $canon = home_url('/central-florida/sanford/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Sanford',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1mtTQjc4CbbeXU1NGPEzaukKUSbfj3h0&usp=sharing',
        'description' => "Sanford, Florida, known as the 'Historic Waterfront Gateway City,' boasts a rich heritage with a charming downtown featuring brick-lined streets, unique shops, art galleries, and a variety of restaurants. The city is home to cultural and recreational attractions, including the Central Florida Zoo, Sanford RiverWalk, and Fort Mellon Park. Sanford’s vibrant community frequently hosts events such as farmers' markets, festivals, and live performances.",
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.8006,
            'longitude' => -81.2731,
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Sanford',
            'addressRegion' => 'FL',
            'postalCode' => '32771',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://sanfordfl.gov/',
            'https://en.wikipedia.org/wiki/Sanford,_Florida',
            'https://www.tripadvisor.com/Tourism-g34615-Sanford_Florida-Vacations.html',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Hamilton Elementary School of Engineering and Technology',
                'url' => 'https://hamilton.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1501 E 8th St',
                    'addressLocality' => 'Sanford',
                    'addressRegion' => 'FL',
                    'postalCode' => '32771',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Sanford Middle School',
                'url' => 'https://sanford.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1700 S French Ave',
                    'addressLocality' => 'Sanford',
                    'addressRegion' => 'FL',
                    'postalCode' => '32771',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Crooms Academy of Information Technology',
                'url' => 'https://cait.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '2200 W 13th St',
                    'addressLocality' => 'Sanford',
                    'addressRegion' => 'FL',
                    'postalCode' => '32771',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('sanford');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
