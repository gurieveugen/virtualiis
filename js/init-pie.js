$(function() {
	if (window.PIE) {
		$('input, textarea, .three-columns .circle, .create-box .create-link, .bottom-three-columns .more-link, .contact-form span.wpcf7-not-valid-tip, .see-more-link, .account-signup-form .submit, .account-form .submit, .info-blocks .account-form .submit, .management-block .download').each(function() {
			PIE.attach(this);
		});
	}
});