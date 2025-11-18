<?php

/**
 * 🔹 TJS 09/15/25 – Admin Accessibility Styles
 * Improves readability of plugin admin tables (e.g. Redirection).
 * Forces darker text and link colors for better contrast.
 */

function admin_cp_accessibility_styles()
{
    echo '<style>
        /* Target links inside Redirection plugin */
        #redirection-admin a,
        #redirection-admin a:link,
        #redirection-admin a:visited,
        #redirection-admin a:hover,
        #redirection-admin a:active {
            color: #000000 !important;
            text-decoration: none !important;
        }

        /* Override WP table link styles */
        .widefat a,
        .wp-list-table a {
            color: #000000 !important;
            text-decoration: none !important;
        }

        /* Ensure table text is readable */
        .widefat td, .widefat th {
            color: #000000 !important;
        }

        /* Prevent hover styles from reverting color */
        .widefat a:hover, .wp-list-table a:hover {
            color: #000000 !important;
        }
    </style>';
}
add_action('admin_head', 'admin_cp_accessibility_styles');
