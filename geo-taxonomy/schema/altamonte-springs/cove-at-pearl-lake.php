<?php
if (
    site_is_geo_taxonomy('cove-at-pearl-lake')
    || site_has_geo_term('cove-at-pearl-lake')
) {
    $canon = home_url('/central-florida/altamonte-springs/cove-at-pearl-lake/');
    $map = 'https://www.google.com/maps/d/viewer?mid=1RHl0RJOmwZXa2wX-zlNXq7FsoKX1vKw&usp=sharing';
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'GatedResidenceCommunity',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Cove at Pearl Lake',
        'description' => 'Cove at Pearl Lake is a beautifully maintained, gated condominium community designed to offer a peaceful and secure environment. The condominiums typically include modern finishes, open floor plans, and private balconies or patios, making it a desirable spot for young professionals, families, and retirees.',
        'url' => $canon,
        'hasMap' => $map,
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Altamonte Springs',
            'addressRegion' => 'FL',
            'postalCode' => '32714',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Resort-style pool', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Clubhouse', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Fitness center', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Walking path and landscaped grounds', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'On-site parking', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Bear Lake Elementary School',
                'url' => 'https://bearlake.scps.k12.fl.us/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Apopka',
                    'addressRegion' => 'FL',
                    'postalCode' => '32703',
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

    if (function_exists('geo_taxonomy_polygon')) {
        $poly = geo_taxonomy_polygon('altamonte-springs', 'cove-at-pearl-lake');
        if ($poly) { $data['geo'] = array('@type' => 'GeoShape', 'polygon' => $poly); }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
