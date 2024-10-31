<?php
/**
 * Notification Settings
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$email_to		= nswp_pif_get_option('email_to');
$email_subject	= nswp_pif_get_option('email_subject');
$email_heading	= nswp_pif_get_option('email_heading');
$email_msg		= nswp_pif_get_option('email_msg');
?>

<div class="postbox nswp-pif-no-toggle">

	<div class="postbox-header">
		<h3 class="hndle">
			<span><?php esc_html_e( 'Notification Settings', 'nswp-product-inquiry-form' ); ?></span>
		</h3>
	</div>

	<div class="inside">
		<table class="form-table nswp-pif-tbl">
			<tbody>
				<tr>
					<th>
						<label for="nswp-pif-email-to"><?php esc_html_e('Mail To', 'nswp-product-inquiry-form'); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[email_to]" value="<?php echo esc_attr( $email_to ); ?>" class="nswp-pif-text large-text nswp-pif-email-to" id="nswp-pif-email-to" />
						<span class="description"><?php esc_html_e('Enter notification email address. You can enter multiple email address by comma separated.', 'nswp-product-inquiry-form'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-email-subject"><?php esc_html_e('Subject', 'nswp-product-inquiry-form'); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[email_subject]" value="<?php echo esc_attr( $email_subject ); ?>" class="nswp-pif-text large-text nswp-pif-email-subject" id="nswp-pif-email-subject" />
						<span class="description"><?php esc_html_e('Enter notification admin email subject. Available template tags are', 'nswp-product-inquiry-form'); ?></span><br/>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-email-heading"><?php esc_html_e('Heading', 'nswp-product-inquiry-form'); ?></label>
					</th>
					<td>
						<input type="text" name="nswp_pif_opts[email_heading]" value="<?php echo esc_attr( $email_heading ); ?>" class="nswp-pif-text large-text nswp-pif-email-heading" id="nswp-pif-email-heading" />
						<span class="description"><?php esc_html_e('Enter notification admin email heading.', 'nswp-product-inquiry-form'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="nswp-pif-email-msg"><?php esc_html_e('Message', 'nswp-product-inquiry-form'); ?></label>
					</th>
					<td>
						<?php wp_editor( $email_msg, 'nswp-pif-email-msg', array('textarea_name' => 'nswp_pif_opts[email_msg]', 'textarea_rows' => 8, 'media_buttons' => true, 'class' => 'nswp-pif-email-msg') ); ?>
						<span class="description"><?php esc_html_e( 'Enter notification admin email message.', 'nswp-product-inquiry-form' ); ?></span>
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