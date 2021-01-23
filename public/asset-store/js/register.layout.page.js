let i = 0,
            form_length, formpart, d;
        $('.nextBtn').on('click', function(e) {
            e.preventDefault();
            i++;
            d = $(this).data('datac');
            // console.log(d);
            formpart = $(this).parent().parent().parent().parent().parent().parent('.stepForm').index();
            // console.log();
            form_length = $('.stepForm').length;
            // console.log(form_length);
            $(".tabularProMenu ol li").eq(formpart - 1).removeClass('active');
            $(".tabularProMenu ol li").eq(formpart).addClass('active');

            $(".stepForm").eq(formpart - 1).removeClass("active");
            $(".stepForm").eq(formpart).addClass("active");

        });

        var options = {
            now: "12:35", //hh:mm 24 hour format only, defaults to current time
            twentyFour: false, //Display 24 hour format, defaults to false
            upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS
            downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
            close: 'wickedpicker__close', //The close class selector to use, for custom CSS
            hoverState: 'hover-state', //The hover state class to use, for custom CSS
            title: 'Timepicker', //The Wickedpicker's title,
            showSeconds: false, //Whether or not to show seconds,
            timeSeparator: ' : ', // The string to put in between hours and minutes (and seconds)
            secondsInterval: 1, //Change interval for seconds, defaults to 1,
            minutesInterval: 1, //Change interval for minutes, defaults to 1
            beforeShow: null, //A function to be called before the Wickedpicker is shown
            afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
            show: null, //A function to be called when the Wickedpicker is shown
            clearable: false, //Make the picker's input clearable (has clickable "x")
            placeholder: 'Start Time'
        };
        $('.timepicker').wickedpicker(options);