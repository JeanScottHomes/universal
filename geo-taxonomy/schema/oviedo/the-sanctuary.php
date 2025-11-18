<?php
if (
    site_is_geo_taxonomy('the-sanctuary')
    || site_has_geo_term('the-sanctuary')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-The-Sanctuary/2887244',
        'homes-open-houses/Oviedo-Florida-s-The-Sanctuary/2887244',
        'homes-market-report/Oviedo-Florida-s-The-Sanctuary/2887244'
    ))
) {
    $canon = home_url('/central-florida/oviedo/the-sanctuary/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'The Sanctuary',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1T48EuUTAviqHetDX3U1QLPS7db7U6ho&usp=sharing',
        'description' => 'The Sanctuary is a master-planned community (PUD) featuring single-family homes, a clubhouse, and a community pool.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'geo' => array(
            '@type' => 'GeoShape',
            'polygon' => '28.6546093 -81.1665796 28.6519355 -81.156709 28.6541198 -81.1559366 28.6544963 -81.1535762 28.6510693 -81.1530183 28.6493745 -81.1472677 28.6512953 -81.1464952 28.6512953 -81.1431478 28.654534 -81.1415599 28.6563416 -81.1422466 28.6586388 -81.1413883 28.6599568 -81.1403422 28.661689 -81.1402403 28.6624045 -81.1408947 28.6627246 -81.1412595 28.6634401 -81.142032 28.6634212 -81.1545204 28.6615384 -81.1553357 28.6614254 -81.162331 28.6584505 -81.1661933 28.6546093 -81.1665796'
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Clubhouse', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Community pool', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'School',
                'name' => 'Walker Elementary School',
                'url' => 'https://www.walker.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '3101 Snow Hill Rd',
                    'addressLocality' => 'Chuluota',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'School',
                'name' => 'Lawton Chiles Middle School',
                'url' => 'https://www.lcms.scps.k12.fl.us/',
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
                'url' => 'https://www.hagertyhigh.scps.k12.fl.us/',
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
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
