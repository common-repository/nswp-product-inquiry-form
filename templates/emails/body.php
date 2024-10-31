<?php
/**
 * Email Body
 *
 * @package NSWP - Product Inquiry Form
 * @version 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div style="margin: 0; padding: 30px 0 30px 0; -webkit-text-size-adjust: none !important; width: 100%;" class="wrapper" id="wrapper">
	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="700" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; border: 1px solid #dddddd; border-radius: 3px !important; border-collapse: collapse; word-wrap: break-word; word-break: break-word;">
		<tbody>
			<tr>
				<td valign="top" align="center">
					<?php if( $heading ) { ?>
						<div id="email-header">
							<h1 style="background-color:#00588f; color:#ffffff; margin:0; padding:20px; display: block; font-size:32px; font-weight:500;"><?php echo wp_kses_post( $heading ); ?></h1>
						</div>
					<?php } ?>

					<table align="center" border="0" cellpadding="0" cellspacing="0" width="700" id="template-container" class="template-container" style="border-collapse: collapse; word-wrap: break-word; word-break: break-word;">
						<tbody>
							<tr>
								<td valign="top" style="padding: 0; text-align: left; color: #60666d;" class="body-wrapper">
									<div class="body-content" style="padding: 15px; font-size:15px; -webkit-text-size-adjust:100%;">
										{email}
									</div>
								</td>
							</tr>

							<tr>
								<td colspan="2" align="center" valign="middle" id="credit" style="border:0; background-color: #00588f; color: #ffffff; font-size:15px; text-align:center; padding: 5px 0;">
									<?php
										$footer_text = sprintf( '<a href="%s" style="color: #ffffff;">%s</a>', home_url(), get_bloginfo( 'name' ) );

										echo wp_kses_post( $footer_text );
									?>
								</td>
							</tr>
						</tbody>
					</table><!-- end .template-container -->
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .wrapper -->