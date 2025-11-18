<?php
$home_oviedo = home_url('/central-florida/oviedo/');
$upload_baseurl = wp_get_upload_dir()['baseurl'];

if (
    site_is_geo_taxonomy('oviedo')
    || site_has_geo_term('oviedo')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida/2877198',
        'homes-open-houses/Oviedo-Florida/2877198',
        'homes-market-report/Oviedo-Florida/2877198'
    ))
) {
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($home_oviedo) . '#city',
        'name' => 'Oviedo',
        'url' => $home_oviedo,
        'description' => 'Oviedo, Florida, is known for its blend of small-town charm and modern conveniences. The city offers a rich history, scenic landscapes, and a strong sense of community. Surrounded by natural beauty, Oviedo provides access to parks, nature trails, and outdoor attractions such as the Little Big Econ State Forest and Lake Jesup, which are ideal for hiking, kayaking, and wildlife observation. The city features a vibrant housing market with a mix of Mediterranean, Ranch, and Contemporary homes, ranging from 1,500 to 3,500+ sq ft. Home prices typically range from the mid-$300Ks to $600K+, with some luxury estates exceeding $1M.',
        'containedInPlace' => array(
            '@type' => 'AdministrativeArea',
            'name' => 'Seminole County',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Seminole County',
                'addressRegion' => 'FL',
                'addressCountry' => 'US',
            ),
            'url' => 'https://www.seminolecountyfl.gov/',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.6542325,
            'longitude' => -81.2132511,
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32765',
            'addressCountry' => 'US',
        ),
        'sameAs' => array(
            'https://www.cityofoviedo.net/486/About-Oviedo',
            'https://www.tripadvisor.com/Tourism-g34521-Oviedo_Florida-Vacations.html',
        ),
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=18jC2U2ChnIoF1YlYpayHQoPxUx5duLY&usp=sharing',
        'image' => array(
            $upload_baseurl . '/2024/04/Oviedo-on-the-Park-768x432.jpg',
            $upload_baseurl . '/2023/12/2535-Westminster-Ter-Oviedo-FL-32765--scaled-768x432.jpg',
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
        $poly = geo_taxonomy_polygon('oviedo');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
