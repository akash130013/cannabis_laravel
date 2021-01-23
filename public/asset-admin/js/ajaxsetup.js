$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

var ajaxBeforSend = function() {
	$('.loader').fadeIn();
};

var ajaxSuccess = function() {
	$('.loader').fadeOut();
};

var ajaxError = function() {
	$('.loader').fadeOut();
};
