var nowTemp = new Date('2017', '06', '21', 0, 0, 0, 0);
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

var checkin = $('#datetimepicker1').datepicker({
    format: "dd.mm.yyyy",
    onRender: function (date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
    checkin.hide();
    $('#datetimepicker2')[0].focus();
}).data('datepicker');
var checkout = $('#datetimepicker2').datepicker({
    format: "dd.mm.yyyy",
    onRender: function (date) {
        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    checkout.hide();
}).data('datepicker');



$('body').on('click','.back2',function(){
    $(".step2").hide();
    $(".step1").show();

});

$(".back3").click(function () {
    $(".step2").show();
    $(".step3").hide();
});







/*******************************************************************************ADD OFFER AND PRICE JAVASCRIPT CODE ****************************************** */

$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var HANDLE_PRODUCT_ADD = {


    errors: {

        "product_required": "Please enter product name",
        "qty_field_required": "Please enter offered price.",
        "greater_qty_field_required":"Offer price is greater then actual price"
    },


    __fetch_typed_products: function (searchTerm, catid, response) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/store-offer/show-product',

            data: { term: searchTerm, category_id: catid },

            beforeSend: function () {
                $("#search_loader").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                response(data);

            },
            complete: function () {
                $("#search_loader").html('');
            }

        });
    },


    __fetch_quantity_product: function (id, product_id) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/store-offer/get-offer-edit-html',

            data: { id: id, product_id: product_id },

            dataType: 'json',

            beforeSend: function () {

                $("#nex_button_select_qty").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                if (parseInt(data.code) == 200) {

                    $("#step_two_div_section").html(data.html);
                    $(".step2").show();
                    $(".step1").hide();

                } else if (parseInt(data.code) == 422) {

                    swal(data.messages);

                }

            },

            complete: function () {

                $("#nex_button_select_qty").html("Next");


            },
            error: function () {
                alert('Something went wrong. Please try again');
            }

        });

    },


    _fetch_add_more_html: function (product_id) {



        $.ajax({

            type: 'GET',

            url: 'ajax-request/store-offer/add-more-offer',

            data: { product_id: product_id },

            dataType: 'json',

            beforeSend: function () {

                $("#nex_button_select_qty").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                if (parseInt(data.code) == 200) {

                    $(".divappend").append(data.html);

                } else if (parseInt(data.code) == 422) {

                    swal(data.messages);

                }

            },

            complete: function () {

                $("#nex_button_select_qty").html("Next");


            },
            error: function () {
                alert('Something went wrong. Please try again');
            }

        });

    },

    __submit_product_price_qty : function(id,data) {


        $.ajax({

            type: 'POST',

            url: 'ajax-request/update-offer/submit-product-offer-data',

            data: {id:id,data:data},

            beforeSend: function () {

                $("#show_preview_data").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            dataType: 'json',


            success: function (data) {


                if (parseInt(data.code) == 200) {

                    $(".step2").hide();
                    $(".step3").show();

                } else {
                    swal(data.message);
                }

            },
            complete: function () {
                $("#show_preview_data").html('Next');
            },

            error: function () {
                alert('Something went wrong. Please try again');
            }

        });





    },



    __submit_product_data: function (id,data) {


        $.ajax({

            type: 'POST',

            url: 'ajax-request/store-offer/update-offer-date',

            data: {id:id,data:data},

            beforeSend: function () {

                $("#step_three_add_date").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            dataType: 'json',


            success: function (data) {


                if (parseInt(data.code) == 200) {
                    window.location = 'offer-list';
                }

            },
            complete: function () {
                $("#step_three_add_date").html('Finish');
            },

            error: function () {
                alert('Something went wrong. Please try again');
            }

        });

    }

}


function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}


$("#searchproduct").autocomplete({
    source: function (request, response) {

        $('#error_product_search').html('');
        var catid = $("#selected_cat_id :selected").val();
        HANDLE_PRODUCT_ADD.__fetch_typed_products(request.term, catid, response)
    },
    select: function (event, ui) {

        if (ui.item.id) {
            $('#searchproduct').val(ui.item.value); // display the selected text
            $('#searchproduct_id').val(ui.item.id); // save selected id to hidden input
            $("#product_id").val(ui.item.product_id);
        } else {
            // alert("sasadd");
            $('#addProductModal').modal('show');
        }

        return false;
    },
    change: function (event, ui) {
        $("#searchproduct_id").val(ui.item ? ui.item.id : 0);
        $("#product_id").val(ui.item ? ui.item.product_id : 0);
    },
    minLength: 2,
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {

            return (item.id) ? $('<li>')
                .append("<a><figure><img src='" + item.image + "'></figure><div class='detail'><label>" + item.value + '</label><span> THC :' + item.thc + '  CBD :' + item.cbd + "</span></div></a>")
                .appendTo(ul) : ((typeof item.value != 'undefined') ? $('<li>').append("<a>" + item.value + "</a>").appendTo(ul) : $('<li>'));

        };
    }
});




// driver function for all //
$("body").on('change', '#selected_cat_id', function () {
    $("#searchproduct").val('');
    $("#searchproduct_id").val(0);
    $("#product_id").val(0);
});


$(window).load(function () {
    var id = $('#searchproduct_id').val();
    var product_id = $("#product_id").val();
    // console.log([$(this).val(),'sdsd']);
    
    if (!id || "" == $('#searchproduct').val()) {
        swal({
            title:"Offered Product",
            text:HANDLE_PRODUCT_ADD.errors.product_required})
        return false;
    }
    HANDLE_PRODUCT_ADD.__fetch_quantity_product(id, product_id);
});


$('body').on('click', '#nex_button_select_qty', function () {
    var id = $('#searchproduct_id').val();
    var product_id = $("#product_id").val();
    // console.log([$(this).val(),'sdsd']);
    
    if (!id || "" == $('#searchproduct').val()) {
        swal({
            title:"Offered Product",
            text:HANDLE_PRODUCT_ADD.errors.product_required})
        return false;
    }
    HANDLE_PRODUCT_ADD.__fetch_quantity_product(id, product_id);
});
$('body').on('click', '#show_preview_data', function () {
    $("#error_submit_qty").html("");
    var id = $("#searchproduct_id").val();


    var is_price_filled = true;

    // $('.add-product').each(function () {
    //     var price = $(this).val();

    //     if ($.trim(price) == "") {

    //         is_price_filled = false;
    //     }
    // });


    var count = 0;
    var is_greater_price = true
    $('.offered-price').each(function () {
        var offer_price = $(this).val();
        var actual_price =  $(this).attr('actual_price');

        if ($.trim(offer_price) != "") 
        {
            ++count;
        }
        if(parseInt(offer_price) > parseInt(actual_price))
        {
            is_greater_price = false;
        }
    });
    if(count == 0)
    {
        is_price_filled = false;
    }
    if(!is_greater_price)
    {
        swal({
            title: "Offer price",
            text: HANDLE_PRODUCT_ADD.errors.greater_qty_field_required,
            cancelButton:true});
            return false;
    }

    if (!is_price_filled) {

        swal({
            title: "Offer price",
            text: HANDLE_PRODUCT_ADD.errors.qty_field_required,
            cancelButton:true});
            return false;
    }


    var data = {
        id : [],
        actual_price : [],
        offered_price : [],
        unitoffers : [],
        stock_unit_id:[]

    };
    

    $('.add-product').each(function () {
        let price = $(this).val();
        data.actual_price.push(price);
    });


    $('.offered-price').each(function () {
        let price = $(this).val();
        data.offered_price.push(price);
    });

    $('.add-product-stock-unit').each(function () {
        let stockUnit = $(this).val();
        data.stock_unit_id.push(stockUnit);
    });

    $('.select_option_offer').each(function(){

        let hidden_quant = $(this).children('option:selected').val();
        let hidden_quant_unit = $(this).children('option:selected').attr('data-unit');
        let id = $(this).children('option:selected').attr('data-id');

        data.unitoffers.push({"qty":hidden_quant,"unit":hidden_quant_unit,"id":id});

    });

    HANDLE_PRODUCT_ADD.__submit_product_price_qty(id,data);

});

var add_counter = 1;

$('body').on('click', '#add-more', function () {

    var productId = $("#product_id").val();

    HANDLE_PRODUCT_ADD._fetch_add_more_html(productId);

})

$("body").on('click','#step_three_add_date',function(){

    var id = $("#searchproduct_id").val();

    let startDate =$("#datetimepicker1").val();
    let endDate = $("#datetimepicker2").val();

    if($.trim(startDate) == "" || $.trim(endDate) == "") {

        swal("Please provide offer start and end date.");
        return false;
    }


    var data = {
        end : "",
        start : ""
    };

    data.start = $("#datetimepicker1").val();
    data.end = $("#datetimepicker2").val();


    HANDLE_PRODUCT_ADD.__submit_product_data(id,data);
    

});

$("body").on('click', '.prdctdelete', function () {
    $(this).closest('.form-group').remove();
});



$('body').on('click','.delete-icon',function(){
    var elem = $(this).closest('.form_wrapper');
    elem.remove();
});



