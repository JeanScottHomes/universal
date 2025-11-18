<?php
$canon = home_url('/central-florida/st-cloud/');
$map = 'https://www.google.com/maps/d/viewer?mid=1INaIRk_vdzSelHVR52j9DpR3oWYbI7E&usp=sharing';
$data = array(
    '@context' => 'https://schema.org',
    '@type' => 'City',
    '@id' => trailingslashit($canon) . '#city',
    'name' => 'St. Cloud',
    'description' => 'St. Cloud is a charming city located in Osceola County, Florida, just southeast of Orlando. Known for its rich history, family-friendly atmosphere, and picturesque lakeside views, St. Cloud offers a mix of small-town charm and modern conveniences.',
    'url' => $canon,
    'hasMap' => $map,
    'geo' => array(
        '@type' => 'GeoCoordinates',
        'latitude' => 28.2489,
        'longitude' => -81.2812,
    ),
    'address' => array(
        '@type' => 'PostalAddress',
        'addressLocality' => 'St. Cloud',
        'addressRegion' => 'FL',
        'postalCode' => '34769',
        'addressCountry' => 'US',
    ),
    'sameAs' => array(
        'https://www.stcloudfl.gov/',
        'https://en.wikipedia.org/wiki/St._Cloud,_Florida',
        'https://www.tripadvisor.com/Tourism-g34601-Saint_Cloud_Florida-Vacations.html',
    ),
    'containsPlace' => array(
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'St. Cloud Elementary School',
            'url' => 'https://www.floridaschoolgrades.com/school/49-0111/',
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '2701 Budinger Ave',
                'addressLocality' => 'St. Cloud',
                'addressRegion' => 'FL',
                'postalCode' => '34769',
                'addressCountry' => 'US',
            ),
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'St. Cloud Middle School',
            'url' => 'https://www.myosceolachoice.school/middle-schools/st-cloud-middle-school',
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '1975 Michigan Ave',
                'addressLocality' => 'St. Cloud',
                'addressRegion' => 'FL',
                'postalCode' => '34769',
                'addressCountry' => 'US',
            ),
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'St. Cloud High School',
            'url' => 'https://www.myosceolachoice.school/high-school/st-cloud-high-school',
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '2000 Bulldog Ln',
                'addressLocality' => 'St. Cloud',
                'addressRegion' => 'FL',
                'postalCode' => '34769',
                'addressCountry' => 'US',
            ),
        ),
    ),
);

if (function_exists('geo_taxonomy_polygon')) {
    $poly = geo_taxonomy_polygon('st-cloud');
    if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
}

echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
?>
