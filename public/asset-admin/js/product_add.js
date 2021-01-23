

$("#admin_products").validate({
    ignore: [],
    errorElement: 'span',
    errorClass: 'error',
    rules: {
        product_name: {
            required: true,
            maxlength: 150
        },
        category: {
            required: true

        },
        "qty[quant_units][]": {
            required: true,
        },
        thc_per: {
            required: true,
            maxlength: 5
        },
        cbd_per: {
            required: true,
            maxlength: 5,

        },
        imgUploadCheck: {
            required: true
        },


    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "qty[quant_units][]") {
            error.appendTo(element.next("div"));
        } else {
            error.insertAfter(element);
        }
    },
    messages: {
        "qty[quant_units][]": {
            required: "The field is required"
        }
    },
    submitHandler: function (form) {

       var values = $(".qtyValidate")
       .map(function(){return $(this).val();}).get();
       if(values.length==0){
           alert("Please add atleat one unit and size");
           return false;
       }
       
        let status= validateProduct();
        if(status[0]==false){
            $("#submit-btn").attr('disabled',true);
            $("#submit-btn").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
            form.submit();
        }else{
           $("#qty_error").html(status[1]).css("display","block");
        }

    }
});


/**
 * @desc hide error of category
 */
$("body").on('change', '#category', function(){
   
     $("#category-error").html("");
})

function isFloatNumber(item, evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1) {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}




var validateProduct= () =>{
   
    var sizeArr=[];
    let flag = false;
    var message = 'You can not add duplicate unit and size';
    $('.qtyValidate').each(function(){

        if($(this).val() <= 0)
        {
            flag = true;
        }
        sizeArr.push($(this).val()+'-'+$(this).closest('.row').find('select.unit').val());
    });
    if(flag == true)
    {
        message = 'Please enter a valid size'
        return [true,message];
    }
    return [new Set(sizeArr).size !== sizeArr.length,message];
}