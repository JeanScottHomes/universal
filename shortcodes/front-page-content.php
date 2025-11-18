<?php

/**
 * ==================================================
 * Front Page Content Shortcode: [front_page_content]
 * ==================================================
 */

// Override the homepage hero poster image so the shortcode can control it
add_filter('cmb2_override_option_get_md_main_options', function ($override, $default, $cmb_option) {
  if (!is_front_page() || !is_object($cmb_option)) {
    return $override;
  }

  if ('cmb2_no_override_option_get' !== $override && !is_array($override)) {
    return $override;
  }

  $options = 'cmb2_no_override_option_get' === $override
    ? get_option($cmb_option->key, is_array($default) ? $default : array())
    : (array) $override;

  $options['video_banner'] = get_stylesheet_directory_uri() . '/images/Palm-Trees-in-Central-Florida.jpg';

  return $options;
}, 10, 3);

function front_page_content_shortcode()
{
  // 🕵️ Debug Sniffer: Log when front-sitewide-page-content.php runs
  // error_log("🐾 front-sitewide-page-content.php [front_page_content_shortcode] executed at " . date('Y-m-d H:i:s'));
  ob_start();
?>
  <!-- FRONT PAGE CONTENT START -->

  <!-- Creates space between the first section and the header or section above -->
  <div class="wrap" style="height: 1rem;"></div>

  <!-- Front Page Section 1a: Introduction -->

  <!-- Front Page Primary Heading -->
  <div class="front-page-heading front-page-heading--hero">
    <h1 style="margin: 0;">Central Florida Living</h1>
    <p class="front-page-heading__subtitle">Lifestyle, Communities, &amp; Homes for Sale</p>
  </div>

  <div class="front-page-wrap">

    <!-- ✅ Heading comes first, outside flex block -->
    <!-- Commenting out. H1 Added. Do we need both? TJS 09/26/25
      <div class="front-page-heading">
        <h2 style="margin: 0;"><span>Welcome to</span>Central Florida Living
        </h2>
      </div>
    -->

    <!-- Image on the left -->
    <div class="front-page-block front-page-block--image-left">

      <div class="signature-image-container">
        <img class="signature-image"
          src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/Daytona-Beach-Florida-at-Sunrise-400x225.jpg'); ?>"
          alt="Sunrise Over Daytona Beach, Florida" width="400" height="225" />

        <div class="signature-image__caption">
          Sunrise Over Daytona Beach, Florida
        </div>
      </div>

      <!-- Text and Button on the right -->
      <div class="front-page-text">
        <p>
          Life in Central Florida is more than sunshine and palm trees — it’s a way of living. The great weather, world
          class attractions, excellent roads and ammenities, and low crime and taxes, all make Central Florida, from Tampa
          Bay to Daytona Beach, a great place to live and work
        </p>
        <p>
          Whether you’re relocating for opportunity, retiring for lifestyle, or just ready for something new, Central
          Florida Living helps you find a great home and community that you can enjoy year round. We know the
          neighborhoods, the hidden gems, and the little things that make living here unforgettable.
        </p>
        <p>
          This is your place for local insights, market trends, and real stories — all designed to help you make confident
          decisions and feel at home faster.
        </p>

      </div>
    </div>
  </div>
  <!-- End of Section 1a -->

  <!-- Front Page Section 1b: Image Right, Text Left -->
  <div class="front-page-wrap">

    <!-- ✅ Heading comes first, outside flex block -->
    <div class="front-page-heading">
      <h2 style="margin: 0;"><span>Discover The</span> Central Florida Lifestyle</h2>
    </div>

    <!-- ✅ Image Right -->
    <div class="front-page-block front-page-block--image-right">
      <div class="signature-image-container">
        <img class="signature-image"
          src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/Sunset-Over-Lake-Eola-Downtown-Orlando-Florida-400x225.jpg'); ?>"
          alt="Sunset Over Lake Eola, Downtown Orlando, Florida" width="400" height="225" />
        <div class="signature-image__caption">
          Sunset Over Lake Eola, Downtown Orlando, Florida
        </div>
      </div>

      <!-- Text left -->
      <div class="front-page-text">
        <p>
          Enjoy life where every day feels like a vacation. Experience the magic of Disney World in Orlando, the thrills
          of Busch Gardens in Tampa Bay, and fun in the sun at the World's Most Famous, Daytona Beach, all in your own
          back yard. Central Florida puts world-class attractions within easy reach, offering fun and adventure for every
          age and interest.
        </p>
        <p>
          Step into nature with spring-fed rivers, crystal-clear lakes, and scenic parks that invite you to hike, paddle,
          or simply relax. With year-round sunshine and mild winters, outdoor living is a way of life — whether you're
          hosting backyard barbecues or taking sunset strolls.
        </p>
        <p>
          Beyond the beauty, Central Florida keeps you connected to what matters most. Access top-ranked hospitals,
          renowned universities, and fast-growing industries — all while living in communities that match your pace, from
          vibrant downtowns to quiet, family-friendly neighborhoods.
        </p>
        <p>
          Whether you're buying your first home, relocating your family, or retiring in style,
          <a href="/central-florida/">Central Florida</a> is where lifestyle meets
          opportunity. At <a href="/about-us/">Jean Scott Homes</a>, we don’t just know the neighborhoods — we live them.
          Let’s find the place that fits your life and call home.
        </p>
      </div>
    </div>


    <!-- ✅ Centered Button Outside the Text Block -->
    <div class="button-link-sitewide-wrap">
      <a href="/central-florida/" class="button-link-sitewide">
        More About Central Florida
      </a>
    </div>
  </div>

  <!-- End of Section 1b -->

  <?php

  /**
   * ==============================
   * 2. Front Page Featured Cities
   * ==============================
   */

  /* Get most-viewed city in the "front-page-city" category */
  $top_city = new WP_Query([
    'post_type' => 'page',
    'posts_per_page' => 1,
    'orderby' => 'meta_value_num',
    'meta_key' => 'post_views_number',
    'order' => 'DESC',
    'tax_query' => [
      [
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => 'home-page-city',
      ]
    ],
  ]);

  if ($top_city->have_posts()):
    while ($top_city->have_posts()):
      $top_city->the_post();
      $city_title = get_the_title();
      $city_url = get_permalink();
      $city_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
      $seo_title = get_post_meta(get_the_ID(), '_yoast_wpseo_title', true);
      $caption = $seo_title ?: $city_title;
    endwhile;
    wp_reset_postdata();
  endif;
  ?>

  <!-- Creates space between the first section and the header or section above -->
  <div class="wrap" style="height: 1rem;"></div>

  <div class="wrap" style="height: 1rem;"></div>
  <!-- Creates space between the first section and the header or section above -->

  <!-- Front Page Section 2a: Cities -->
  <div class="front-page-wrap">

    <!-- ✅ Heading comes first, outside flex block -->
    <div class="front-page-heading">
      <h2 style="margin: 0;"><span>Showcasing</span>Central Florida Cities</h2>
    </div>

    <!-- Most Viewed City Image Left -->

    <div class="front-page-block front-page-block--image-left">

      <div class="signature-image-container">
        <a href="<?php echo esc_url($city_url); ?>">

          <div class="signature-image-heading">
            <h3>Most Popular City</h3>
          </div>

          <?php if (empty($caption)) {
            echo ' ';
          } ?>

          <img class="signature-image" src="<?php echo esc_url($city_img); ?>"
            alt="<?php echo esc_attr(strip_tags($caption)); ?>" width="400" height="225" />

          <div class="signature-image__caption">
            <?php echo wp_kses_post(nl2br($caption)); ?>
          </div>
        </a>
      </div>

      <!-- Description -->
      <div class="front-page-text">
        <p>Life in Central Florida is more than sunshine and palm trees — it’s a way of living. From sunrise strolls on
          Daytona Beach to vibrant nights in downtown Orlando, each corner of this region offers its own rhythm and charm.
        </p>
        <p>
          Whether you’re drawn to historic towns, modern master-planned communities, or vibrant city centers, you’ll find
          a place that feels like home.
        </p>
        <p>
          These are some of the most popular cities in the Orlando metro area — each with its own personality, lifestyle,
          and local flavor. (The Tampa Bay and Daytona Beach areas are on our roadmap). Start exploring to find the city
          and community that fits your lifestyle!
        </p>
      </div>
    </div>

    <!-- Front Page Section 2b: More Central Florida Cities -->
    <div class="front-page-wrap">

      <!-- ✅ Heading comes first, outside flex block -->
      <div class="front-page-heading">
        <h2><span>More Popular Cities</span></h2>
      </div>

      <!-- Grid of Next 8 Cities -->
      <!-- TODO (Priority B): Revisit AJAX/carousel implementation for cities grid.
           Temporarily disabling AJAX/carousel for stability and design polish. -->
      <?php echo do_shortcode('[sitewide_grid category="home-page-city" number="8" offset="1" sort="views"]'); ?>
      <!-- End Grid of Listings -->

      <!-- ✅ Centered Button Full Width -->
      <div class="button-link-sitewide-wrap">
        <a href="/central-florida-cities/#central-florida-cities" class="button-link-sitewide">
          More Central Florida Cities
        </a>
      </div>

      <?php

      /**
       * ================================
       * 3. Front Page Featured Listings
       * ================================
       */

      /**
       * Pull image of the most recent listing
       */

      $latest_listing = new WP_Query([
        'post_type' => 'idxc_featlist',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
      ]);

      if ($latest_listing->have_posts()):
        while ($latest_listing->have_posts()):
          $latest_listing->the_post();
          $title = get_the_title();
          $url = get_permalink();
          $img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          $seo_title = get_post_meta(get_the_ID(), '_yoast_wpseo_title', true); // Yoast SEO title (falls back to post title)
          $caption = $seo_title ?: $title;
        endwhile;
        wp_reset_postdata();
      endif;
      ?>

      <!-- Creates space between the first section and the header or section above -->
      <div class="wrap" style="height: 1rem;"></div>

      <!-- Front Page Section 3a: Featured Listings -->
      <div class="front-page-wrap">

        <!-- ✅ Heading comes first, outside flex block -->
        <div class="front-page-heading">
          <h2><span>Showcasing Our</span>Featured Listings</h2>
        </div>

        <!-- Most Recent Listing: Image Right-->

        <div class="front-page-block front-page-block--image-right">

          <div class="signature-image-container">
            <a href="<?php echo esc_url($url); ?>">

              <div class="signature-image-heading">
                <h3>Our Newest Listing</h3>
              </div>

              <?php if (empty($caption)) {
                echo ' ';
              } ?>

              <img class="signature-image" src="<?php echo esc_url($img); ?>"
                alt="<?php echo esc_attr(strip_tags($caption)); ?>" width="400" height="225" />

              <div class="signature-image__caption">
                <?php echo wp_kses_post(nl2br($caption)); ?>
              </div>
            </a>
          </div>

          <!-- Description -->
          <div class="front-page-text">

            <p>
              Jean Scott Homes showcases some of the best-presented homes for sale in
              <a href="/central-florida/">Central Florida</a>.
              From Oviedo’s Live Oak Reserve to Waterford Lakes and Windermere, our featured listings reflect the quality
              and care our team brings to every sale.
            </p>

            <p>
              Since 2007, Jean and her team have <a href="/featured-listings/">listed and sold</a> over 650 properties.
              We combine expert marketing, thoughtful staging, and decades of experience to help you get results.
            </p>

            <p>
              With more than 200 <a href="/about-us/past-clients-reviews/">five-star Google reviews</a>, we’ve built a
              reputation for professionalism, integrity, and a personal touch.
              Whether you're buying or selling, you’ll feel the difference with Jean Scott Homes.
            </p>
          </div>
        </div>

        <!-- Front Page Section 3b: Next 6 Listings -->

        <!-- ✅ Heading comes first, outside flex block -->
        <div class="front-page-heading">
          <h2><span>More Recent Listings</span></h2>
        </div>

        <!-- Grid of Next 8 Listings -->
        <?php echo do_shortcode('[sitewide_grid post_types="idxc_featlist" number="24" offset="1" sort="date" show_pagination="yes"]'); ?>
        <!-- End Grid of Listings -->

        <!-- ✅ Centered Button Full Width -->
        <div class="button-link-sitewide-wrap" style="/* display:flex; justify-content:center; */">
          <a href="/featured-listings/page/2/" class="button-link-sitewide">
            See All 650-Plus Listings Sold
          </a>
        </div>
        <!-- FRONT PAGE CONTENT END -->

      <?php
      // 🕵️ Debug Sniffer: Log before return
      // error_log("🐾 front-sitewide-page-content.php completed rendering front_page_content_shortcode at " . date('Y-m-d H:i:s'));
      return ob_get_clean();
    }
    if (function_exists('add_shortcode')) {
      add_shortcode('front_page_content', 'front_page_content_shortcode');
    }
