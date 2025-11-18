<?php

/**
 * 🔹 TJS 09/15/25 – Smooth Scroll
 * Moved from WPCode to /universal/functions/smooth-scroll.php
 *
 * Adds global CSS for smooth scrolling.
 */

if (! function_exists('jsh_add_smooth_scroll')) {
    function jsh_add_smooth_scroll()
    {
        echo '<style>html { scroll-behavior: smooth; }</style>';
    }
    add_action('wp_head', 'jsh_add_smooth_scroll');
}
