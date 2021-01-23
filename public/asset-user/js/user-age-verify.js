
//   $('document').ready(function(){
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

//   })
 




$("document").on('change','#dobday',function(){
    // alert("");
    // console.log("kksklslkfsflk");
    
   $("#dobday-error").text('');
})

jQuery.validator.addMethod("validate_dob", function(value, element) {
   
    
    var month=$("#dobmonth").val();
    var day=$("#dobday").val();
     if(month=='' || day==''){
         return false;
     }
     return true;

}, "Please enter a valid Date of birth.");

$("#proof_form_id").validate({
    ignore: [],
    errorClass:'error',
    errorElement:'span',
        rules: {
            file_input_age:  {
                required : true
            },
            year: {
                required : true,
                validate_dob:true,
            },
            // month: {
            //     required : true,
            // },
            // year: {
            //     required : true,
            // },
        },
       
        //  success: function(label,element) {
        //     label.parent().parent().removeClass('error-message');
        //     label.remove(); 
        // },
        // highlight: function (element) {
        //     $(element).parent('div').parent("div").addClass('error-message');
        // },
        // unhighlight: function (element) {
        //     $(element).parent('div').parent('div').removeClass('error-message');
    
        // },
        errorPlacement: function(error, element) {
            // $(element).parent('div').parent("div").addClass('error-message');
            if(element.attr('name')=='file_input_age'){
                error.insertAfter($(element).parent().next('span'));
            }else{
                // error.insertAfter($(element).next());
                error.appendTo($(("#dob-error")));
            }
        },
        messages: {
            file_input_age : {
                required : "Please upload Age document proof"
            },
            year:{
                required:"Please enter a valid Date of birth.",
                validate_dob:"Please enter a valid Date of birth.",
            }
        },
        submitHandler: function (form,event) {

            // event.preventDefault();
            // return false;
            var day=$("#dobday").val();
            var month=$("#dobmonth").val()-1;
            var year=$("#dobyear").val();
            // console.log(day+'-'+month+'-'+year)
            var a = moment([moment().get('year'), moment().get('month'), moment().get('date')]);
            //  console.log(moment().get('date')+'-'+moment().get('month')+'-'+moment().get('year'));
             
            var b = moment([year, month, day]);
            a.diff(b, 'years');   
            
            var age=a.diff(b, 'years', true);
           
            
            if(age<21){
                $("#minAgeModel").modal('show');
                $("#dobday").val('');
                $("#dobmonth").val('')
                $("#dobyear").val('');
                return false;
            }
            
            $("#dob").val(year+'-'+$("#dobmonth").val()+'-'+day);
                $("#submit_button").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                form.submit();
        }
    });


    
  
