/**
 * @desc menu item form validation
 */

$('#add_menu_item').validate({
	errorElement: 'div',
	errorClass: 'text-danger',

	// ignore: ":hidden:not(.selectpicker)",
	ignore: [],
	rules: {
		name: {
			required: true
		},
		image: {
			required: true
		},
		cuisine_id: {
			required: true
		},
		dish_type: {
			required: true
		},
		description: {
			required: true
		},
		status: {
			required: true
		},
		'quantity_id[]': {
			required: true
		},
		'price[]': {
			required: true
		},
		'category[]': {
			required: true
		}
	},

	submitHandler: function(form) {
		form.submit();
	}
});
