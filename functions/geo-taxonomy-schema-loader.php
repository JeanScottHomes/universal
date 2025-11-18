<?php
/**
 * Geo Taxonomy Schema Loader
 * Automatically includes schema files based on geo term slugs.
 * 🔹 TJS 09/15/25
 *
 * ⚠️ Note: WP requires slugs to be unique across the entire taxonomy.
 * Nested terms with the same name (e.g., /oviedo/oak-forest and /kissimmee/oak-forest)
 * will be forced to use suffixes like -2. 
 * Future consideration: namespace slugs with parent city (e.g., oak-forest-oviedo).
 */

add_action( 'wp_head', function () {
    // Helper: include schema file by slug (searches root and subfolders)
    $include_for_slug = function ( $slug ) {
        static $included = array();
        if ( ! $slug || isset( $included[ $slug ] ) ) {
            return false;
        }

        // Prefer new schema directory; fall back to legacy path for safety
        $base_new = get_stylesheet_directory() . '/geo-taxonomy/schema';
        $base_legacy = get_stylesheet_directory() . '/geo-taxonomy-schema';
        $base = is_dir($base_new) ? $base_new : $base_legacy;

        // Prefer direct root matches first
        $candidates = array(
            $base . "/{$slug}.php",
            $base . "/_{$slug}.php",
        );

        $found = '';
        foreach ( $candidates as $path ) {
            if ( file_exists( $path ) ) {
                $found = $path;
                break;
            }
        }

        // Fallback: search subdirectories recursively for {slug}.php or _{slug}.php
        if ( ! $found && class_exists( 'RecursiveDirectoryIterator' ) ) {
            try {
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator( $base, FilesystemIterator::SKIP_DOTS )
                );
                foreach ( $iterator as $fileinfo ) {
                    if ( $fileinfo->isFile() ) {
                        $name = $fileinfo->getFilename();
                        if ( $name === $slug . '.php' || $name === '_' . $slug . '.php' ) {
                            $found = $fileinfo->getPathname();
                            break;
                        }
                        // Also allow fuzzy match: normalize filename to slug form
                        $basename = preg_replace( '/\.php$/i', '', $name );
                        $normalized = strtolower( preg_replace( '/[^a-z0-9]+/i', '-', $basename ) );
                        $normalized = trim( preg_replace( '/-+/', '-', $normalized ), '-' );
                        if ( $normalized === $slug || $normalized === '_' . $slug ) {
                            $found = $fileinfo->getPathname();
                            break;
                        }
                    }
                }
            } catch ( Exception $e ) {
                // Silently ignore iterator errors
            }
        }

        if ( $found ) {
            $included[ $slug ] = true;
            include $found;
            return true;
        }
        return false;
    };

    // 1) Taxonomy archives: /geo/... and children
    if ( site_is_geo_taxonomy() ) {
        $term = get_queried_object();
        if ( isset( $term->slug ) ) {
            $include_for_slug( $term->slug );
        }
    }

    // 2) Singular content with a "geo" term: include the most specific (child) term if present
    if ( is_singular() ) {
        $post_id = get_queried_object_id();
        if ( $post_id ) {
            $terms = get_the_terms( $post_id, 'geo_taxonomy' );
            if ( $terms && ! is_wp_error( $terms ) ) {
                // Prefer deepest term (child of another)
                usort( $terms, function ( $a, $b ) {
                    $a_depth = $a->parent ? 1 : 0;
                    $b_depth = $b->parent ? 1 : 0;
                    // If both have same depth, fall back to name for stability
                    if ( $a_depth === $b_depth ) {
                        return strcasecmp( $a->name, $b->name );
                    }
                    return $b_depth - $a_depth; // child first
                } );
                $include_for_slug( $terms[0]->slug );
            }
        }
    }

    // Note: Optima Express virtual pages are handled within individual schema files
    // via per-page `is_page([...])` checks placed alongside geo taxonomy checks.
});
