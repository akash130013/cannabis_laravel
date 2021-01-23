$(document).ready(function() {
	var dateNow = new Date();
	$("body").on("click focus", '.form_time', function() {
		//alert("hello");
		$(this).datetimepicker({
			format: 'HH:mm',
			stepping: '15',
			defaultDate:'Mon Feb 05 2018 00:00:00 GMT+0530 (IST)'
		});
	});
	//Checkbox Check 

	$('body').on('change', '.checkDays', function() {
		if ($(this).is(':checked')) {
			$(this).closest('tr').find('input[type="text"]').prop('disabled', false);
			$(this).closest('tr').find('.opening_time').parent('.form_time').datetimepicker({
				format: 'HH:mm',
				stepping: '15',
				defaultDate:'Mon Feb 05 2018 09:00:00 GMT+0530 (IST)'
			});
			$(this).closest('tr').find('.closing_time').parent('.form_time').datetimepicker({
				format: 'HH:mm',
				stepping: '15',
				defaultDate:'Mon Feb 05 2018 22:00:00 GMT+0530 (IST)'
			});
		} else {
			$(this).closest('tr').find('input[type="text"]').prop('disabled', true);
		}
	});
	
	$('body').on('click', '.add-icon', function() {
		
		var data_day = 0;
		if ($(this).parents('.root').find('input[type="checkbox"]').is(':checked')) {
			var total_rows = 0
			var row_append = true;
			$(this).parents('.root').find('.rootInner').each(function(key, value) {
				if (total_rows == 0) {
					
					data_day = $(this).attr('data-day');
				}
				if ($.trim($(this).find('.opening_time').val()) == "" || $.trim($(this).find('.closing_time').val()) == "") {
					row_append = false;
				}
				total_rows++;
			});
			if (total_rows < 3 && row_append == true) {
				$(this).closest('tbody').append('<tr class="rootInner">' + $(this).parents('.rootInner')
				.html() + '</tr>');
			}
		}
		$(this).parents('.root').find('.rootInner').each(function(key, value) {
			if (key == 1) {
				$(this).find('.add-icon').removeClass('add-icon').addClass('remove-icon');
				$(this).find('.fa').removeClass('fa-plus').addClass('fa-minus');
				$(this).find('.opening_time').attr('name', 'rtiming['+data_day+'][opening_hours][evening]');
				$(this).find('.closing_time').attr('name', 'rtiming['+data_day+'][closing_hours][evening]');
			} else if(key == 2) {
				$(this).find('.add-icon').removeClass('add-icon').addClass('remove-icon');
				$(this).find('.fa').removeClass('fa-plus').addClass('fa-minus');
				$(this).find('.opening_time').attr('name', 'rtiming['+data_day+'][opening_hours][night]');
				$(this).find('.closing_time').attr('name', 'rtiming['+data_day+'][closing_hours][night]');
			}
		});

	});
	$('body').on('click', '.remove-icon', function() {
		$(this).closest('tr').remove();
	});
	
	$("input[name='contact_number']").keyup(function() {
		var maxChars = 10;
		if ($(this).val().length > maxChars) {
			$(this).val($(this).val().substr(0, maxChars));
		}
	});
	
	$("input[name='alternate_contact_number']").keyup(function() {
		var maxChars = 10;
		if ($(this).val().length > maxChars) {
			$(this).val($(this).val().substr(0, maxChars));
		}
	});
});


$(document).ready(function() {
	$('.formTab a').click(function() {
		$('.formTab a').removeClass('active');
		$('.formPane').removeClass('in');
		$(this).addClass('active');
		var _target = $(this).attr('data-id');
		$(_target).addClass('in');
	})
});
$('#myModalrt-time').on('hidden.bs.modal', function (e) {
  var temp_var = 0;
	$('.checkDays').each(function() {
		if ($(this).is(':checked')) {
			temp_var = 1;
		}
	});
	if (temp_var == 0) {
		$('#working_hours_display_error-error').html("<span class='special_handling_working_hours'>"+string.mentionHorkingHours+ "</span>");
	} else {
			$('.root').each(function() {
			var is_checked = false;
			if ($(this).find('.checkDays').is(':checked')) {
				is_checked = true;
			} else {
				is_valid = true;
			}
			
			if (is_checked) {
				var i = 0;
				var day = "";
				var root_inner_length = $(this).find('.rootInner').length;
				var opening_time = "";
				var opening_time_after_convert = "";
				var closing_time = "";
				var closing_time_after_convert = "";
				$(this).find('.rootInner').each(function() {
					if (i == 0) {
						day = $(this).data('day');
					}
					working_hours = "<span class='special_handling_working_hours'>"+ string.incorrectWorkingHourForm +full_month_name[day]+"</span>";
					if ($.trim($(this).find('.opening_time').val()) == "" || $.trim($(this).find('.closing_time').val()) == "") {
						is_valid = false;
						return false;
					} else {
						if (root_inner_length == 2) {
							if (opening_time == "" && closing_time == "") {
								opening_time = $.trim($(this).find('.opening_time').val()).split(":");
								opening_time_after_convert = (parseInt(opening_time[0] * 60) + parseInt(opening_time[1]));
								closing_time = $.trim($(this).find('.closing_time').val()).split(":");
								closing_time_after_convert = (parseInt(closing_time[0] * 60) + parseInt(closing_time[1]));
								if (opening_time_after_convert >= closing_time_after_convert) {
									is_valid = false;
									return false;
								}
							} else {
								var opening_time_second = $.trim($(this).find('.opening_time').val()).split(":");
								var opening_time_second_after_convert = (parseInt(opening_time_second[0] * 60) + parseInt(opening_time_second[1]));
								if (closing_time_after_convert >= opening_time_second_after_convert) {
									is_valid = false;
									return false;
								} else {
									var closing_time_second = $.trim($(this).find('.closing_time').val()).split(":");
									var closing_time_second_after_convert = (parseInt(closing_time_second[0] * 60) + parseInt(closing_time_second[1]));
									if (opening_time_second_after_convert >= closing_time_second_after_convert) {
										is_valid = false;
										return false;
									}
								}
							}
						} else {
							opening_time = $.trim($(this).find('.opening_time').val()).split(":");
							opening_time_after_convert = (parseInt(opening_time[0] * 60) + parseInt(opening_time[1]));
							closing_time = $.trim($(this).find('.closing_time').val()).split(":");
							closing_time_after_convert = (parseInt(closing_time[0] * 60) + parseInt(closing_time[1]));
							if (opening_time_after_convert >= closing_time_after_convert) {
								is_valid = false;
								return false;
							}
						}
					}
					is_valid = true;
					i++;
				});
			}
			if (is_valid == false) {
				return false;
			}
		});
		if (is_valid == false) {
			$('#working_hours_display_error-error').html(working_hours);
			
		} else {
			$('#working_hours_display_error-error').html("");
		}		
	}
});
	jQuery.validator.addMethod("working_hours", function(value, element) {
	var temp_var = 0;
	$('.checkDays').each(function() {
		if ($(this).is(':checked')) {
			temp_var = 1;
		}
	});
	if (temp_var == 0) {
			return false;
	} else {
		return true;		
	}
}, "<span class='special_handling_working_hours'>"+string.mentionHorkingHours+"</span>");

jQuery.validator.addMethod("validate_polygon", function(value, element) {
	var radius_data_for_validate = $('#radius').val();
	var radius_arr = radius_data_for_validate.split("--");
	if (radius_arr.length < 3) {
		return false;
	} else {
		return true;
	}
}, "<span class='special_handling_working_hours'>"+string.invalidPolygon+"</span>");

jQuery.validator.addMethod("one_image_validate", function(value, element) {
		var upload_button_count = 0;
		$('.uploadBtnRestImage').each(function() {
			upload_button_count++
		});
		if(upload_button_count == 1) {
			return false;
		} else {
			return true;
		}
}, "<span class='special_handling_multiple_images'>"+string.requiredField+"</span>");

jQuery.validator.addMethod("validate_latitude", function(value, element) 
{
		if ($('#latitude').val() == "" || $('#longitude').val() == "") {
			return false;
		} else {
			return true;
		}
}, "<span class='special_handling_multiple_images'>"+string.PutCorrectAddress+"</span>");
var is_valid = false;
var working_hours = "";
var full_month_name = JSON.parse(string['DAY_FULL_FORM_JSON']);


function UpdateQueryString(key, value, url) 
{
    if (!url) url = window.location.href;
    var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
        hash;

    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            hash = url.split('#');
            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
    } else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?';
            hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}
