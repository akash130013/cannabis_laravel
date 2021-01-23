//check number validation

function isNumber(evt) {
	evt = evt ? evt : window.event;
	var charCode = evt.which ? evt.which : evt.keyCode;

	if (charCode == 46) {
		return true;
	} else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}


/**
 * @desc used to show fadeout messages
 */


$('.fadeout-error').delay(3000).fadeOut();