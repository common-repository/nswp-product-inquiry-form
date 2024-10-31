<?php
/**
 * Register Settings
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get settings tab
 * 
 * @since 1.0
 */
function nswp_pif_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general'		=> __( 'General Settings', 'nswp-product-inquiry-form' ),
					'notification'	=> __( 'Notification Settings', 'nswp-product-inquiry-form' ),
				);

	return apply_filters( 'nswp_pif_settings_tab', (array)$sett_tabs );
}

/**
 * Set Settings Default Option Page
 * Handles to return all settings value
 *
 * @since 1.0
 */
function nswp_pif_default_settings() {

	global $nswp_pif_opts;

	$default_options = array(
						'enable'				=> 1,
						'inquiry_btn_txt'		=> __('Product Inquiry', 'nswp-product-inquiry-form'),
						'inquiry_btn_bgclr'		=> '#00588f',
						'inquiry_btn_txtclr'	=> '#ffffff',
						'inquiry_heading_txt'	=> __('Product Inquiry Form', 'nswp-product-inquiry-form'),
						'submit_btn_txt'		=> __('Submit', 'nswp-product-inquiry-form'),
						'submit_btn_bgclr'		=> '#00588f',
						'submit_btn_txtclr'		=> '#ffffff',
						'email_to'				=> '',
						'email_subject'			=> __('Product Inquiry Form', 'nswp-product-inquiry-form'),
						'email_heading'			=> __('New Inquiry Receive', 'nswp-product-inquiry-form'),
						'email_msg'				=> __( 'Hi <strong>{name}</strong>,<br/><br/>You have received a new inquiry. Inquiry data is as follows.<br/><br/><strong>Name:</strong> {name}\n<strong>Email Address:</strong> {email}\n<strong>Phone Number:</strong> {phone}\n<strong>Message:</strong> {message}', 'nswp-product-inquiry-form' ),
					);

	$default_options = apply_filters('nswp_pif_default_settings', $default_options );

	// Update default options
	update_option( 'nswp_pif_opts', $default_options );

	// Overwrite global variable when option is update
	$nswp_pif_opts = nswp_pif_get_settings();
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function nswp_pif_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['nswp_pif_reset_settings'] ) && current_user_can('administrator') ) {
		
		// Default Settings
		nswp_pif_default_settings();
	}

	register_setting( 'nswp_pif_plugin_options', 'nswp_pif_opts', 'nswp_pif_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'nswp_pif_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function nswp_pif_validate_options( $input ) {

	global $nswp_pif_opts;

	$input = $input ? $input : array();

	// Pull out the tab and section
	if( ! empty( $_POST['_wp_http_referer'] ) ) {
		parse_str( nswp_pif_clean( $_POST['_wp_http_referer'] ), $referrer );
	}

	$tab = isset( $referrer['tab'] ) ? nswp_pif_clean( $referrer['tab'] ) : 'general';

	// Run a general sanitization for the tab for special fields
	$input = apply_filters( 'nswp_pif_'.$tab.'_tab_sett', $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'nswp_pif_tab_sett', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $nswp_pif_opts, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.0
 */
function nswp_pif_sanitize_general_sett( $input ) {

	$input['enable']				= ! empty( $input['enable'] )				? 1	: 0;
	$input['inquiry_btn_txt']		= ! empty( $input['inquiry_btn_txt'] )		? nswp_pif_clean( $input['inquiry_btn_txt'] )			: '';
	$input['inquiry_heading_txt']	= ! empty( $input['inquiry_heading_txt'] )	? nswp_pif_clean( $input['inquiry_heading_txt'] )		: '';
	$input['submit_btn_txt']		= ! empty( $input['submit_btn_txt'] )		? nswp_pif_clean( $input['submit_btn_txt'] )			: '';
	$input['inquiry_btn_bgclr']		= ! empty( $input['inquiry_btn_bgclr'] )	? nswp_pif_clean_color( $input['inquiry_btn_bgclr'] )	: '#00588f';
	$input['inquiry_btn_txtclr']	= ! empty( $input['inquiry_btn_txtclr'] )	? nswp_pif_clean_color( $input['inquiry_btn_txtclr'] )	: '#ffffff';
	$input['submit_btn_bgclr']		= ! empty( $input['submit_btn_bgclr'] )		? nswp_pif_clean_color( $input['submit_btn_bgclr'] )	: '#00588f';
	$input['submit_btn_txtclr']		= ! empty( $input['submit_btn_txtclr'] )	? nswp_pif_clean_color( $input['submit_btn_txtclr'] )	: '#ffffff';

	return $input;
}
add_filter( 'nswp_pif_general_tab_sett', 'nswp_pif_sanitize_general_sett' );

/**
 * Filter to validate general settings
 * 
 * @since 1.0
 */
function nswp_pif_sanitize_notification_sett( $input ) {

	$input['email_to']			= ! empty( $input['email_to'] )			? sanitize_email( $input['email_to'] )		: '';
	$input['email_subject']		= ! empty( $input['email_subject'] )	? nswp_pif_clean( $input['email_subject'] )	: '';
	$input['email_heading']		= ! empty( $input['email_heading'] )	? nswp_pif_clean( $input['email_heading'] )	: '';
	$input['email_msg']			= ! empty( $input['email_msg'] )		? wp_kses_post( $input['email_msg'] )		: '';

	return $input;
}
add_filter( 'nswp_pif_notification_tab_sett', 'nswp_pif_sanitize_notification_sett' );