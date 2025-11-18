<?php

/**
 * Site / Theme Options (global variables)
 */
add_action( 'cmb2_admin_init', 'idxcto_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function idxcto_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'					=> 'md_main_options_page',
		'title'					=> esc_html__( 'Site Options', 'cmb2' ),
		'object_types'			=> array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'			=> 'md_main_options', // The option key and admin menu page slug.
		// 'icon_url'       	=> 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'     	=> esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		// 'parent_slug'    	=> 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'     	=> 'manage_options', // Cap required to view options-page.
		// 'position'       	=> 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook'	=> 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      	=> false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     	=> esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

	/*
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
    
	$cmb_options->add_field( array(
		'name'		=> __( 'First Name', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'first_name',
		'type'		=> 'text',
        'before_row'   => '<div class="cmb-row cmb-type-title"><h2 style="margin:10px 0;">Primary Fields</h2>The following fields will be displayed throughout your website in multiple places. When changes are made to these fields and saved, they are instantly updated throughout your website.<span class="setup_hidden"><br><br>The main places these fields are used will be the Website Header, Footer, Sidebar and Contact page. If you have any questions about how to change something please contact <a href="mailto:support@idxcentral.com">support@idxcentral.com</a> and include a link to the page / section you wish to make changes to.</span><br><br></div>',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Last Name', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'last_name',
		'type'		=> 'text',
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Title', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'title',
		'type'		=> 'text',
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Phone', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'phone_1',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Phone Label', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'phone_1_label',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Phone 2', 'cmb2' ),
		'desc'		=> __( 'Displayed on Contact page. (optional)', 'cmb2' ),
		'id'		=> 'phone_2',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Phone 2 Label', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'phone_2_label',
		'type'		=> 'text',
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Email', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'email',
		'type'		=> 'text_email',
	) );
	
	$cmb_options->add_field( array(
		'name'			=> __( 'DRE License #', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> 'license_number',
		'type'			=> 'text',
	) );
	

	$cmb_options->add_field( array(
		'name'		=> __( 'Office', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'office_name',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Address', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'office_address',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'City', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'office_city',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'State', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'office_state',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Zip', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'office_zip',
		'type'		=> 'text',
	) );
		    
    $cmb_options->add_field( array(
        'name'		=> __( 'Agent/Office Image', 'cmb2' ),
        'desc'    => 'Upload / Change image. Recommended size: 730 x 600 px.',
        'id'      => 'ao_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );
    
    $cmb_options->add_field( array(
        'name'		=> __( 'Logo', 'cmb2' ),
        'desc'    => 'Upload / Change image. Recommended max-width: 265 px.',
        'id'      => 'logo_main',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );    
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Facebook', 'cmb2' ),
		'id'		=> 'facebook_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
        'before_row'   => '<div class="cmb-row cmb-type-title"><h2 style="margin:10px 0;">Social Links</h2></div>',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Instagram', 'cmb2' ),
		'id'		=> 'instagram_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'LinkedIn', 'cmb2' ),
		'id'		=> 'linkedin_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Pinterest', 'cmb2' ),
		'id'		=> 'pinterest_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Snapchat', 'cmb2' ),
		'id'		=> 'snapchat_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Twitter / X', 'cmb2' ),
		'id'		=> 'twitter_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'YouTube', 'cmb2' ),
		'id'		=> 'youtube_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Vimeo', 'cmb2' ),
		'id'		=> 'vimeo_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'TikTok', 'cmb2' ),
		'id'		=> 'tiktok_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Phone Number', 'cmb2' ),
        'desc'		=> __( 'Phone number only - ex: (888) 577-8027. This will add the phone icon to your social icon section.', 'cmb2' ),
		'id'		=> 'phone_social',
		'type'		=> 'text',
	) );
	
	
	/*
	$cmb_options->add_field( array(
		'name'		=> __( 'Title Line 1', 'cmb2' ),
        'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'banner_title_line_1',
		'type'		=> 'text',
        'before_row'   => '<div class="cmb-row cmb-type-title"><h2 style="margin:10px 0;">Home Page Banner</h2></div>',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Title Line 2', 'cmb2' ),
        'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'banner_title_line_2',
		'type'		=> 'text',
	) );
	*/
	
	$cmb_options->add_field( array(
        'name' => __( 'Banner Images', 'cmb2' ),
        'desc' => __( 'Provide 1-3 or more primary images for your home page. Recommended size: 1920 x 1080 px.', 'cmb2' ),
        'id'   => 'banner_image_list',
        'type' => 'file_list',
        'preview_size' => array( 100, 75 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
		'before_row'   => '<div class="cmb-row cmb-type-title setup_hidden"><h2 style="margin:10px 0;">Home Page Banner</h2></div>',
    ) );
    
    /*
    $cmb_options->add_field( array(
		'name'		=> __( 'Title Line 1', 'cmb2' ),
        'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'banner_title_line_1',
		'type'		=> 'text',
	) );
    
    $cmb_options->add_field( array(
		'name'		=> __( 'Title Line 2', 'cmb2' ),
        'desc'		=> __( '', 'cmb2' ),
		'id'		=> 'banner_title_line_2',
		'type'		=> 'text',
	) );
    */
	
    
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Vimeo ID', 'cmb2' ),
        'desc'		=> __( 'If using video from Vimeo, input video ID here. Use either Vimeo OR YouTube but do not input a value in both! If you want to go back to rotating images, remove value from this field.', 'cmb2' ),
		'id'		=> 'vimeo_id',
		'type'		=> 'text',
		'before_row'   => '<div class="cmb-row xcmb-type-title setup_hidden"><h4 style="margin:0;">Video Banner (optional)</h4>These fields will be used if you wish to add a video banner to the home page.</div>',
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'YouTube ID', 'cmb2' ),
        'desc'		=> __( 'If using video from YouTube, input video ID here. Use either Vimeo OR YouTube but do not input a value in both! If you want to go back to rotating images, remove value from this field.', 'cmb2' ),
		'id'		=> 'youtube_id',
		'type'		=> 'text',
	) );
	
	 $cmb_options->add_field( array(
        'name' => __( 'Video Background Image', 'cmb2' ),
        'desc' => __( 'This image will show before the video loads', 'cmb2' ),
        'id'   => 'video_banner',
        'type'    => 'file',
        'preview_size' => array( 100, 75 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
    ) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Alt Text For Video Background Image', 'cmb2' ),
        'desc'		=> __( 'This will be the alt text for the video image', 'cmb2' ),
		'id'		=> 'video_alt',
		'type'		=> 'text',
	) );
	
	$cmb_options->add_field( array(
		'name'		=> __( 'Hide Video on Mobile Devices', 'cmb2' ),
        'desc'		=> __( 'To make your homepage load faster on smaller devices (screen width less than 1024px), this feature is enabled by default. Smaller devices will show the First image from the "Banner" images. To force video to display on smaller devices, turn this option off.', 'cmb2' ),
		'id'		=> 'video_option',
		'type'    => 'radio_inline',
        'options' => array(
            'on' => __( 'On', 'cmb2' ),
            'off'   => __( 'Off', 'cmb2' ),
        ),
        'default' => 'on',
	) );
    
    /*
	$cmb_options->add_field( array(
        'name'		=> __( 'Neighborhoods Image', 'cmb2' ),
        'desc'    => 'Home Page > Main image located in the Neighborhood section. Recommended size: 575 x 525 px.',
        'id'      => 'neighborhood_image_home',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
        'before_row'   => '<div class="cmb-row cmb-type-title setup_hidden"><h2 style="margin:10px 0;">Layout Options</h2></div>',
        
    ) );
    
    $cmb_options->add_field( array(
        'name'		=> __( 'Accent Image', 'cmb2' ),
        'desc'    => 'Home Page > Located in the "Get to Know" section.<br>Recommended size: 375 x 200 px.',
        'id'      => 'accent_image_home',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );
    */
	
    $cmb_options->add_field( array(
        'name'		=> __( 'Footer Background Image', 'cmb2' ),
        'desc'    => 'All Pages > Footer background image located behind Contact form. Ideally, reuse any image from banner to save load on time. Unique image recommended size: 1600 x 900 px.',
        'id'      => 'footer_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
		'before_row'   => '<div class="cmb-row cmb-type-title setup_hidden"><h2 style="margin:10px 0;">Layout Options</h2></div>',
    ) );
    
    $cmb_options->add_field( array(
        'name'		=> __( 'Interior Page Header Image', 'cmb2' ),
        'desc'    => 'Interior Pages > Header background image located behind primary navigation. Ideally, reuse any image from banner to save load on time.  Unique image recommended size: 1600 x 200 px.',
        'id'      => 'interior_header_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );
	
	$cmb_options->add_field( array(
        'name'		=> __( 'Contact Modal Background Image', 'cmb2' ),
        'desc'    => 'Contact modal window background image behind content. Unique image recommended size: 1920 x 1080 px.',
        'id'      => 'contact_modal_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );
	
	$cmb_options->add_field( array(
        'name'		=> __( 'Agent Profile Header Image', 'cmb2' ),
        'desc'    => 'Agent Profile pages > Header background image located behind primary navigation. Unique image recommended size: 1920 x 1080 px.',
        'id'      => 'agent_header_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => true, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Upload Image' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            // Only allow gif, jpg, or png images
            'type' => array(
            'image/gif',
            'image/jpeg',
            'image/png',
            ),
	   ),
	   'preview_size' => array( 200, 115 ), // Image size to use when previewing in the admin.
    ) );

    /*
    $cmb_options->add_field( array(
        'name' => __( 'Homepage Banner', 'cmb2' ),
        'desc' => __( '', 'cmb2' ),
        'id'   => 'homepage_banner_height',
        'type'    => 'radio_inline',
        'options' => array(
            'fixed' => __( 'Fixed Height', 'cmb2' ),
            'fullscreen'   => __( 'Fullscreen', 'cmb2' ),
        ),
        'default' => 'fixed',
    ) );
    */
    
    $cmb_options->add_field( array(
        'name' => __( 'Neighborhood Results', 'cmb2' ),
        'desc' => __( '', 'cmb2' ),
        'id'   => 'neighborhood_results',
        'type'    => 'radio_inline',
        'options' => array(
            'text' => __( 'Text', 'cmb2' ),
            'images'   => __( 'Images', 'cmb2' ),
        ),
        'default' => 'text',
    ) );
    
    //
    // Registers Set-up Questions page, and identifies Site Options as parent.
    //
	$questions_options = new_cmb2_box( array(
		'id'           => 'md_initial_setup_options_page',
		'title'        => esc_html__( 'Setup Questions', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'md_questions_options',
		'parent_slug'  => 'md_main_options',
	) );
    // Fields
    $questions_options->add_field( array(
		'name'		=> __( 'Featured Listings', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
        'id'		=> 'q_featured_listings',
		'type'             => 'radio',
        'show_option_none' => false,
        'options'          => array(     
            'manually'          => __( 'I wish to manually enter listing details and upload images (greater control/more work)', 'cmb2' ),
            'agent_id'          => __( 'Display listings based on my agent ID(s)', 'cmb2' ),
            'office_id'         => __( 'Display listings based on your office ID (iHomefinder solution only)', 'cmb2' ),
            'manually_mls_ids'  => __( 'Manually enter &amp; maintain a list of MLS numbers so you can pick the specific listings you want to show up.', 'cmb2' ),
            'special_criteria'  => __( 'Specific criteria: See sample details below and enter your criteria.', 'cmb2' ),
        ),
        'before_field'   => '<span style="padding-top:5px; display:block;">Select how you would prefer to identify your featured listings (manually vs automatic). If you wish to manually upload your own listing photos and details, we will train you on how to use this section.<span><br><br>',
        'before_row'     => '<div class="cmb-row cmb-type-title" style="padding-bottom:10px;"><h2 style="margin:10px 0;">Initial Setup Questions</h2>The following questions will help us determine how you would like certain sections of your website configured. Once you have answered these questions, please reply to your Intial Setup Ticket email you received so we can review and complete the next step.<br><br><strong>Note</strong>: These settings do not change anything on your website. They are intended for our support staff to use when initially setting up your website.</div>',
	) );
    
    
    $questions_options->add_field( array(
		'name'		=> __( '&nbsp;', 'cmb2' ),
		'desc'		=> __( 'Example: All Homes in Roseville, CA between $350,000 and $500,000', 'cmb2' ),
        'id'		=> 'q_featured_listings_desc',
		'type'      => 'textarea_small',
	) );
    
    $questions_options->add_field( array(
		'name'		=> __( 'Primary Neighborhoods/Searches', 'cmb2' ),
		'desc'		=> __( '<ul style="margin-top:-8px; display:block;color: #444;font-style: initial;"><li>Provide 3-6 primary areas or neighborhoods that you serve. Once the initial set up is completed, we can train you on how to add additional neighborhoods. <a href="https://theinsider.idxcentral.com/tutorials/premium-add-ons/wordpress-neighborhood-add-on-tutorial/" target="_blank">How to add Neighborhoods</a></li><ul>', 'cmb2' ),
        'id'		=> 'q_neighborhood',
		'type'      => 'text',
        'repeatable'  => true,
        'text'        => array(
		  'add_row_text' => 'Add Another Neighborhood',
	       ),
	) );
    
    $questions_options->add_field( array(
		'name'		=> __( 'Banner Photo(s)', 'cmb2' ),
		'desc'		=> __( '<ul style="margin-top:-8px; display:block;color: #444;font-style: initial;"><li><strong>Need Photos?</strong><br>Pick 1-3 photos from iStock that will work for the horizontal banner at the top of the home page. (Note: Image labeled "for editorial use only" can not be used). Enter the "Stock photo ID" of the image(s) below. Don\'t download/purchase any photos! We\'ll take care of that. If the primary photo you pick won\'t work, we will select from your alternate photos selected.<br><a href="http://www.istockphoto.com/" target="_blank">Search Images</a><br><br><strong>Have Your Own Photos?</strong><br>If you would prefer to provide photos you own the rights to, upload them to your <a href="'.admin_url().'upload.php" target="_blank">media library</a> and let us know in the "Questions / Special Requests" notes below.<br><br>Pick something that will work horizontally. We will review your photo choices and let you know if there is an issue.</li><ul>', 'cmb2' ),
        'id'		=> 'q_photos',
		'type'      => 'text',
        'repeatable'  => true,
        'text'        => array(
		  'add_row_text' => 'Add Another Photo ID',
	       ),
	) );
    
    
    $questions_options->add_field( array(
		'name'		=> __( 'Testimonial', 'cmb2' ),
		'desc'		=> __( 'Please provide us with one brief testimonial (including the author\'s name as you would like it to appear, such as Joe M.), or a brief quote (approximately 25 words or less) about you or the area you serve. This is displayed in the Sidebar on most of your pages as seen in the demo. You can always change this later.', 'cmb2' ),
        'id'		=> 'q_testimonials',
		'type' => 'textarea_small',
	) );
    
    
    $questions_options->add_field( array(
		'name'		=> __( 'Text Notifications', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
        'id'		=> 'q_text_notifications',
		'type'      => 'text',
        'before_field'   => '<span style="padding-top:5px; display:block;">iHomefinder IDX Clients Only: If you would like to receive text alerts when a visitor submits an IDX lead form, please provide the mobile number you want them sent to.</span>',
	) );
    
    
    $questions_options->add_field( array(
		'name'		=> __( 'Admin Email', 'cmb2' ),
		'desc'		=> __( '', 'cmb2' ),
        'id'		=> 'q_admin_email',
		'type'      => 'text',
        'before_field'   => '<span style="padding-top:5px; display:block;">What should the "Admin" email for the website be? This is where all the contact form entries and site notifications will be sent.</span>',
	) );

    
    $questions_options->add_field( array(
		'name'		=> __( 'Questions / Special Requests', 'cmb2' ),
		'desc'		=> __( 'Let us know if you have any questions or special requests here.', 'cmb2' ),
        'id'		=> 'q_questions_requests',
		'type' => 'textarea',
        'after_row'     => '<div class="cmb-row cmb-type-text" style="padding-bottom:10px;background:#fafafa;"><strong>Reminder</strong>: Once you have answered these questions, please reply to your Intial Setup Ticket email you received so we can review and complete the next step.</div>',
	) );
    
    
}



/**
 * Shortcode: CMB2 Field Shortcode (universal)
 * Usage: [placeholder field="field_name" page="OPTION_KEY"]
 * Optional variable(s): page
 */
function md_placeholder_func( $atts ) {
    $atts = shortcode_atts(
		array(
			'field' => 'agent_title',
            'page' => 'md_main_options',
		), $atts , 'placeholder' );
    
    $field_value = cmb2_get_option( $atts['page'], $atts['field'] );
    
    return 'Field Value = '.$field_value;
}
add_shortcode('placeholder', 'md_placeholder_func');

/**
 * Shortcode: CMB2 Field Shortcode (main options)
 * Usage: [ph_primary field="field_name"]
 * Optional variable(s): n/a
 */
function md_ph_primary_func( $atts ) {
    $atts = shortcode_atts(
		array(
			'field' => 'first_name',
            'filter' => 'none', // (optional: tel )
		), $atts , 'ph_primary' );
    
    $field_value = cmb2_get_option( 'md_main_options', $atts['field'] );
    $filter = $atts['filter'];
    
    // If filter is not none, then apply appropriate filter to field_value      
    if ($filter == 'tel') { $field_value = preg_replace("/[^0-9]/", "", $field_value ); ;} // strip non numeric characters
    
    return $field_value;
}
add_shortcode('ph_primary', 'md_ph_primary_func');



/**
 * Shortcode: Social Links Block Shortcode (main options)
 * Usage: [social_icons]
 * Optional variable(s): n/a
 * Description: This shortcode will display a group of social icons depending 
 *              on which social site urls are entered on the Main Options page.
 */
function md_social_icons_func( $atts ) {
	extract(shortcode_atts(array(
		"class" => '',							// optional: (any_custom_name)
	), $atts));
	
    $phone = cmb2_get_option( 'md_main_options', 'phone_social' );
    $email = cmb2_get_option( 'md_main_options', 'email' );
    $facebook = cmb2_get_option( 'md_main_options', 'facebook_url' );
    $instagram = cmb2_get_option( 'md_main_options', 'instagram_url' );
    $linkedin = cmb2_get_option( 'md_main_options', 'linkedin_url' );
    $pinterest = cmb2_get_option( 'md_main_options', 'pinterest_url' );
    $snapchat = cmb2_get_option( 'md_main_options', 'snapchat_url' );
    $twitter = cmb2_get_option( 'md_main_options', 'twitter_url' );
    $youtube = cmb2_get_option( 'md_main_options', 'youtube_url' );
    $vimeo = cmb2_get_option( 'md_main_options', 'vimeo_url' );
	$tiktok = cmb2_get_option( 'md_main_options', 'tiktok_url' );
    
    // Strip non numeric characters from phone field value      
    if ($phone != '') {$phone = preg_replace("/[^0-9]/", "", $phone ); ;}
	if ($class != '') { $class = ' ' . $class;} 

    // Set output variable to empty and create a url counter
    $social_url_count = 0;
    $output = '<div class="social_icons' . $class . '">';
    
    // Add Social links to output if defined
    if ($phone != '') {$output .= '<a href="tel:'.$phone.'" class="so_icon so_phone" aria-label="call '.$phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a>';}
    if ($email != '') {$output .= '<a href="mailto:'.$email.'" class="so_icon so_email" aria-label="email, opens in a new window" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>';}
    if ($facebook != '') {$output .= '<a href="'.$facebook.'" class="so_icon so_facebook" aria-label="Visit us on facebook, opens in a new window" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>';}
    if ($instagram != '') {$output .= '<a href="'.$instagram.'" class="so_icon so_instagram" aria-label="Visit us on instagram, opens in a new window" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a>';}
    if ($linkedin != '') {$output .= '<a href="'.$linkedin.'" class="so_icon so_linkedin" aria-label="Visit us on linkedin, opens in a new window" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>';}
    if ($pinterest != '') {$output .= '<a href="'.$pinterest.'" class="so_icon so_pinterest" aria-label="Visit us on pinterest, opens in a new window" target="_blank"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>';}
    if ($snapchat != '') {$output .= '<a href="'.$snapchat.'" class="so_icon so_snapchat" aria-label="Visit us on snapchat, opens in a new window" target="_blank"><i class="fab fa-snapchat-ghost" aria-hidden="true"></i></a>';}
    if ($twitter != '') {$output .= '<a href="'.$twitter.'" class="so_icon so_twitter" aria-label="Visit us on X, opens in a new window" target="_blank"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>';}
    if ($youtube != '') {$output .= '<a href="'.$youtube.'" class="so_icon so_youtube" aria-label="Visit us on youtube, opens in a new window" target="_blank"><i class="fab fa-youtube" aria-hidden="true"></i></a>';}
    if ($vimeo != '') {$output .= '<a href="'.$vimeo.'" class="so_icon so_vimeo nofoobox" aria-label="Visit us on vimeo, opens in a new window" target="_blank"><i class="fab fa-vimeo-v" aria-hidden="true"></i></a>';}
	if ($tiktok != '') {$output .= '<a href="'.$tiktok.'" class="so_icon so_tiktok nofoobox" aria-label="Visit us on tiktok, opens in a new window" target="_blank"><i class="fab fa-tiktok" aria-hidden="true"></i></a>';}
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('social_icons', 'md_social_icons_func');

