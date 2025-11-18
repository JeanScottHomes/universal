<?php
$home_lor = home_url('/central-florida/oviedo/live-oak-reserve/');
$home_oviedo = home_url('/central-florida/oviedo/');
$upload_baseurl = wp_get_upload_dir()['baseurl'];

if (
    site_is_geo_taxonomy('live-oak-reserve')
    || site_has_geo_term('live-oak-reserve')
    || is_page(array(
        'homes-listing-report/Oviedo-Florida-s-Live-Oak-Reserve/2880251',
        'homes-open-houses/Oviedo-Florida-s-Live-Oak-Reserve/2880251',
        'homes-market-report/Oviedo-Florida-s-Live-Oak-Reserve/2880251'
    ))
) {
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($home_lor) . '#place',
        'name' => 'Live Oak Reserve',
        'description' => 'Live Oak Reserve is a premier master-planned community in Oviedo, Florida, featuring luxury single-family homes with large lots and conservation or water views. The community offers a family-friendly lifestyle with amenities like a clubhouse with a pool, splash pad, fitness center, sports park, tennis, volleyball, and basketball courts, walking trails, and a dog park. Residents enjoy sightings of wildlife and have access to highly-rated schools and nearby shopping, dining, and entertainment. With homes typically ranging from 2,500 to 3,500 square feet and priced between $400,000 and $850,000, Live Oak Reserve also offers easy access to downtown Orlando, Kennedy Space Center, and beaches.',
        'url' => $home_lor,
        'additionalType' => 'https://en.wikipedia.org/wiki/Planned_unit_development',
        'image' => $upload_baseurl . '/2024/06/Main-Enterance.-Live-Oak-Reserve-Oviedo-Florida-768x432.jpg',
        // Use polygon per strategy: https://schema.org/GeoShape
        'geo' => array(
            '@type' => 'GeoShape',
            'polygon' => '28.6513965 -81.1548435 28.6355402 -81.1546719 28.6288354 -81.1525261 28.6273287 -81.1498654 28.627291 -81.142441 28.6298712 -81.1432349 28.6341842 -81.1426556 28.6339959 -81.1398661 28.6350882 -81.1391365 28.6408134 -81.1342442 28.6459733 -81.1344587 28.6473668 -81.1396944 28.6434875 -81.1421406 28.6432051 -81.1450159 28.6439395 -81.1478483 28.6495888 -81.1477196 28.6513965 -81.1548435'
        ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Oviedo',
            'addressRegion' => 'FL',
            'postalCode' => '32766',
            'addressCountry' => 'US',
        ),
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1skQTRv5oH4fvykB3wgR5OmrF-NrEAWA&hl=en',
        'containedInPlace' => array(
            '@type' => 'City',
            'name' => 'Oviedo',
            'url' => $home_oviedo,
            'geo' => array(
                '@type' => 'GeoCoordinates',
                'latitude' => 28.6713,
                'longitude' => -81.2081,
            ),
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Community Pool', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Giant Slide', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Splash Pad', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Fitness Center', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Sports Park', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Tennis Courts', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Volleyball Courts', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Basketball Courts', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Dog Park', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Large Field', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking/Biking Sidewalks', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Partin Elementary School',
                'url' => 'https://www.partin.scps.k12.fl.us/',
                'sameAs' => 'https://www.greatschools.org/florida/oviedo/2863-Partin-Elementary-School/',
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
                'name' => 'Lawton Chiles Middle School',
                'url' => 'https://lcms.scps.k12.fl.us/',
                'sameAs' => 'https://www.greatschools.org/florida/oviedo/5135-Chiles-Middle-School/',
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
                'url' => 'https://www.hagertyhigh.scps.k12.fl.us/',
                'sameAs' => 'https://www.greatschools.org/florida/oviedo/7692-Hagerty-High-School/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => '3225 Lockwood Blvd',
                    'addressLocality' => 'Oviedo',
                    'addressRegion' => 'FL',
                    'postalCode' => '32766',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
