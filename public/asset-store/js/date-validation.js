/**
 * @desc validation start and end date
 * @date 08/02/2018
 * 
 */
$('#datetimepicker1').datetimepicker({
    format: "YYYY-MM-DD",
}).on('dp.change', function (e) {
    var incrementDay = moment(new Date(e.date));
    incrementDay.add(0, 'days');
    $('#datetimepicker2').data('DateTimePicker').minDate(incrementDay);
    $(this).data("DateTimePicker").hide();
});

$('#datetimepicker2').datetimepicker({
    format: "YYYY-MM-DD",
}).on('dp.change', function (e) {
    var decrementDay = moment(new Date(e.date));
    decrementDay.subtract(0, 'days');
    $('#datetimepicker1').data('DateTimePicker').maxDate(decrementDay);
    $(this).data("DateTimePicker").hide();
});