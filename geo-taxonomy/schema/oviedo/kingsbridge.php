<?php
if (
    site_is_geo_taxonomy('kingsbridge')
    || site_has_geo_term('kingsbridge')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Kingsbridge/2887241',
        'homes-open-houses/Oviedo-Florida-s-Kingsbridge/2887241',
        'homes-market-report/Oviedo-Florida-s-Kingsbridge/2887241'
    ))
) {
    $canon = home_url('/central-florida/oviedo/kingsbridge/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Kingsbridge',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1PovjyYg6mGYUokN0-oCkSxSiVjRP82s&usp=sharing',
        'description' => 'Kingsbridge is a picturesque residential community known for its family-friendly atmosphere, scenic surroundings, and convenient access to local amenities. The neighborhood is divided into Kingsbridge East and Kingsbridge West, both offering a variety of well-maintained homes with beautiful landscaping.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32765',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Playgrounds', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Picnic Areas', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Open Green Spaces', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Beautifully Maintained Parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Scenic Walking Trails', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Tranquil Ponds or Lakes', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
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
                '@type' => 'EducationalOrganization',
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
                '@type' => 'EducationalOrganization',
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
        $poly = geo_taxonomy_polygon('oviedo', 'kingsbridge');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
