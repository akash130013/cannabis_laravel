var STEP_TWO_HANDLING = {

    formID: "#submit_step_two_form",

    glovalHtml : "",


    __run_validation_for_time_with: function () {
        $("#error_working_hours").html('');
        var _global_is_checked = false;
        var is_valid = true;
        $('.root').each(function () {
            var is_checked = false;
            if ($(this).find('.checkDays').is(':checked')) {
                _global_is_checked = true;
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
                var opening_time_second = "";
                var closing_time_second = "";
                var opening_time_second_after_convert = "";
                var closing_time_second_after_convert = "";

                $(this).find('.rootInner').each(function () {
                    if (i == 0) {
                        day = $(this).data('day');
                    }
                    if ($.trim($(this).find('.opening_time').val()) == "" || $.trim($(this).find('.closing_time').val()) == "") {
                        is_valid = false;
                        return false;
                    } else {

                        if (root_inner_length == 3) {

                            if (opening_time == "" && closing_time == "") {
                                opening_time = $.trim($(this).find('.opening_time').val()).split(":");
                                opening_time_after_convert = (parseInt(opening_time[0] * 60) + parseInt(opening_time[1]));
                                closing_time = $.trim($(this).find('.closing_time').val()).split(":");
                                closing_time_after_convert = (parseInt(closing_time[0] * 60) + parseInt(closing_time[1]));
                                if (opening_time_after_convert >= closing_time_after_convert) {
                                    is_valid = false;
                                    return false;
                                }
                            } else if (opening_time_second == "" && closing_time_second == "") {

                                opening_time_second = $.trim($(this).find('.opening_time').val()).split(":");
                                opening_time_second_after_convert = (parseInt(opening_time_second[0] * 60) + parseInt(opening_time_second[1]));
                                if (closing_time_after_convert >= opening_time_second_after_convert) {
                                    is_valid = false;
                                    return false;
                                } else {
                                    closing_time_second = $.trim($(this).find('.closing_time').val()).split(":");
                                    closing_time_second_after_convert = (parseInt(closing_time_second[0] * 60) + parseInt(closing_time_second[1]));
                                    if (opening_time_second_after_convert >= closing_time_second_after_convert) {
                                        is_valid = false;
                                        return false;
                                    }
                                }

                            } else {

                                let opening_time_third = $.trim($(this).find('.opening_time').val()).split(":");
                                let opening_time_third_after_convert = (parseInt(opening_time_third[0] * 60) + parseInt(opening_time_third[1]));
                                if (closing_time_second_after_convert >= opening_time_third_after_convert) {
                                    is_valid = false;
                                    return false;
                                } else {
                                    let closing_time_third = $.trim($(this).find('.closing_time').val()).split(":");
                                    let closing_time_third_after_convert = (parseInt(closing_time_third[0] * 60) + parseInt(closing_time_third[1]));
                                    if (opening_time_third_after_convert >= closing_time_third_after_convert) {
                                        is_valid = false;
                                        return false;
                                    }
                                }

                            }

                        }

                        else if (root_inner_length == 2) {
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
                                opening_time_second = $.trim($(this).find('.opening_time').val()).split(":");
                                opening_time_second_after_convert = (parseInt(opening_time_second[0] * 60) + parseInt(opening_time_second[1]));
                                if (closing_time_after_convert >= opening_time_second_after_convert) {
                                    is_valid = false;
                                    return false;
                                } else {
                                    closing_time_second = $.trim($(this).find('.closing_time').val()).split(":");
                                    closing_time_second_after_convert = (parseInt(closing_time_second[0] * 60) + parseInt(closing_time_second[1]));
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
                $("#error_working_hours").html(string.incorrectWorkingHourForm + full_month_name[day]);
                return false;
            }

        });

        if (!_global_is_checked) {
            $("#error_working_hours").html(string.error_empty_submit_timing);
            return false;
        }
        if (is_valid) {
            var tab = $("#hidden_tab_value").val();
            STEP_TWO_HANDLING.__ajx_call_for_submitting_dine_type_information(STEP_TWO_HANDLING.formID, tab);
        }
    },

    __ajx_call_for_submitting_dine_type_information: function (formele, tab) {

        var $forele = $(formele);
        $.ajax({
            type: "GET",
            cache: false,
            url: $forele.attr('action'),
            data: $forele.serialize(),
            dataType: 'json',
            success: function (response) {

                if (parseInt(response.code) == 200) {
                    $("#" + tab).html(response.dataHtml);
                    $("#myModalrt-time").modal('hide');
                    $("#is_working_hours_submitted").val(1);
                } else {
                    alert(response.message);
                    return false;
                }
            }
        });

    },

    _populate_pre_existing_working_hours : function(formele, tab){

        var $forele = $(formele);
        $.ajax({
            type: "GET",
            cache: false,
            url: 'get-service-timings',
            data: $forele.serialize(),
            dataType: 'json',
            success: function (response) {

                    if(parseInt(response.code) == 200) {

                        if(response.data && response.data.service_days.length > 0) {
                            var html = '<tr class="timeslot_heade">'+
                            '<td>Day </td>'+
                            '<td> Select Day</td>'+
                            '<td colspan="2">'+
                            '<table class="td_header">'+
                                  '<tbody>'+
                                     '<tr class="rootInner" data-day="mon">'+
                                        '<td>Open Time'+
                                        '</td>'+
                                        '<td>'+
                                           'Close Time'+
                                        '</td>'+
                                     '</tr>'+
                                  '</tbody>'+
                               '</table>'+
                            '</td>'+
                         '</tr>';
                            $.each(response.data.service_days,function(index,val){

                                var openinghtml = "";
                                html += ' <tr class="root">'+
                                '<td style="vertical-align:middle"> '+val.display_day+' </td>';
                                var disableField = "disabled";
                                if(parseInt(val.is_selected)) {
                                    html += '<td style="vertical-align:middle;" class="text-center">'+
                                                '<input type="checkbox" checked class="checkDays filter-type filled-in" name="rtiming['+val.day+']" value="0" id="Mondayr">'+ 
                                            '</td>';
                                    disableField = ""
                                } else {
                                    html += '<td style="vertical-align:middle;" class="text-center">'+
                                                '<input type="checkbox" class="checkDays filter-type filled-in" name="rtiming['+val.day+']" value="0" id="Mondayr">'+ 
                                            '</td>';

                                }    
                               
                                
                                html +='<td colspan="2">'+
                                   '<table id="red_tab_0">'+
                                      '<tbody>';

                                  var openingDays = $.parseJSON(val.start_time);
                                  var closingDays = $.parseJSON(val.end_time);


                                  if(openingDays.morning) {

                                    openinghtml = '<tr class="rootInner" data-day="'+val.day+'">'+
                                    '<td>'+
                                       '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                          '<input alt="0" class="form-control timep opening_time" size="16" name="rtiming['+val.day+'][opening_hours][morning]" type="text" value="'+openingDays.morning+'" placeholder="Open" '+disableField+'>'+
                                          '<span class="input-group-addon">'+
                                          '<span class="glyphicon glyphicon-time"></span>'+
                                          '</span>'+
                                       '</div>'+
                                       '<label class="err_message_time"></label>'+
                                    '</td>';

                                  }

                                  if(closingDays.morning) {

                                    openinghtml +=  '<td>'+
                                    '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                       '<input class="eTime form-control timep closing_time" size="16" name="rtiming['+val.day+'][closing_hours][morning]" type="text" value="'+closingDays.morning+'" placeholder="Close" '+disableField+'>'+
                                       '<span class="input-group-addon">'+
                                       '<span class="glyphicon glyphicon-time"></span>'+
                                       '</span>'+
                                    '</div>'+
                                            '<label class="err_message_time"></label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<span class="add-icon">'+
                                            '<i class="fa fa-plus" aria-hidden="true"></i>'+
                                            '</span>'+
                                        '</td>'+
                                    '</tr>';
                                  }





                                  if(openingDays.evening) {

                                    openinghtml += '<tr class="rootInner" data-day="'+val.day+'">'+
                                    '<td>'+
                                       '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                          '<input alt="0" class="form-control timep opening_time" size="16" name="rtiming['+val.day+'][opening_hours][evening]" type="text" value="'+openingDays.evening+'" placeholder="Open" '+disableField+'>'+
                                          '<span class="input-group-addon">'+
                                          '<span class="glyphicon glyphicon-time"></span>'+
                                          '</span>'+
                                       '</div>'+
                                       '<label class="err_message_time"></label>'+
                                    '</td>';

                                  }

                                  if(closingDays.evening) {

                                    openinghtml +=  '<td>'+
                                    '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                       '<input class="eTime form-control timep closing_time" size="16" name="rtiming['+val.day+'][closing_hours][evening]" type="text" value="'+closingDays.evening+'" placeholder="Close" '+disableField+'>'+
                                       '<span class="input-group-addon">'+
                                       '<span class="glyphicon glyphicon-time"></span>'+
                                       '</span>'+
                                    '</div>'+
                                            '<label class="err_message_time"></label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<span class="add-icon">'+
                                            '<i class="fa fa-minus" aria-hidden="true"></i>'+
                                            '</span>'+
                                        '</td>'+
                                    '</tr>';
                                  }

                                  if(openingDays.night) {

                                    openinghtml += '<tr class="rootInner" data-day="'+val.day+'">'+
                                    '<td>'+
                                       '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                          '<input alt="0" class="form-control timep opening_time" size="16" name="rtiming['+val.day+'][opening_hours][night]" type="text" value="'+openingDays.night+'" placeholder="Open" '+disableField+'>'+
                                          '<span class="input-group-addon">'+
                                          '<span class="glyphicon glyphicon-time"></span>'+
                                          '</span>'+
                                       '</div>'+
                                       '<label class="err_message_time"></label>'+
                                    '</td>';

                                  }


                                  if(closingDays.night) {

                                    openinghtml +=  '<td>'+
                                    '<div class="input-group date form_time col-md-7 m-xs" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">'+
                                       '<input class="eTime form-control timep closing_time" size="16" name="rtiming['+val.day+'][closing_hours][night]" type="text" value="'+closingDays.night+'" placeholder="Close" '+disableField+'>'+
                                       '<span class="input-group-addon">'+
                                       '<span class="glyphicon glyphicon-time"></span>'+
                                       '</span>'+
                                    '</div>'+
                                            '<label class="err_message_time"></label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<span class="add-icon">'+
                                            '<i class="fa fa-minus" aria-hidden="true"></i>'+
                                            '</span>'+
                                        '</td>'+
                                    '</tr>';
                                  }

                                     html += openinghtml+  '</tbody>'+
                                   '</table>'+
                                '</td>'+
                                '<td style="vertical-align:middle">'+
                                '</td>'+
                             '</tr>';

                            });
                           
                            $("#table_dynamic_html").html(html);

                        } else {

                           $("#table_dynamic_html").html(STEP_TWO_HANDLING.glovalHtml);
                        }
                            

                    }
            }
        });



    }
}



// handle click event on modal save button //

$('body').on('click', '#submit_timings', function () {
  STEP_TWO_HANDLING.__run_validation_for_time_with();
});



$('body').on('click', 'input[name="service[]"]', function () {

    var ID = $(this).attr('data-service_id');
    var newServiceID = $(this).attr('data-service-avail');
    $("#new_service_id").val(newServiceID);
    $("#hidden_service_id").val(ID);
    $("#myModalrt-time").modal('show');
    $("#hidden_tab_value").val("");
});

$('body').on('click', '#cancel_timing_submit', function (e) {
    $("#error_working_hours").html('');
    $("#submit_step_two_form")
        .find("input,textarea,select")
        .val('')
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end();
});


$("#myModalrt-time").on('show.bs.modal', function(){
    var tab = $("#hidden_tab_value").val();
    STEP_TWO_HANDLING._populate_pre_existing_working_hours(STEP_TWO_HANDLING.formID,tab);
 });

$('body').on('click','#next_submit_button',function(){

    var url = $(this).attr('data-url');
    var formData = $(".flex-row").length;
    if(formData > 0) {
        window.location = url;
    } else {
        $("#myModal-congratulation").modal('show');
    }

});

$(document).ready(function(){
    STEP_TWO_HANDLING.glovalHtml = $("#table_dynamic_html").html();
});













