<?php
if (
    site_is_geo_taxonomy('aloma-woods')
    || site_has_geo_term('aloma-woods')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Aloma-Woods/2887240',
        'homes-open-houses/Oviedo-Florida-s-Aloma-Woods/2887240',
        'homes-market-report/Oviedo-Florida-s-Aloma-Woods/2887240'
    ))
) {
    $canon = home_url('/central-florida/oviedo/aloma-woods/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Aloma Woods',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1H7vr3qaumWKh9LAAFigPj2XOZmka7YI&usp=sharing',
        'description' => 'Aloma Woods is a charming and family-friendly residential community known for its tranquil environment and natural beauty. Nestled amidst scenic lakes and lush greenery, it offers a peaceful suburban lifestyle while maintaining convenient access to major roadways, shopping, dining, and top-rated schools.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32765',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational facilities', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Cross Seminole Trail for biking and hiking', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Evans Elementary School',
                'url' => 'https://evans.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '100 E Chapman Rd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
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
                '@type' => 'School',
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
        $poly = geo_taxonomy_polygon('oviedo', 'aloma-woods');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
