<?php
/**
 * Settings Page
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $nswp_pif_opts;

// Plugin settings tab
$sett_tab       = nswp_pif_settings_tab();
$sett_tab_count = count( $sett_tab );
$tab            = isset( $_GET['tab'] ) ? nswp_pif_clean( $_GET['tab'] ) : 'general';

// If no valid tab is there
if( ! isset( $sett_tab[ $tab ] ) ) {
	nswp_pif_display_message( 'error' );
	return;
} ?>

<div class="wrap">

	<h2><?php esc_html_e( 'Product Inquiry Form - Settings', 'nswp-product-inquiry-form' ); ?></h2>

	<?php
	// Reset message
	if( ! empty( $_POST['nswp_pif_reset_settings'] ) ) {
		nswp_pif_display_message( 'reset' );
	}

	// Success message
	if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
		nswp_pif_display_message( 'update' );
	}

	settings_errors( 'nswp_pif_sett_error' );

	// If more than one settings tab
	if( $sett_tab_count > 1 ) { ?>

	<h2 class="nav-tab-wrapper">
		<?php foreach ( $sett_tab as $tab_key => $tab_val ) {
			$tab_url        = add_query_arg( array( 'page' => 'nswp-pif-settings', 'tab' => $tab_key ), admin_url('admin.php') );
			$active_tab_cls = ( $tab == $tab_key ) ? 'nav-tab-active' : '';
		?>
			<a class="nav-tab <?php echo esc_attr( $active_tab_cls ); ?>" href="<?php echo esc_url( $tab_url ); ?>"><?php echo esc_html( $tab_val ); ?></a>
		<?php } ?>
	</h2>

	<?php } ?>

	<div class="nswp-pif-sett-wrap nswp-pif-settings nswp-pif-cnt-wrap nswp-pif-pad-top-20">

		<!-- Plugin reset settings form -->
		<form action="" method="post" id="nswp-pif-reset-sett-form" class="nswp-pif-right nswp-pif-reset-sett-form">
			<input type="submit" class="button button-primary nswp-pif-confirm nswp-pif-btn nswp-pif-reset-sett nswp-pif-resett-sett-btn nswp-pif-reset-sett" name="nswp_pif_reset_settings" id="nswp-pif-reset-sett" value="<?php esc_attr_e( 'Reset All Settings', 'nswp-product-inquiry-form' ); ?>" />
		</form>

		<form action="options.php" method="POST" id="nswp-pif-settings-form" class="nswp-pif-settings-form">

			<?php settings_fields( 'nswp_pif_plugin_options' ); ?>

			<div class="textright nswp-pif-clearfix">
				<input type="submit" name="nswp_pif_settings_submit" class="button button-primary right nswp-pif-btn nswp-pif-sett-submit nswp-pif-sett-submit" value="<?php esc_attr_e('Save Changes', 'nswp-product-inquiry-form'); ?>" />
			</div>

			<div class="metabox-holder">
				<div class="post-box-container">
					<div class="meta-box-sortables ui-sortable">

						<?php
						// Setting files
						switch ( $tab ) {
							case 'general':
								include_once( NSWP_PIF_DIR . '/includes/admin/settings/general-sett.php' );
								break;

							case 'notification':
								include_once( NSWP_PIF_DIR . '/includes/admin/settings/notification-sett.php' );
								break;

							default:
								do_action( 'nswp_pif_sett_panel_' . $tab );
								do_action( 'nswp_pif_sett_panel', $tab );
								break;
						} ?>

					</div><!-- end .meta-box-sortables -->
				</div><!-- end .post-box-container -->
			</div><!-- end .metabox-holder -->

		</form><!-- end .nswp-pif-settings-form -->
	</div><!-- end .nswp-pif-sett-wrap -->
</div><!-- end .wrap -->