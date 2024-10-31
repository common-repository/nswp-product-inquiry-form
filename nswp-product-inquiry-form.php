<?php
/*
 * Plugin Name:       NSWP - Product Inquiry Form
 * Plugin URI:        https://nodesolutions.ca/
 * Description:       Display product inquiry form in a single product page.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Nodesolutions
 * Author URI:        https://nodesolutions.ca/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       nswp-product-inquiry-form
 * Domain Path:       /languages
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! defined( 'NSWP_PIF_VERSION' ) ) {
	define( 'NSWP_PIF_VERSION', '1.0.1' ); // Version of plugin
}

if( ! defined( 'NSWP_PIF_DIR' ) ) {
	define( 'NSWP_PIF_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if( ! defined( 'NSWP_PIF_URL' ) ) {
	define( 'NSWP_PIF_URL', plugin_dir_url( __FILE__ )); // Plugin url
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @since 1.0
 */
function nswp_pif_load_textdomain() {

	global $wp_version;

	// Set filter for plugin's languages directory
	$nswp_pif_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$nswp_pif_lang_dir = apply_filters( 'nswp_pif_languages_directory', $nswp_pif_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'nswp-product-inquiry-form' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'nswp-product-inquiry-form', $locale );

	// Setup paths to current locale file
	$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( NSWP_PIF_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'nswp-product-inquiry-form', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'nswp-product-inquiry-form', false, $nswp_pif_lang_dir );
	}
}

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @since 1.0
 */
register_activation_hook( __FILE__, 'nswp_pif_install' );

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 * 
 * @since 1.0
 */
function nswp_pif_install() {

	// Get settings for the plugin
	$nswp_pif_opts = get_option( 'nswp_pif_opts' );

	if( empty( $nswp_pif_opts ) ) {

		// Set default settings
		nswp_pif_default_settings();

		update_option( 'nswp_pif_plugin_options', 1.0 );
	}
}

/**
 * Check plugin is activation
 *
 * @since 1.0
 */
function nswp_pif_check_activation() {

	// Check if `WooCommerce` is not activated to display notice
	if( ! class_exists('WooCommerce') ) {

		// is this plugin active?
		if( is_plugin_active( plugin_basename( __FILE__ ) ) ) {

			deactivate_plugins( plugin_basename( __FILE__ ) );	// deactivate the plugin

			unset( $_GET[ 'activate' ] );	// unset activation notice

			// Display notice
			add_action( 'admin_notices', 'nswp_pif_admin_notices' );
		}
	}
}

// Check required plugin is activated or not
add_action( 'admin_init', 'nswp_pif_check_activation' );

/**
 * Admin notices to activate WooCommerce plugin
 * 
 * @since 1.0
 */
function nswp_pif_admin_notices() {

	// Check if `WooCommerce` is not activated to display notice
	if( ! class_exists('WooCommerce') ) {

		echo '<div class="error notice is-dismissible">
				<p><strong>'.esc_html__('NSWP - Product Inquiry Form for WooCommerce', 'nswp-product-inquiry-form').'</strong> '.esc_html__(' recommends the following plugin to use.', 'nswp-product-inquiry-form').'</p>
				<p><strong><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a></strong></p>
			 </div>';
	}
}

/**
 * Function to display admin notice of activated plugin.
 * 
 * @since 1.0
 */
function nswp_pif_plugin_exist_notice() {

	global $pagenow;

	$notice_link        = add_query_arg( array('message' => 'nswp-pif-plugin-notice'), admin_url('plugins.php') );
	$notice_transient   = get_transient( 'nswp_pif_install_notice' );

	// If Free plugin is active and PRO plugin exist
	if( $notice_transient == false && $pagenow == 'plugins.php' && current_user_can( 'install_plugins' ) ) {
		echo '<div class="updated notice" style="position:relative;">
			<p>
				<strong>'.sprintf( esc_html__( 'Thank you for activating %s', 'nswp-product-inquiry-form' ), 'NSWP - Product Inquiry Form' ).'</strong>.
			</p>
			<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
		</div>';
	}
}

// Taking some global variable
global $nswp_pif_opts;

// Funcions File
require_once( NSWP_PIF_DIR .'/includes/nswp-pif-functions.php' );
$nswp_pif_opts = nswp_pif_get_settings();

// Load admin side files
if( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

	// Plugin Settings
	require_once( NSWP_PIF_DIR . '/includes/admin/settings/register-settings.php' );
}

/**
 * Load the plugin after the main plugin is loaded.
 * 
 * @since 1.0
 */
function nswp_pif_load_plugin() {

	// Check if `WooCommerce` plugin activated to load all the files of the plugin
	if( class_exists('WooCommerce') ) {

		// Load plugin textdomain
		nswp_pif_load_textdomain();

		// Action to display notice
		add_action( 'admin_notices', 'nswp_pif_plugin_exist_notice' );

		// Include Public Class File
		require_once( NSWP_PIF_DIR. '/includes/class-nswp-pif-public.php' );

		// Include Script Class File
		require_once( NSWP_PIF_DIR. '/includes/class-nswp-pif-script.php' );

		// Email Class File
		require_once( NSWP_PIF_DIR . '/includes/class-nswp-pif-email.php' );

		// Load admin side files
		if( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

			// Include Admin Class File
			require_once( NSWP_PIF_DIR. '/includes/admin/class-nswp-pif-admin.php' );
		}
	}
}
add_action( 'plugins_loaded', 'nswp_pif_load_plugin', 99 );