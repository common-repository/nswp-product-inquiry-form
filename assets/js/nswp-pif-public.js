(function($) {

	"use strict";

	/* Click to open popup */
	$(document).on('click', '.nswp-pif-form-btn', function() {

		new Custombox.modal({
			content	: {
				target		: '#nswp-pif-form-popup',
				onOpen		: function() {

								/* Add Class for hide body scroll */
								jQuery('html').addClass('custombox-lock');

								jQuery('.custombox-content').removeClass('nswp-pif-open');
								jQuery('.custombox-content').addClass('nswp-pif-open');

								/* Add Classes for overlay */
								jQuery('.custombox-overlay').not('.nswp-pif-overlay').addClass('nswp-pif-open nswp-pif-overlay');
							},
				onComplete	: function() {
								jQuery('.custombox-overlay, .custombox-content').addClass('nswp-pif-complete');
							},
				onClose		: function() {
								/* Add Overflow Class in HTML Tag */
								jQuery('html').removeClass('custombox-lock');
							},
			},
			overlay	: {
						active		: true,
						color		: '#000',
						opacity		: .48,
						close		: true,
						speedIn		: 500,
						speedOut	: 500,
			},
		}).open();
	});

	/* On click to submit inquiry form and send email */
	$(document).on( 'submit', '.nswp-pif-inquiry-form-js', function(e) {

		e.preventDefault();

		var this_ele	= $(this);
		var cls_form	= $(this).closest('form');

		cls_form.find('.nswp-pif-form-field').removeClass('nswp-pif-form-inp-err');
		cls_form.find('.nswp-pif-submit-btn').attr('disabled', 'disabled');
		cls_form.find('.nswp-pif-error').remove();
		cls_form.find('.nswp-pif-success').remove();
		this_ele.find('.nswp-pif-loader').removeClass('nswp-pif-hide');

		var form_data	= {
			'action'	: 'nswp_pif_form_submit_process',
			'form_data'	: cls_form.serialize(),
		};

		$.post(NswpPifPublic.nswp_pif_ajaxurl, form_data, function(response) {

			if( response.success == 0 ) {
				$.each(response.errors, function( key, err_data ) {
					cls_form.find('.nswp-pif-field-'+key).closest('.nswp-pif-form-field').addClass('nswp-pif-form-inp-err');
				});

				cls_form.find('.nswp-pif-inquiry-popup-inr').append( '<div class="nswp-pif-error">' + response.msg + '</div>' );

			} else {

				cls_form.find('.nswp-pif-inquiry-popup-inr').append( '<div class="nswp-pif-success">' + response.msg + '</div>' );
				cls_form.find('.nswp-pif-form-field input').val('');
			}

			this_ele.find('.nswp-pif-loader').addClass('nswp-pif-hide');
			cls_form.find('.nswp-pif-submit-btn').removeAttr('disabled', 'disabled');
		});
	});
})(jQuery);