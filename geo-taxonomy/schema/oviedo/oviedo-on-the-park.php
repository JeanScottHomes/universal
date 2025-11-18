<?php
if (
    site_is_geo_taxonomy('oviedo-on-the-park')
    || site_has_geo_term('oviedo-on-the-park')
) {
    $canon = home_url('/central-florida/oviedo/oviedo-on-the-park/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Oviedo on the Park',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1nZG-4Qee6tS1jG2mh4rYLfjIuqH8DqE&usp=sharing',
        'description' => 'Oviedo on the Park is a modern and vibrant mixed-use community located in the heart of Oviedo, Florida. Known for its walkable design and lively atmosphere, the area combines residential living with a variety of dining, shopping, and entertainment options. With a blend of townhomes, apartments, and nearby single-family homes, Oviedo on the Park offers diverse housing options to suit various lifestyles.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32765',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Center Lake Park', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Lakeside amphitheater', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Playgrounds', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Splash pad', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Open spaces for events and activities', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Lawton Elementary School',
                'url' => 'https://lawton.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '151 Graham Ave',
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
                    'streetAddress' => '41 Academy Ave',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Oviedo High School',
                'url' => 'https://oviedo.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '601 King St',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32765',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
