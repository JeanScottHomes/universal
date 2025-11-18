<?php

// 🔹 TJS 09/16/2025 — Schema loads on geo page + Optima Express virtual pages for Altamonte Springs

// Only output on the Altamonte Springs geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('altamonte-springs')
    || site_has_geo_term('altamonte-springs')
    || is_page(array(
        'homes-listing-report/Altamonte-Springs-Florida/2900168',
        'homes-open-houses/Altamonte-Springs-Florida/2900168',
        'homes-market-report/Altamonte-Springs-Florida/2900168'
    ))
) {
    $canon = home_url('/central-florida/altamonte-springs/');
    $map = 'https://www.google.com/maps/d/viewer?mid=1H8LRFCXLPLuDCRuScbQsk1H_LryKJPw&usp=sharing';
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'City',
        '@id' => trailingslashit($canon) . '#city',
        'name' => 'Altamonte Springs',
        'description' => 'Altamonte Springs is a dynamic and modern city located in Seminole County, Florida. Part of the Orlando Metropolitan Area, it is known for its vibrant urban atmosphere, excellent shopping and dining options, and family-friendly amenities. With its strategic location and blend of residential, commercial, and recreational spaces, Altamonte Springs has become a popular destination for residents and visitors alike.',
        'url' => $canon,
        'hasMap' => $map,
        'sameAs' => array(
            'https://www.altamonte.org/',
            'https://en.wikipedia.org/wiki/Altamonte_Springs,_Florida',
            'https://www.tripadvisor.com/Tourism-g29161-Altamonte_Springs_Florida-Vacations.html',
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Altamonte Springs',
            'addressRegion' => 'FL',
            'postalCode' => '32701',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Vibrant urban atmosphere', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Excellent shopping and dining', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Family-friendly amenities', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational spaces', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lake Orienta Elementary School',
                'url' => 'https://lakeorienta.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '612 Newport Ave',
                    'addressLocality' => 'Altamonte Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => '32701',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Teague Middle School',
                'url' => 'https://teague.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '1350 McNeil Rd',
                    'addressLocality' => 'Altamonte Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => '32714',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Lake Brantley High School',
                'url' => 'https://www.lakebrantley.com/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '991 Sand Lake Rd',
                    'addressLocality' => 'Altamonte Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => '32714',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );

    // Inject GeoShape polygon if available
    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('altamonte-springs');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
