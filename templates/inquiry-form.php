<?php
/**
 * Inquiry Form HTML file
 *
 * @package NSWP - Product Inquiry Form
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="nswp-pif-form-btn-wrap nswp-pif-box-sizing nswp-pif-clearfix">
	<a href="#nswp-pif-form-popup" class="nswp-pif-form-btn"><?php echo esc_html( $inquiry_btn_txt ); ?></a>

	<form class="mfp-hide nswp-pif-inquiry-popup-wrap nswp-pif-inquiry-form-js nswp-pif-box-sizing nswp-pif-clearfix" id="nswp-pif-form-popup">

		<div class="nswp-pif-form-popup-ttl"><?php echo esc_html( $inquiry_heading_txt ); ?></div>

		<div class="nswp-pif-inquiry-popup-inr">
			<div class="nswp-pif-form-field">
				<label for="nswp-pif-field-name" class="nswp-pif-form-field-lbl">
					<?php esc_html_e( 'Name', 'nswp-product-inquiry-form' ); ?> <span>*</span>
				</label>
				<input type="text" name="nswp_pif_name" value="" class="nswp-pif-form-inp nswp-pif-field-name" id="nswp-pif-field-name" />
			</div>
			<div class="nswp-pif-form-field">
				<label for="nswp-pif-field-email" class="nswp-pif-form-field-lbl">
					<?php esc_html_e( 'Email Address', 'nswp-product-inquiry-form' ); ?> <span>*</span>
				</label>
				<input type="email" name="nswp_pif_email" value="" class="nswp-pif-form-inp nswp-pif-field-email" id="nswp-pif-field-email" />
			</div>
			<div class="nswp-pif-form-field">
				<label for="nswp-pif-field-phone" class="nswp-pif-form-field-lbl">
					<?php esc_html_e( 'Phone Number', 'nswp-product-inquiry-form' ); ?> <span>*</span>
				</label>
				<input type="text" name="nswp_pif_phone" value="" class="nswp-pif-form-inp nswp-pif-field-phone" id="nswp-pif-field-phone" />
			</div>
			<div class="nswp-pif-form-field">
				<label for="nswp-pif-field-message" class="nswp-pif-form-field-lbl">
					<?php esc_html_e( 'Message', 'nswp-product-inquiry-form' ); ?> <span>*</span>
				</label>
				<textarea name="nswp_pif_message" value="" class="nswp-pif-form-inp nswp-pif-field-message" id="nswp-pif-field-message"></textarea>
			</div>

			<div class="nswp-pif-form-field">
				<button type="submit" name="nswp_pif_submit_btn" class="nswp-pif-submit-btn"><?php echo esc_html( $submit_btn_txt ); ?> <span class="nswp-pif-loader nswp-pif-hide"></span></button>
			</div>
		</div>
		<input type="hidden" name="nswp_pif_product_id" value="<?php echo esc_attr( $product->id ); ?>" class="nswp-pif-product-id" />
		<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nswp-product-inquiry-nonce' ) ); ?>" />
		<input type="hidden" name="nswp_pif_product_name" value="<?php echo esc_attr( $product->name ); ?>" class="nswp-pif-product-name" />
		<input type="hidden" name="nswp_pif_product_link" value="<?php echo esc_url( get_permalink( $product->id ) ); ?>" class="nswp-pif-product-link" />
	</form>
</div>