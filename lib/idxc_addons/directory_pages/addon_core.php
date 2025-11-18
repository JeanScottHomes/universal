<?php 
/*
Project: Directory Page Add-on (Custom Write Panel)
Description: Creates Directory Page Metabox for Page and Global use
Version: 1.0.0
Author: IDXCentral
Company Website: http://www.idxcentral.com
License: Copyright 2019 Moineau Design
*/


/* Create Metabox */ 
add_action( 'cmb2_admin_init', 'idxc_mb_create_directorypage' );

/**
 * Define the metabox and field configurations.
 */
function idxc_mb_create_directorypage() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_idxc_mb_directorypage_';

	/**
	 * Initiate the metabox
	 */
	$idxc2_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Directory Page', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		//'closed'      => true, // Keep the metabox closed by default
		'show_on'       => array( 'key' => 'page-template', 'value' => 'page_idxc_directory.php' ),
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		
	) );

	$idxc2_metabox->add_field( array(
        'name'		=> __( 'Header Image', 'cmb2' ),
        'desc'    => 'Upload an image or enter a URL. Typically this would be an agent photo. Ideal size is 150px square.',
        'id'      => $prefix . 'header_image',
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
		'type'			=> 'text',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'			=> __( 'Description', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'page_description',
		'type'			=> 'textarea_small',
	) );
	
	/*
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
	*/
    
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

    /*
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Website URL', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'website_url',
		'type'			=> 'text_url',
		'protocols'		=> array( 'http', 'https' ), // Array of allowed protocols
	) );
	
	$idxc2_metabox->add_field( array(
		'name'			=> __( 'Office', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'office',
		'type'			=> 'text',
	) );
	*/
    
    $idxc2_metabox->add_field( array(
		'name'			=> __( 'License #', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'license_number',
		'type'			=> 'text',
	) );
	

    
    
    $idxc2_metabox->add_field( array(
        'name'		=> __( 'Footer Image', 'cmb2' ),
        'desc'    => 'Recommended maximum size 450px wide by 225px in height. Typically your photo or logo if not added to the header.',
        'id'      => $prefix . 'footer_image',
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
		'name'			=> __( 'Background Overlay', 'cmb2' ),
		'desc'			=> __( 'Example code: rgba(0, 0, 0, 0.55)', 'cmb2' ),
		'id'			=> $prefix . 'background_overlay',
		'type'			=> 'text',
		'default'		=> 'rgba(0, 0, 0, 0.55)',
		'before_row'   => '<h1>Design</h1>',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'			=> __( 'Background Color', 'cmb2' ),
		'desc'			=> __( '', 'cmb2' ),
		'id'			=> $prefix . 'background_color',
		'type'			=> 'colorpicker',
		'default'		=> '#f9f9f9',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Facebook', 'cmb2' ),
		'id'		=> $prefix . 'facebook_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
        'before_row'   => '<h1>Social Links</h1>',
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Instagram', 'cmb2' ),
		'id'		=> $prefix . 'instagram_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'LinkedIn', 'cmb2' ),
		'id'		=> $prefix . 'linkedin_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Pinterest', 'cmb2' ),
		'id'		=> $prefix . 'pinterest_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Snapchat', 'cmb2' ),
		'id'		=> $prefix . 'snapchat_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'Twitter', 'cmb2' ),
		'id'		=> $prefix . 'twitter_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    $idxc2_metabox->add_field( array(
		'name'		=> __( 'YouTube', 'cmb2' ),
		'id'		=> $prefix . 'youtube_url',
		'type'		=> 'text_url',
		'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
	) );
    
    
    $group_field_id = $idxc2_metabox->add_field( array(
	'id'          => $prefix . 'link_group',
	'type'        => 'group',
	'description' => __( 'Enter Websites / Pages you wish to link to.', 'cmb2' ),
	// 'repeatable'  => false, // use false if you want non-repeatable group
	'options'     => array(
		'group_title'       => __( 'Link {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		'add_button'        => __( 'Add Another Link', 'cmb2' ),
		'remove_button'     => __( 'Remove Link', 'cmb2' ),
		'sortable'          => true,
		'remove_confirm' => esc_html__( 'Are you sure you want to remove this link?', 'cmb2' ), // Performs confirmation before removing group.
        // 'closed'         => true, // true to have the groups closed by default
	),
) );

// Id's for group's fields only need to be unique for the group. Prefix is not needed.
$idxc2_metabox->add_group_field( $group_field_id, array(
	'name' => 'Link Name',
	'id'   => $prefix . 'link_name',
	'type' => 'text',
	// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
) );

$idxc2_metabox->add_group_field( $group_field_id, array(
	'name' => 'Website URL',
	//'description' => 'Write a short description for this entry',
	'id'   => $prefix . 'link_url',
    'type'		=> 'text_url',
    'protocols'	=> array( 'http', 'https' ), // Array of allowed protocols
) );

}



