<?php
if (
    site_is_geo_taxonomy('alafaya-woods')
    || site_has_geo_term('alafaya-woods')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Alafaya-Woods/2887239',
        'homes-open-houses/Oviedo-Florida-s-Alafaya-Woods/2887239',
        'homes-market-report/Oviedo-Florida-s-Alafaya-Woods/2887239'
    ))
) {
    $canon = home_url('/central-florida/oviedo/alafaya-woods/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Alafaya Woods',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1aBZvLrBfFBbjxXLxsSFf58gMxGTaNqM&usp=sharing',
        'description' => 'Alafaya Woods is a welcoming residential community known for its tranquil setting and family-friendly environment. The neighborhood features a variety of single-family homes surrounded by lush greenery and tree-lined streets, creating a peaceful suburban atmosphere.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32765',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Local parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Playgrounds', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational facilities', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Proximity to shopping centers', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Dining options', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Top-rated schools', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Evans Elementary School',
                'url' => 'https://evans.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Jackson Heights Middle School',
                'url' => 'https://jhms.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Hagerty High School',
                'url' => 'https://hagertyhigh.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('oviedo', 'alafaya-woods');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
