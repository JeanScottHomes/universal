<?php
// 🔹 TJS — Schema for Stone Hedge, Orlando

if (
    site_is_geo_taxonomy('stone-hedge')
    || site_has_geo_term('stone-hedge')
) {
    $canon = home_url('/central-florida/orlando/stone-hedge/');
    $data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Neighborhood',
        '@id' => trailingslashit($canon) . '#place',
        'name' => 'Stone Hedge',
        'url' => $canon,
        'hasMap' => 'https://www.google.com/maps/d/viewer?mid=1ItrlC35w3fTf7rQvPln1mwT8Zqg_uO0&usp=sharing',
        'description' => 'Stone Hedge is a charming residential community known for its well-maintained homes, tree-lined streets, and a family-friendly atmosphere. The neighborhood is well-regarded for its welcoming community vibe and its proximity to major roadways, making it an attractive choice for families and professionals seeking a quiet yet connected place to live in the Orlando area.',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Orlando',
            'addressRegion' => 'FL',
            'postalCode' => '32817',
            'addressCountry' => 'US',
        ),
        'amenityFeature' => array(
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Shopping Centers', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Dining Options', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Parks', 'value' => true ),
            array( '@type' => 'LocationFeatureSpecification', 'name' => 'Recreational Facilities', 'value' => true ),
        ),
        'containsPlace' => array(
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Riverdale Elementary School',
                'url' => 'https://riverdalees.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32817',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'Corner Lake Middle School',
                'url' => 'https://cornerlakems.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32820',
                    'addressCountry' => 'US',
                ),
            ),
            array(
                '@type' => 'EducationalOrganization',
                'name' => 'University High School',
                'url' => 'https://universityhs.ocps.net/',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Orlando',
                    'addressRegion' => 'FL',
                    'postalCode' => '32817',
                    'addressCountry' => 'US',
                ),
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}
?>
