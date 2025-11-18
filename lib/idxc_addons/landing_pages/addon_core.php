<?php 
/*
Project: Landing Page Add-on (Custom Write Panel)
Description: Creates Landing Page Metabox for Page and Global use
Version: 1.0.2
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2019 Moineau Design
*/


/* Create Metabox */ 
add_action( 'cmb2_admin_init', 'idxc_mb_create_landingpage' );

/**
 * Define the metabox and field configurations.
 */
function idxc_mb_create_landingpage() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_idxc_mb_landingpage_';

	/**
	 * Initiate the metabox
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Landing Page', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		//'closed'      => true, // Keep the metabox closed by default
		'show_on'       => array( 'key' => 'page-template', 'value' => 'page_idxc_landing.php' ),
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		
	) );

	// Add Fields	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Headline', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'headline',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Subheading', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'subheading',
		'type'			=> 'textarea_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Form ID', 'cmb2' ),
		'desc'			=> __( '<br />Enter the form\'s id.', 'cmb2' ),
		'id'			=> $prefix . 'form_id',
		'type'			=> 'text_small',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Name', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'name',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Title', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'title',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Phone', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'phone',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Email', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'email',
		'type'			=> 'text_email',
	) );


	$idxc2_metabox->add_field( array(
		'name'			=> __( 'License #', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'license_number',
		'type'			=> 'text',
	) );
	
    /*
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Office', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'office',
		'type'			=> 'text',
	) );
	
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Website URL', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'website_url',
		'type'			=> 'text_url',
		'protocols'		=> array( 'http', 'https' ), // Array of allowed protocols
	) );
	*/

    $idxc2_metabox->add_field( array(
        'name'		=> __( 'Agent Image', 'cmb2' ),
        'desc'    => 'Recommended size 100px wide by 120px in height.',
        'id'      => $prefix . 'agent_url',
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
	   'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    ) );
	

    $idxc2_metabox->add_field( array(
        'name'		=> __( 'Logo Image', 'cmb2' ),
        'desc'    => 'Recommended maximum size 240px wide by 125px in height.',
        'id'      => $prefix . 'logo_url',
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
	   'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    ) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Bullet 1', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'bullet_1',
		'type'			=> 'text',
		'before_row'   => '<h1>Bullet List Layout</h1><p>Optional bullet points. If used, alternate layout will be used.</p>',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Bullet 2', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'bullet_2',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Bullet 3', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'bullet_3',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Bullet 4', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'bullet_4',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Bullet 5', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'bullet_5',
		'type'			=> 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Form Headline', 'cmb2' ),
		'desc'			=> __( 'This is the headline located above the form when using the bullet list layout.', 'cmb2' ),
		'id'			=> $prefix . 'form_headline',
		'type'			=> 'text',
	) );
	
	
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Confirmation Message', 'cmb2' ),
		'desc'			=> __( 'Example code: &lt;h2&gt;Your Confirmation Title&lt;/h2&gt;Your description can go here.', 'cmb2' ),
		'id'			=> $prefix . 'confirmation_message',
		'type'			=> 'textarea_small',
		'before_row'   => '<h1>Confirmation Page</h1><p>To use this confirmation content, simply add ?confirm to the end of the link to this page.<br>Example: https://www.yourdomain.com/this-landing-page/?confirm</p>',
	) );
	
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 1 Label', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_label_1',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 1 Link', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_link_1',
		'type'       => 'text_url',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 2 Label', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_label_2',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 2 Link', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_link_2',
		'type'       => 'text_url',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 3 Label', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_label_3',
		'type'       => 'text',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'       => __( 'Button 3 Link', 'cmb2' ),
		'desc'       => __( '', 'cmb2' ),
		'id'         => $prefix . 'ss_button_link_3',
		'type'       => 'text_url',
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Background Overlay', 'cmb2' ),
		'desc'			=> __( 'Example code: rgba(0, 0, 0, 0.55)', 'cmb2' ),
		'id'			=> $prefix . 'background_overlay',
		'type'			=> 'text',
		'default'		=> 'rgba(0, 0, 0, 0.55)',
		'before_row'   => '<h1>Design</h1>',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'			=> __( 'Title', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'fb_og_title',
		'type'			=> 'text',
		'default'		=> '',
		'before_row'   => '<h1>Facebook / Open Graph Data</h1><p>Optional fields. When sharing this page on Facebook, these fields will allow you to customize what information you want Facebook to show in the post.</p>',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'			=> __( 'Description', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'fb_og_description',
		'type'			=> 'textarea_small',
	) );
    
    $idxc2_metabox->add_field( array(
        'name'		=> __( 'Post Image', 'cmb2' ),
        'desc'    => '<p>Facebook Recommendations. The minimum allowed image dimension is 200 x 200 pixels. The size of the image file must not exceed 8 MB. Use images that are at least 1200 x 630 pixels for the best display on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display link page posts with larger images.</p>',
        'id'      => $prefix . 'fb_og_image',
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
	   'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
       'after_row'   => '',
    ) );
	/*
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Button Color', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'button_color',
		'type'			=> 'colorpicker',
		'default'		=> '#0093c0',
	) );
	*/

}



