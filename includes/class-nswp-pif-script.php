<?php
/**
 * Script Class
 *
 * Handles the Script side functionality of plugin
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Nswp_Pif_Script {

	function __construct() {

		// Action to add styles & scripts at admin side
		add_action( 'admin_enqueue_scripts', array( $this, 'nswp_pif_admin_styles_scripts' ) );

		// Action to add styles & scripts at front side
		add_action( 'wp_enqueue_scripts', array( $this, 'nswp_pif_front_styles_scripts' ), 99 );
	}

	/**
	 * Function to add styles & scripts at admin side
	 * 
	 * @since 1.0
	 */
	function nswp_pif_admin_styles_scripts( $hook ) {

		/***** Registering Styles *****/
		// Registering admin css
		wp_register_style( 'nswp-pif-admin', NSWP_PIF_URL.'assets/css/nswp-pif-admin.css', array(), NSWP_PIF_VERSION );

		/* Enqueue Styles */
		wp_enqueue_style( 'wp-color-picker' );	// ColorPicker CSS
		wp_enqueue_style( 'nswp-pif-admin' );	// Admin CSS

		/***** Registering Scripts *****/
		// Registring admin script
		wp_register_script( 'nswp-pif-admin', NSWP_PIF_URL.'assets/js/nswp-pif-admin.js', array('jquery'), NSWP_PIF_VERSION, true );

		/* Enqueue Scripts */
		wp_enqueue_script( 'wp-color-picker' );	// ColorPicker JS
		wp_enqueue_script( 'nswp-pif-admin' );	// Admin JS
	}

	/**
	 * Function to add styles & scripts at front side
	 * 
	 * @since 1.0
	 */
	function nswp_pif_front_styles_scripts() {

		/***** Registering Styles *****/
		// Registring public css
		wp_register_style( 'nswp-pif-public', NSWP_PIF_URL."assets/css/nswp-pif-public.css", array(), NSWP_PIF_VERSION );

		/* Enqueue Styles */
		wp_enqueue_style( 'nswp-pif-public' );	// Enqueue Public css

		/***** Registering Scripts *****/

		// Registering Custombox Popup JS
		wp_register_script( 'custombox', NSWP_PIF_URL."assets/js/custombox.min.js", array('jquery'), NSWP_PIF_VERSION, true );

		// Registering Magnific Popup JS
		wp_register_script( 'nswp-pif-public', NSWP_PIF_URL."assets/js/nswp-pif-public.js", array('jquery'), NSWP_PIF_VERSION, true );
		wp_localize_script( 'nswp-pif-public', 'NswpPifPublic', array(
																'nswp_pif_ajaxurl'	=> admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
																'nswp_pif_err_msg'	=> esc_js( esc_html__('Sorry, There is something wrong with analytics.', 'nswp-product-inquiry-form') ),
															));
		/* Enqueue Scripts */
		wp_enqueue_script( 'custombox' );		// Enqueue Custombox Popup JS
		wp_enqueue_script( 'nswp-pif-public' );	// Enqueue Public JS
	}
}

$nswp_pif_script = new Nswp_Pif_Script();