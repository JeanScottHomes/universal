<?php // Check if Featured Image is set. If set, nothing, if not set, then add Page Tile in H1 tag
    if ( has_post_thumbnail( $post_id ) ) {
      // Do nothing as the H1 Tag is included in the Page Banner
    } else {
      // Add the page title
      echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
    }
?>
<div class="gen_main_cw 111">
  <div class="gen_main_c">
    <?php // Show Gallery or Single Picture
        if ($thegallerynumber != '' || $thumbnail != '' )  	// confirm a gallery or thumbnail ID has been defined
        { ?>
        <div class="gen_results_img_large">
                    <?php if ($thegallerynumber != '') {
              echo do_shortcode('[ngg_images gallery_ids=' . $thegallerynumber . ' display_type=idxc ngg_triggers_display=always template=idxc]');
              } else { 
              echo '<img class="ngg-singlepic" src="';
              echo do_shortcode('[singlepic id=' . $thumbnail . ' w=' . $image_width . ' h=' . $image_height . ' crop=1 float= display_view="custom/idxcimgonly-view.php" quality=60 ]');
              echo '" alt="'.get_the_title().'" width="'.$image_width.'"/>';
             }
           ?>                         
                      <!--<?php if (strtolower($status) != 'active' && $status != '') { ?><div class="gen_status_large_status"><?php if ($status_other != '') { echo $status_other; } else { echo $status;} ?></div><?php } ?>-->
          <?php if (!empty($feature_label)) { echo '<div class="gen_status_large_status">' . $feature_label . '</div>'; } ?>
        </div>
    <?php } ?>
    <?php the_content(__('Read more'));?>
  </div>
</div>
<div class="gen_main_cw">
  <div class="gen_main_c">
    <h2>Property Details</h2>
    <div id="pd_mapspec_cont">
              <div id="pd_specs">
                  <div class="one-half first">
          <?php if ($price != '' && $price_sold !='') { 
            echo "<s><strong>Price:</strong> $" . number_format(intval($price), 0, '', ',') . "</s><br /><strong>SOLD:</strong> $" . number_format(intval($price_sold), 0, '', ',') . "<br /> ";
          } elseif ($price != '') {
            echo "<strong>Price:</strong> $" . number_format(intval($price), 0, '', ',') . "<br /> ";
          } ?>
          <?php if (!empty($address)) { echo "<strong>Address:</strong> " . $address . "<br />";} ?>					
          <?php if (!empty($city)) { echo "<strong>City:</strong> " . $city . "<br />";} ?>
          <?php if (!empty($state)) { echo "<strong>State:</strong> " . $state . "<br />";} ?>
          <?php if (!empty($zip)) { echo "<strong>Zip:</strong> " . $zip . "<br />";} ?>
          <?php if (!empty($mlsnumber)) { echo "<strong>MLS#:</strong> " . $mlsnumber . "<br />";} ?>						
                  </div>				
                  <div class="one-half">
          <?php if (!empty($beds)) { echo "<strong>Beds:</strong> " . $beds . "<br />";} ?>
          <?php if (!empty($baths)) { echo "<strong>Baths:</strong> " . $baths . "<br />";} ?>
          <?php if (!empty($sqft)) { echo "<strong>Square Feet:</strong> " . $sqft . "<br />";} ?>
          <?php if (!empty($garage)) { echo "<strong>Garage:</strong> " . $garage . "<br />";} ?>
          <?php if (!empty($yearbuilt)) { echo "<strong>Year Built:</strong> " . $yearbuilt . "<br />";} ?>
          <?php if (!empty($status)) { echo "<strong>Status:</strong> " . $status . "<br />";} ?>
                  </div>

              </div>
              <?php if ($address != '' && $zip != '') { ?>
              <div id="pd_gmap">
                  <iframe title="Map to property listed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo str_replace(" ", "+", $address) ; ?>+<?php echo $zip ; ?>&amp;ie=UTF8&amp;z=14&iwloc=near&addr&amp;output=embed"></iframe>
              </div>
              <?php } ?>
              <div class="clearfix"></div>

              <div id="pd_contact_us" class="pd_outer_wrap">
                  <h2>Contact us about this property.</h2>
                  <?php echo do_shortcode('[gravityform id=3 title=false description=false ajax=true]'); ?>
              </div>


    </div>
  </div>
</div>