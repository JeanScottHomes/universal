<?php
if (
    site_is_geo_taxonomy('twin-rivers')
    || site_has_geo_term('twin-rivers')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Twin-Rivers/2887245',
        'homes-open-houses/Oviedo-Florida-s-Twin-Rivers/2887245',
        'homes-market-report/Oviedo-Florida-s-Twin-Rivers/2887245'
    ))
) {
    $canon = home_url('/central-florida/oviedo/twin-rivers/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Twin Rivers Golf Community',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1drXpn3Glz4IvCnm3DuHeXiHJuSetntw&usp=sharing',
        'description' => 'Twin Rivers Golf Community is a picturesque residential neighborhood centered around a beautiful golf course. Known for its serene environment and lush landscapes, the community offers a variety of well-maintained single-family homes.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Golf course', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Parks and green spaces', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Nature trails', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Partin Elementary School',
                'url' => 'https://partin.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1500 Twin Rivers Blvd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Chiles Middle School',
                'url' => 'https://lcms.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1240 Sanctuary Dr',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Hagerty High School',
                'url' => 'https://hagertyhigh.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '3225 Lockwood Blvd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('oviedo', 'twin-rivers');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
