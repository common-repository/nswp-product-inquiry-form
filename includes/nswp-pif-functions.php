<?php
/**
 * Plugin generic functions file
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @since 1.0
 */
function nswp_pif_get_settings() {
	
	$options	= get_option('nswp_pif_opts');
	$settings	= is_array( $options ) ? $options : array();

	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function nswp_pif_get_option( $key = '', $default = false ) {

	global $nswp_pif_opts;

	$value = ! empty( $nswp_pif_opts[ $key ] ) ? $nswp_pif_opts[ $key ] : $default;
	$value = apply_filters( 'nswp_pif_get_option', $value, $key, $default );

	return apply_filters( 'nswp_pif_get_option_' . $key, $value, $key, $default );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 1.0
 */
function nswp_pif_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'nswp_pif_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @since 1.0
 */
function nswp_pif_clean_number( $var, $fallback = null, $type = 'int' ) {

	$var = trim( $var );
	$var = is_numeric( $var ) ? $var : 0;

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else if ( $type == 'abs' ) {
		$data = abs( $var );
	} else if ( $type == 'float' ) {
		$data = (float)$var;
	} else {
		$data = absint( $var );
	}

	return ( empty( $data ) && isset( $fallback ) ) ? $fallback : $data;
}

/**
 * Sanitize URL
 * 
 * @since 1.0
 */
function nswp_pif_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Sanitize Hex Color
 * 
 * @since 1.0
 */
function nswp_pif_clean_color( $color, $fallback = null ) {

	if ( false === strpos( $color, 'rgba' ) ) {
		
		$data = sanitize_hex_color( $color );

	} else {

		$red	= 0;
		$green	= 0;
		$blue	= 0;
		$alpha	= 0.5;

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		$data = 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}

	return ( empty( $data ) && $fallback ) ? $fallback : $data;
}

/**
 * Allow Valid Html Tags
 * It will sanitize HTML (strip script and style tags)
 *
 * @since 1.0
 */
function nswp_pif_clean_html( $data = array() ) {

	if ( is_array( $data ) ) {

		$data = array_map( 'nswp_pif_clean_html', $data );

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_post_kses( $data );
	}

	return $data;
}

/**
 * Function to display message, norice etc
 * 
 * @since 1.0
 */
function nswp_pif_display_message( $type = 'update', $msg = '', $echo = 1 ) {

	switch( $type ) {
		case 'reset':
			$msg = ! empty( $msg ) ? $msg : __( 'All settings reset successfully.', 'nswp-product-inquiry-form' );
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		case 'error':
			$msg = ! empty( $msg ) ? $msg : __( 'Sorry, Something happened wrong.', 'nswp-product-inquiry-form' );
			$msg_html = '<div id="message" class="error notice is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		default:
			$msg = ! empty( $msg ) ? $msg : __('Your changes saved successfully.', 'nswp-product-inquiry-form' );
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>'. $msg .'</strong></p>
						</div>';
			break;
	}

	if( $echo ) {
		echo wp_kses_post( $msg_html );
	} else {
		return $msg_html;
	}
}

/**
 * Function to generate dynamic styles
 * 
 * @since 1.0
 */
function nswp_pif_generate_styles() {

	// Taking some data
	$style					= '';
	$inquiry_btn_bgclr		= nswp_pif_get_option( 'inquiry_btn_bgclr' );
	$inquiry_btn_txtclr		= nswp_pif_get_option( 'inquiry_btn_txtclr' );
	$submit_btn_bgclr		= nswp_pif_get_option( 'submit_btn_bgclr' );
	$submit_btn_txtclr		= nswp_pif_get_option( 'submit_btn_txtclr' );

	$style	.= ".nswp-pif-form-btn-wrap .nswp-pif-form-btn{background-color: {$inquiry_btn_bgclr}; color: {$inquiry_btn_txtclr};}";
	$style	.= "#nswp-pif-form-popup button.nswp-pif-submit-btn{background-color: {$submit_btn_bgclr}; color: {$submit_btn_txtclr};}";

	return apply_filters( 'nswp_pif_generate_styles', $style );
}