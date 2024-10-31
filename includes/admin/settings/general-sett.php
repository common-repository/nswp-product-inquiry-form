<?php
/**
 * General Settings
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$inquiry_btn_txt		= nswp_pif_get_option( 'inquiry_btn_txt' );
$inquiry_btn_bgclr		= nswp_pif_get_option( 'inquiry_btn_bgclr' );
$inquiry_btn_txtclr		= nswp_pif_get_option( 'inquiry_btn_txtclr' );
$inquiry_heading_txt	= nswp_pif_get_option( 'inquiry_heading_txt' );
$submit_btn_txt			= nswp_pif_get_option( 'submit_btn_txt' );
$submit_btn_bgclr		= nswp_pif_get_option( 'submit_btn_bgclr' );
$submit_btn_txtclr		= nswp_pif_get_option( 'submit_btn_txtclr' );
?>

<div class="postbox nswp-pif-no-toggle">

	<div class="postbox-header">
		<h3 class="hndle">
			<span><?php esc_html_e( 'General Settings', 'nswp-product-inquiry-form' ); ?></span>
		</h3>
	</div>

	<div class="inside">
		<table class="form-table nswp-pif-tbl">
			<tbody>
				<tr>
					<th>
						<label for="nswp-pif-enable"><?php esc_html_e('Enable', 'nswp-product-inquiry-form'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="nswp_pif_opts[enable]" value="1" <?php checked( nswp_pif_get_option('enable'), 1 ); ?> id="nswp-pif-enable" class="nswp-pif-checkbox nswp-pif-enable" />
						<span class="description"><?php esc_html_e('Check this box if you want to enable popup.', 'nswp-product-inquiry-form'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-inquiry-btn-txt"><?php esc_html_e( 'Inquiry Button Text', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[inquiry_btn_txt]" value="<?php echo esc_attr( $inquiry_btn_txt ); ?>" class="nswp-pif-inquiry-btn-txt" id="nswp-pif-inquiry-btn-txt" /><br/>
						<span class="description"><?php esc_html_e( 'Enter inquiry button text.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-inquiry-btn-bgclr"><?php esc_html_e( 'Inquiry Button BG Color', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[inquiry_btn_bgclr]" value="<?php echo esc_attr( $inquiry_btn_bgclr ); ?>" class="nswp-pif-colorpicker nswp-pif-inquiry-btn-bgclr" id="nswp-pif-inquiry-btn-bgclr" /><br/>
						<span class="description"><?php esc_html_e( 'Choose inquiry button background color.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-inquiry-btn-txtclr"><?php esc_html_e( 'Inquiry Button Text Color', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[inquiry_btn_txtclr]" value="<?php echo esc_attr( $inquiry_btn_txtclr ); ?>" class="nswp-pif-colorpicker nswp-pif-inquiry-btn-txtclr" id="nswp-pif-inquiry-btn-txtclr" /><br/>
						<span class="description"><?php esc_html_e( 'Choose inquiry button text color.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-inquiry-heading-txt"><?php esc_html_e( 'Form Heading Text', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[inquiry_heading_txt]" value="<?php echo esc_attr( $inquiry_heading_txt ); ?>" class="nswp-pif-inquiry-heading-txt" id="nswp-pif-inquiry-heading-txt" /><br/>
						<span class="description"><?php esc_html_e( 'Enter inquiry form heading text.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-submit-btn-txt"><?php esc_html_e( 'Submit Button Text', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[submit_btn_txt]" value="<?php echo esc_attr( $submit_btn_txt ); ?>" class="nswp-pif-submit-btn-txt" id="nswp-pif-submit-btn-txt" /><br/>
						<span class="description"><?php esc_html_e( 'Enter inquiry form submit button text.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-submit-btn-bgclr"><?php esc_html_e( 'Submit Button BG Color', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[submit_btn_bgclr]" value="<?php echo esc_attr( $submit_btn_bgclr ); ?>" class="nswp-pif-colorpicker nswp-pif-submit-btn-bgclr" id="nswp-pif-submit-btn-bgclr" /><br/>
						<span class="description"><?php esc_html_e( 'Choose inquiry submit button background color.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-submit-btn-txtclr"><?php esc_html_e( 'Submit Button Text Color', 'nswp-product-inquiry-form' ); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[submit_btn_txtclr]" value="<?php echo esc_attr( $submit_btn_txtclr ); ?>" class="nswp-pif-colorpicker nswp-pif-submit-btn-txtclr" id="nswp-pif-submit-btn-txtclr" /><br/>
						<span class="description"><?php esc_html_e( 'Choose inquiry submit button text color.', 'nswp-product-inquiry-form' ); ?></span>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="submit" name="nswp_pif_settings_submit" class="button button-primary right nswp-pif-btn nswp-pif-sett-submit" value="<?php esc_attr_e('Save Changes', 'nswp-product-inquiry-form'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->