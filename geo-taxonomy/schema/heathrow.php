<?php
if (
    site_is_geo_taxonomy('heathrow')
    || site_has_geo_term('heathrow')
    || is_page(array(
        'homes-listing-report/Heathrow-Florida/2877195',
        'homes-open-houses/Heathrow-Florida/2877195',
        'homes-market-report/Heathrow-Florida/2877195'
    ))
) {
    $canon = home_url('/central-florida/heathrow/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Heathrow',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1eRakCMma4FQAqJ95SXzGwbqTXMI4-Ws&usp=sharing',
        'sameAs' => array(
            'https://www.myheathrowflorida.com/',
            'https://en.wikipedia.org/wiki/Heathrow,_Florida',
            'https://www.tripadvisor.com/Tourism-g34282-Heathrow_Florida-Vacations.html',
        ),
        'description' => 'Heathrow, Florida, is an upscale suburban community located in Seminole County. It offers a blend of residential living and business amenities, making it a desirable place for families and professionals. The community features private gated neighborhoods, golf courses, and a range of recreational facilities. With easy access to top-rated schools, shopping centers, and dining options, Heathrow provides a balanced lifestyle of convenience and exclusivity.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Heathrow',
            'addressRegion' => 'FL',
            'postalCode' => '32746',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Gated neighborhoods', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Golf courses', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational facilities', 'value' => true ),
        ),
    );
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('heathrow');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
