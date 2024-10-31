<?php
/**
 * Public Class
 *
 * Handles the Public side functionality of plugin
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Nswp_Pif_Public {

	function __construct() {

		// Action to add Product Inquiry Button on product single page after add to cart button
		add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'nswp_pif_add_product_inquiry_btn' ) );

		// Add action to process inquiry form submission
		add_action( 'wp_ajax_nswp_pif_form_submit_process', array( $this, 'nswp_pif_form_submit_process' ) );
		add_action( 'wp_ajax_nopriv_nswp_pif_form_submit_process', array( $this,'nswp_pif_form_submit_process' ) );
	}

	/**
	 * Function to add product inquiry button on product single page
	 * 
	 * @since 1.0
	 */
	function nswp_pif_add_product_inquiry_btn() {

		global $product;

		// Taking some data
		$enable = nswp_pif_get_option( 'enable' );

		// Check if product inquiry is `enable`
		if( ! empty( $enable ) ) {

			// Taking some variables
			$inquiry_btn_txt		= nswp_pif_get_option( 'inquiry_btn_txt' );
			$inquiry_heading_txt	= nswp_pif_get_option( 'inquiry_heading_txt' );
			$submit_btn_txt			= nswp_pif_get_option( 'submit_btn_txt' );
			$styles					= nswp_pif_generate_styles();

			// Print Inline Style
			echo "<style type='text/css'>".wp_strip_all_tags( $styles )."</style>";

			// Include Inquiry Form File
			include( NSWP_PIF_DIR. '/templates/inquiry-form.php' );
		}
	}

	/**
	 * Function to proccess inquiry form submission
	 * 
	 * @since 1.0
	 */
	function nswp_pif_form_submit_process() {

		// Check if `form_data` is there to parse
		if( ! empty( $_POST['form_data'] ) ) {
			parse_str( wp_unslash( $_POST['form_data'] ), $form_data ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		}

		// Taking some data
		$nonce		= isset( $form_data['nonce'] )					? nswp_pif_clean( $form_data['nonce'] )							: '';
		$product_id	= ! empty( $form_data['nswp_pif_product_id'] )	? nswp_pif_clean_number( $form_data['nswp_pif_product_id'] )	: 0;
		$name		= ! empty( $form_data['nswp_pif_name'] )		? nswp_pif_clean( $form_data['nswp_pif_name'] )					: '';
		$email		= ! empty( $form_data['nswp_pif_email'] )		? sanitize_email( $form_data['nswp_pif_email'] )				: '';
		$phone		= ! empty( $form_data['nswp_pif_phone'] )		? nswp_pif_clean_number( $form_data['nswp_pif_phone'] )			: '';
		$message	= ! empty( $form_data['nswp_pif_message'] )		? wp_kses_post( $form_data['nswp_pif_message'] )				: '';
		$results	= array(
			'success'	=> 0,
			'msg'		=> esc_js( __('Sorry, One or more fields have an error. Please check and try again.', 'nswp-product-inquiry-form') ),
		);

		// If Product ID OR Form Data is not there
		if( empty( $product_id ) || empty( $form_data ) || ! wp_verify_nonce( $nonce, "nswp-product-inquiry-nonce" ) ) {
			wp_send_json( $results );
		}

		/* Validation of Fields */
		if( $name == '' ) {
			$results['errors']['name'] = esc_html__( 'Please enter your name.', 'nswp-product-inquiry-form' );
		}

		/* Validation of Email Field */
		if( $email == '' && ! is_email( $email ) ) {
			$results['errors']['email'] = esc_html__( 'Please enter valid email.', 'nswp-product-inquiry-form' );
		}

		/* Validation of Phone Field */
		if( $phone == '' && ! preg_match('/^[0-9 .\-+]+$/i', $phone) ) {
			$results['errors']['phone'] = esc_html__( 'Please enter valid phone number.', 'nswp-product-inquiry-form' );
		}

		/* Validation of Fields */
		if( $message == '' ) {
			$results['errors']['message'] = esc_html__( 'Please enter your message.', 'nswp-product-inquiry-form' );
		}

		/* Insert Process When No Error */
		if( ! isset( $results['errors'] ) ) {

			// Taking some data
			$product_name	= get_the_title( $product_id );
			$product_link	= get_permalink( $product_id );
			$email_to		= nswp_pif_get_option( 'email_to' );
			$email_to		= ! empty( $email_to )	? $email_to : get_option( 'admin_email' );
			$email_subject	= nswp_pif_get_option( 'email_subject' );
			$email_heading	= nswp_pif_get_option( 'email_heading' );
			$email_msg		= nswp_pif_get_option( 'email_msg' );

			$email_msg		= ! empty( $email_msg ) ? do_shortcode( wpautop( $email_msg ) )	: sprintf( esc_html__( "Hi %s, \n\n You have received a new product inquiry. Inquiry data is as follows. \n\n Name: %s \n Email Address: %s \n Phone Number: %s \n Message: %s \n ", 'nswp-product-inquiry-form' ), esc_html( $name ), esc_html( $name ), esc_html( $email ), esc_html( $phone ), esc_html( $message ) );
			$email_msg		= str_replace( '{name}', $name, $email_msg );
			$email_msg		= str_replace( '{email}', $email, $email_msg );
			$email_msg		= str_replace( '{phone}', $phone, $email_msg );
			$email_msg		= str_replace( '{message}', $message, $email_msg );
			$email_msg		.= sprintf( '<strong>'.__('Product', 'nswp-product-inquiry-form').'</strong>: <a href="%s">%s</a>', $product_link, $product_name );

			$nswp_pif_email = new Nswp_Pif_Email();

			$nswp_pif_email->__set( 'heading', $email_heading );
			$nswp_pif_email->send( $email_to, $email_subject, $email_msg );

			$results['success']	= 1;
			$results['msg']		= esc_js( __('Inquiry Form Submitted Successfully.', 'nswp-product-inquiry-form') );
		}

		wp_send_json( $results );
	}
}

$nswp_pif_public = new Nswp_Pif_Public();