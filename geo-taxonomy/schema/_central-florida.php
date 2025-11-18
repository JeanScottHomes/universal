

<?php
echo '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@type" => "AdministrativeArea",
    "name" => "Central Florida",
    "alternateName" => "Orlando, Tampa Bay, and Daytona Beach Region",
    "description" => "Central Florida is a thriving tri-MSA region comprising Orlando–Kissimmee–Sanford, Tampa–St. Petersburg–Clearwater, and Daytona Beach–Deltona–Ormond Beach.",
    "geo" => [
        "@type" => "GeoCoordinates",
        "latitude" => 28.5383,
        "longitude" => -81.3792
    ],
    "hasPart" => [
        [
            "@type" => "City",
            "name" => "Orlando, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Winter Park, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Oviedo, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Lake Mary, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Windermere, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Sanford, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Tampa, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Clearwater, Florida"
        ],
        [
            "@type" => "City",
            "name" => "St. Petersburg, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Daytona Beach, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Ormond Beach, Florida"
        ],
        [
            "@type" => "City",
            "name" => "Deltona, Florida"
        ]
    ],
    "containedInPlace" => [
        [
            "@type" => "State",
            "name" => "Florida"
        ]
    ],
    "url" => "https://www.jeanscotthomes.com/central-florida/",
    "sourceOrganization" => [
        "@type" => "RealEstateAgent",
        "name" => "Jean Scott Homes",
        "url" => "https://www.jeanscotthomes.com"
    ],
    "sameAs" => [
        "https://www.jeanscotthomes.com/homes-listing-report/Central-Florida/2877151/",
        "https://www.jeanscotthomes.com/homes-open-houses/Central-Florida/2877151/",
        "https://www.jeanscotthomes.com/homes-market-report/Central-Florida/2877151/"
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
?>