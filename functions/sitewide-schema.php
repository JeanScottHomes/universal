<?php

/**
 * 🔹 TJS 09/15/25 – Homepage Schema Override
 * Moved from WPCode to /universal/functions/homepage-schema.php
 *
 * - Disables Yoast schema on the homepage.
 * - Outputs custom JSON-LD schema markup instead.
 */

/**
 * Disable Yoast schema on homepage
 */
add_filter('wpseo_json_ld_output', function ($data, $context = null) {
    if (is_front_page()) {
        return []; // disable only on homepage
    }
    return $data;
}, 10, 2);

/**
 * Add custom schema markup to homepage
 */
function jsh_homepage_schema_markup()
{
    if (! is_front_page()) {
        return;
    }
?>
    <!-- begin Jean Scott Homes Homepage Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": ["RealEstateAgent", "LocalBusiness"],
            "@id": "<?php echo home_url('/'); ?>",
            "url": "<?php echo home_url('/'); ?>",
            "name": "Jean Scott Homes, REALTORS\u00AE at Keller Williams Advantage Realty",
            "alternateName": [
                "Jean Scott Homes",
                "Jean Scott, Realtor",
                "Jean Scott, Keller Williams Advantage Realty",
                "Jean Scott, REALTOR\u00AE at Keller Williams Advantage Realty",
                "Jean Scott, Orlando, Florida Real Estate Agent",
                "Jean Scott"
            ],
            "logo": "<?php echo wp_get_upload_dir()['baseurl']; ?>/Jean-Scott-Homes-Logo.jpg",
            "image": [
                "<?php echo wp_get_upload_dir()['baseurl']; ?>/Jean-Scott-Homes-Logo.jpg",
                "<?php echo wp_get_upload_dir()['baseurl']; ?>/2023/03/Jean-1-e1746699567397-639x800.webp"
            ],
            "description": "Discover Central Florida cities and communities at JeanScottHomes.com, the premier destination for homebuyers exploring Orlando, Florida, its surrounding areas, and homes for sale. Find detailed community insights, the latest home listings, and meet the trusted team behind Jean Scott Homes.",
            "legalName": "Jean Ann Scott LLC",
            "foundingDate": "2007-03-10",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "59 Alafaya Woods Blvd",
                "addressLocality": "Oviedo",
                "addressRegion": "FL",
                "postalCode": "32765",
                "addressCountry": "US"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": 28.651666624922225,
                "longitude": -81.20496534092521
            },
            "hasMap": "https://maps.app.goo.gl/jpTch36J8GRZ2nxJ9",
            "priceRange": "$250,000 - $5,000,000",
            "telephone": "+1-407-564-2758",
            "email": "clientcare@jeanscotthomes.com",
            "openingHoursSpecification": [{
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                    "opens": "08:00",
                    "closes": "18:00"
                },
                {
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": "Saturday",
                    "opens": "09:00",
                    "closes": "17:00"
                },
                {
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": "Sunday",
                    "opens": "10:00",
                    "closes": "16:00"
                }
            ],
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer service",
                "telephone": "+1-407-564-2758",
                "email": "clientcare@jeanscotthomes.com",
                "areaServed": "US",
                "availableLanguage": ["English", "Spanish"]
            },
            "founder": {
                "@type": "Person",
                "name": "Jean Scott",
                "jobTitle": "Lead Realtor",
                "sameAs": [
                    "https://www.linkedin.com/in/jeanscottrealtor/",
                    "https://www.kw.com/agent/JeanScott",
                    "<?php echo home_url('/about-us/realtors-staff/jean-scott-realtor-crs/'); ?>"
                ]
            },
            "member": [{
                    "@type": "Person",
                    "name": "Joann Harbour",
                    "jobTitle": "Realtor"
                },
                {
                    "@type": "Person",
                    "name": "Rachel Gregory",
                    "jobTitle": "Realtor"
                },
                {
                    "@type": "Person",
                    "name": "Thomas Scott",
                    "jobTitle": "Realtor"
                },
                {
                    "@type": "Person",
                    "name": "Ron Johnson",
                    "jobTitle": "Realtor"
                }
            ],
            "areaServed": [{
                    "@type": "City",
                    "name": "Baldwin Park",
                    "sameAs": "https://www.baldwinpark.com/"
                },
                {
                    "@type": "City",
                    "name": "Belle Isle",
                    "sameAs": "https://www.belleislefl.gov/"
                },
                {
                    "@type": "City",
                    "name": "Casselberry",
                    "sameAs": "https://www.casselberry.org/"
                },
                {
                    "@type": "City",
                    "name": "Chuluota",
                    "sameAs": "https://en.wikipedia.org/wiki/Chuluota,_Florida"
                },
                {
                    "@type": "City",
                    "name": "Heathrow",
                    "sameAs": "https://en.wikipedia.org/wiki/Heathrow,_Florida"
                },
                {
                    "@type": "City",
                    "name": "Lake Mary",
                    "sameAs": "https://www.lakemaryfl.com/"
                },
                {
                    "@type": "City",
                    "name": "Lake Nona",
                    "sameAs": "https://www.lakenona.com/"
                },
                {
                    "@type": "City",
                    "name": "Longwood",
                    "sameAs": "https://www.longwoodfl.org/"
                },
                {
                    "@type": "City",
                    "name": "Maitland",
                    "sameAs": "https://www.itsmymaitland.com/"
                },
                {
                    "@type": "City",
                    "name": "Orlando",
                    "sameAs": "https://www.orlando.gov/"
                },
                {
                    "@type": "City",
                    "name": "Oviedo",
                    "sameAs": "https://www.cityofoviedo.net/"
                },
                {
                    "@type": "City",
                    "name": "Sanford",
                    "sameAs": "https://www.sanfordfl.gov/"
                },
                {
                    "@type": "City",
                    "name": "Windermere",
                    "sameAs": "https://town.windermere.fl.us/"
                },
                {
                    "@type": "City",
                    "name": "Winter Park",
                    "sameAs": "https://cityofwinterpark.org/"
                },
                {
                    "@type": "City",
                    "name": "Winter Springs",
                    "sameAs": "https://www.winterspringsfl.org/"
                }
            ],
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "5.0",
                "reviewCount": "226"
            },
            "sameAs": [
                "https://www.facebook.com/JeanScottHomes/",
                "https://www.instagram.com/jeanscotthomes/",
                "https://www.youtube.com/@JeanScottHomes",
                "https://x.com/jeanscotthomes",
                "https://www.pinterest.com/JeanScottHomes/",
                "https://www.linkedin.com/in/jeanscottrealtor/",
                "https://www.yelp.com/biz/jean-scott-homes-realtors-at-keller-williams-advantage-realty-oviedo-2",
                "https://www.realtor.com/realestateagents/569d0c5b0fa417010073e3f9",
                "https://www.zillow.com/profile/JeanScottHomes",
                "https://goo.gl/maps/JVTUZEXQAKerMnmw5",
                "https://g.co/kgs/FXUm9WK"
            ]
        }
    </script>
    <!-- end Jean Scott Homes Homepage Schema -->
<?php
}
add_action('wp_head', 'jsh_homepage_schema_markup', 20);
