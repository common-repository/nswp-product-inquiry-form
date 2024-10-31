<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Nswp_Pif_Admin {

	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array( $this, 'nswp_pif_register_menu' ) );
	}

	/**
	 * Function to add menu
	 * 
	 * @since 1.0
	 */
	function nswp_pif_register_menu() {

		// Setting Page
		add_menu_page( __('NS Product Inquiry', 'nswp-product-inquiry-form'), __('NS Product Inquiry', 'nswp-product-inquiry-form'), 'manage_options', 'nswp-pif-settings', array( $this, 'nswp_pif_setting_page' ), 'dashicons-admin-generic', 56 );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @since 1.0
	 */
	function nswp_pif_setting_page() {
		include_once( NSWP_PIF_DIR . '/includes/admin/settings/settings.php' );
	}
}

$Nswp_Pif_Admin = new Nswp_Pif_Admin();