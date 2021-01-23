var operatingHours = $("#default_result").val(); 
    
if($.parseJSON(operatingHours).length) {

    var businessHours = $("#businessHoursContainer3").businessHours({
            operationTime : $.parseJSON(operatingHours),
            postInit:function(){
                $('.operationTimeFrom, .operationTimeTill').timepicker({
                    'timeFormat': 'H:i',
                    'step': 15,
                    "ignoreReadonly": true,
                    template: 'modal'
                    });
            },
            dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                '<div class="weekday"></div>' +
                '<div class="operationDayTimeContainer">' +
                '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
                '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
                '</div></div>'
});
    
} else {
    
    var businessHours = $("#businessHoursContainer3").businessHours({
            postInit:function(){
                $('.operationTimeFrom, .operationTimeTill').timepicker({
                    'timeFormat': 'H:i',
                    'step': 15,
                    "ignoreReadonly": true
                    });
            },
            dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                '<div class="weekday"></div>' +
                '<div class="operationDayTimeContainer">' +
                '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
                '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
                '</div></div>'
});

}


