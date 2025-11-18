<?php
if (
    site_is_geo_taxonomy('riverside-at-twin-rivers')
    || site_has_geo_term('riverside-at-twin-rivers')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Riverside-at-Twin-Rivers/2887243',
        'homes-open-houses/Oviedo-Florida-s-Riverside-at-Twin-Rivers/2887243',
        'homes-market-report/Oviedo-Florida-s-Riverside-at-Twin-Rivers/2887243'
    ))
) {
    $canon = home_url('/central-florida/oviedo/riverside-at-twin-rivers/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Riverside at Twin Rivers',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1olROyhr5LsV4urIlgY50qMxstL8QpDE&usp=sharing',
        'description' => 'Riverside at Twin Rivers is a charming residential community known for its peaceful atmosphere and scenic surroundings. The neighborhood features well-maintained homes, tree-lined streets, and a strong sense of community, making it an ideal place for families and individuals seeking a quiet suburban lifestyle.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Local parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking trails', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational facilities', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Proximity to top-rated schools', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Nearby shopping centers and dining options', 'value' => true ),
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
        $poly = geo_taxonomy_polygon('oviedo', 'riverside-at-twin-rivers');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
