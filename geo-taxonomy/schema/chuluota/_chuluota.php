<?php
/**
 * Schema for Chuluota, FL
 * Perfect per Google Schema Checker
 * 09/15/25 TJS
 */

// Only output on the Chuluota geo tag archive, posts with that term, or specific Optima Express pages
if (
    site_is_geo_taxonomy('chuluota')
    || site_has_geo_term('chuluota')
    || is_page(array(
        'homes-listing-report/Chuluota-Florida/2877191',
        'homes-open-houses/Chuluota-Florida/2877191',
        'homes-market-report/Chuluota-Florida/2877191'
    ))
) {
    $canon = home_url('/central-florida/chuluota/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Place',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Chuluota',
        'description' => 'Chuluota is an unincorporated area in Seminole County, Florida, offering a charming blend of rural living and access to nature. With its lush green landscape, quiet country atmosphere, and proximity to Orlando and Oviedo, Chuluota is a hidden gem for those looking to escape the city. The area is known for its wildlife sanctuary, nature trails, airboat tours at Black Hammock, and beautiful public parks. Residents enjoy highly-rated Seminole County schools, including Walker Elementary, Lawton Chiles Middle, and Hagerty High School. Some schools zoned for Chuluota are located in the neighboring city of Oviedo.',
        'url' => $canon,
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Chuluota',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 28.6414,
            'longitude' => -81.1326,
        ),
        'containedInPlace' => array(
            '@type' => 'AdministrativeArea',
            'name' => 'Seminole County',
            'url' => 'https://www.seminolecountyfl.gov/',
        ),
        'sameAs' => array(
            'https://en.wikipedia.org/wiki/Chuluota,_Florida',
            'https://www.tripadvisor.com/Tourism-g34135-Chuluota_Florida-Vacations.html',
            'https://www.google.com/maps/place/Chuluota,+FL+32766/',
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Walker Elementary School',
                'url' => 'https://walker.scps.k12.fl.us/',
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
                '@type' => 'EducationalOrganization',
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
        $poly = geo_taxonomy_polygon('chuluota');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
