var ERROR_TEXT = {
    SERVICE_CHECKBOX_ERROR : 'Please select service type',
    CUINIES_SELECT : 'Please select your cuisines',
    VALID_CANCELLATION_HOURS : 'Please enter valid cancellation hours',
    SERVICE_TYPE_ERROR : 'Please select service type as Dine In for booking cancellations',
    CANCELLATION_HOURS  : 'Please enter cacellations hours'
}

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png",".JPEG",".PNG",".svg"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, Image selected is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}



$('body').on('click','input[name="allow_cancellation"]',function(e){
    e.stopPropagation();
    $("#cancellation_hours").attr('disabled',true);
    $("#cancellation_hours").val('');
    var value = $(this).val();
    var is_dine_checked = $("#service_DINE_IN").is(':checked');

    if(is_dine_checked) {

        if(parseInt(value)) {
            $("#cancellation_hours").attr('disabled',false);
            $("#no").prop('checked',false);
        }

    } else {

        alert(ERROR_TEXT.SERVICE_TYPE_ERROR);
      
        return false;
    }
    
});


$("body").on('click','input[name="service[]"]',function(e){
    e.stopPropagation();
    var val = $(this).val();
    if(!$(this).is(':checked') && parseInt(val) == 1) {
        $('#no').prop('checked',true);
        $('#yes').prop('checked',false);
        $("#cancellation_hours").val('');
        $("#cancellation_hours").prop('disabled',true);
    }   
});


// handle step one submit button custom validations //
$("body").on('click','#proceed_button_step_one',function(){

    $("#error_service_checkbox").html('');
    $("#error_cusine_selected").html('');
    $("#cancellation_housr_error").html('');

    var is_service_checked = false;
    $('input[name="service[]"]').each(function(index,ele){
        if($(ele).is(':checked')) {
            is_service_checked = true;
        }
    });


    if(!is_service_checked) {
        $("#error_service_checkbox").html(ERROR_TEXT.SERVICE_CHECKBOX_ERROR);
        return false;
    }

    var is_cuinies_select = $("#select_cuisines_id").val();

    if(!is_cuinies_select) {
        $("#error_cusine_selected").html(ERROR_TEXT.CUINIES_SELECT);
        return false;
    }

    var is_cancellation_allowed = $('input[name="allow_cancellation"]:checked').val();

    if(parseInt(is_cancellation_allowed) == 1) {
        var check_valid_cancellation_hours = $("#cancellation_hours").val();

        if($.trim(check_valid_cancellation_hours) == "") {
            $("#cancellation_housr_error").html(ERROR_TEXT.CANCELLATION_HOURS);
            return false;
        }

        if(parseInt(check_valid_cancellation_hours) <= 0) {
            $("#cancellation_housr_error").html(ERROR_TEXT.VALID_CANCELLATION_HOURS);
            return false;
        }
    }

    $("#submit_form_step_one").submit();

});


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
 }