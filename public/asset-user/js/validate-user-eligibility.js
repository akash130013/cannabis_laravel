var VALIDATE_COOKIE_FOR_AGE_PROOF = {

    __getExistingCookieValue: function () {
        return Cookies.get('is_age_confirmed');
    },

    __setExistingCookedValue: function () {
        $("#minageconfirm").modal('show');
        Cookies.set('is_age_confirmed', true, { expires: 7, path: '' });
        return true;
    }

}


// driver function to handle pop up //

$('document').ready(
    function () {
        var getCookied = VALIDATE_COOKIE_FOR_AGE_PROOF.__getExistingCookieValue();
        if (getCookied) {
           window.location = $("#user_login_url").val();
           return true;
        }

        $.dobPicker({
            // Selectopr IDs
                daySelector: '#dobday',
                monthSelector: '#dobmonth',
                yearSelector: '#dobyear',

                // Default option values
                dayDefault: 'Day',
                monthDefault: 'Month',
                yearDefault: 'Year',

                // Minimum age
                minimumAge: 21,

                // Maximum age
                maximumAge: 80
        });
    }
);

jQuery.validator.addMethod("validate_dob", function(value, element) {
   
    
    var month=$("#dobmonth").val();
    var day=$("#dobday").val();
     if(month=='' || day==''){
         return false;
     }
     return true;

}, "Please enter a valid Date of birth.");



$("#user_dob_validation_form").validate({
rules: {
    // day: {
    //     required : true,
    //     validate_dob:true,
    // },
    // month: {
    //     required : true,
    // },
    year: {
        required : true,
        validate_dob:true,
    },
  
    remember_me : {
        required : true,
    }

},
errorPlacement: function (error, element) {
    error.appendTo($(("#dob-error")));
},
    messages: {
        remember_me : {
            required : "Please acknowledge the consent",
        },
        year:{
            required:"Please enter a valid Date of birth.",
            validate_dob:"Please enter a valid Date of birth.",
        }
    },

submitHandler: function(form, event) { 
    

    var day=$("#dobday").val();
    var month=$("#dobmonth").val()-1;
    var year=$("#dobyear").val();
    
    var a = moment([moment().get('year'), moment().get('month'), moment().get('date')]);
   
    var b = moment([year, month, day]);
    a.diff(b, 'years');   
    
    var age=a.diff(b, 'years', true);
   
    
    if(age<21){
        $("#minAgeModel").modal('show');
        $("#dobday").val('');
        $("#dobmonth").val('');
        $("#dobyear").val('');
        return false;
    }
    
   
    VALIDATE_COOKIE_FOR_AGE_PROOF.__setExistingCookedValue();

    }
});



