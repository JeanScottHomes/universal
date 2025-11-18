<?php
# Reference:
# https://developer.yoast.com/customization/yoast-seo-premium/disabling-automatic-redirects-notifications/

# Disable automatic redirect creation
# Yoast SEO Premium monitors for URL changes and automatically creates a redirect. In most cases, this is ideal behavior in order to prevent visitors landing on a 404 error page. However, you can disable this feature by adding the following code to your theme's functions.php:

# Posts and pages
add_filter('Yoast\WP\SEO\post_redirect_slug_change', '__return_true');

# Taxonomies (categories, tags etc)
add_filter('Yoast\WP\SEO\term_redirect_slug_change', '__return_true');

# Disable redirect notifications
# When you delete content on your site, we display a reminder notification to add a redirect for the removed item. We highly recommend adding redirects for removed items. However, you can disable this feature by adding the following code to your theme's functions.php file. Please note that this only hides the notification message and so redirects may still be created silently behind the scenes.

# Posts or pages: Moved to Trash
add_filter('Yoast\WP\SEO\enable_notification_post_trash', '__return_false');

# Posts or pages: Changed URL
add_filter('Yoast\WP\SEO\enable_notification_post_slug_change', '__return_false');

# Taxonomies: Moved to Trash
add_filter('Yoast\WP\SEO\enable_notification_term_delete', '__return_false');

# Taxonomies: Changed URL
add_filter('Yoast\WP\SEO\enable_notification_term_slug_change', '__return_false');
