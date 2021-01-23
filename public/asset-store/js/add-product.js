$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var HANDLE_PRODUCT_ADD = {


    errors: {

        "product_required": "Please enter product name",
        "qty_field_required": "Please enter valid price(Upto 10000 $) and quantity(Upto 10000)",
        "offered_price_validation": "Offered Price should be less than actual price",
        "duplicate_variety":"Please select different option of size/unit",
        "empty_description":"Please enter product description"
    },


    __fetch_typed_products: function (searchTerm, catid, response) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/show-product',

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


    __fetch_quantity_product: function (product_id) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/get-product-qty',

            data: { id: product_id },

            dataType: 'json',

            beforeSend: function () {

                $("#nex_button_select_qty").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                if (parseInt(data.code) == 200) {

                    var $html = '';

                    $.each(data.data.quantity_json, function (index, val) {
                        $html += '<option value="' + val.quant_units + '" data-quant_unit="' + val.quant_units + '" data-unit="' + val.unit + '"   class="selectedIndex">' + val.quant_units + ' ' + val.unit + '</option>';
                    });

                    $("#quantity_data").html($html);
                    $(".addnewproduct-screen").css("display", "none");
                    $(".addnewproduct-screen-second").css("display", "block");


                } else if (parseInt(data.code) == 422) {

                    $('#error_product_search').html(data.messages);

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

    __submit_product_price_qty: function (product_id) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/get-product-images-data',

            data: { id: product_id },

            dataType: 'json',

            beforeSend: function () {

                $("#show_preview_data").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                if (parseInt(data.code) == 200) {
                //    console.log(data.data);

                    var $html = '<div class="col-md-8 col-sm-8 col-xs-12">' +
                        '<div class="prdctHeader">' +
                        '<h3>' + data.data.product_name + '</h3>' +

                        '<p>THC: ' + data.data.thc_per + '% CBD: ' + data.data.cbd_per + '%</p>' +

                        '<span>'+data.data.category_name+'</span>'+
                        '</div>' +
                        '<div class="prdctDesp">' +
                        '<h5>Quantity & Price</h5>' +
                        '<div class="prdctQuantity">';


                    // loop over the data for the set of added products //

                    var $hidden_html = "";
                    var index = 0;

                    $('input[name="price[quant_price]"]').each(function () {

                        let hidden_quant = $('select[name="price[choice]"]').eq(index).children('option:selected').val();
                        let hidden_quant_unit = $('select[name="price[choice]"]').eq(index).children('option:selected').attr('data-unit');

                        let price = $(this).val();
                        let price_pack = $('input[name="price[pack]"]').eq(index).val();
                        let offered_price = $('input[name="price[offered]"]').eq(index).val();

                        $html += '<div class="product">' +
                            '<div class="pd-brdr">' +
                            '<span>' + hidden_quant + ' ' + hidden_quant_unit.substring(0, 1) + '</span>' +
                            '</div>' +
                            '<p>$' + price + ' (' + price_pack + ' pac.)</p></div>';

                        $hidden_html += '<input type="hidden" name="price[unit][]" value="' + hidden_quant_unit + '">';
                        $hidden_html += '<input type="hidden" name="price[quant_unit][]" value="' + hidden_quant + '">';
                        $hidden_html += '<input type="hidden" name="price[price][]" value="' + price + '">';
                        $hidden_html += '<input type="hidden" name="price[offered][]" value="' + offered_price + '">';
                        $hidden_html += '<input type="hidden" name="price[packet][]" value="' + price_pack + '">';
                        ++index;

                    });

                    $hidden_html += '<input type="hidden" id="hidden_pro_description" name="pro_desc" value="' + data.data.product_desc + '">';

                    $html +=
                        '</div>' +
                        '</div><div class="additionInfo">' +
                        '<h5>Additional Description</h5>' +
                        '<div class="form-group">' +
                        '<textarea class="add_description" required cols="30" id="text_area_data" name="pro_desc" maxlength="500" rows="5" placeholder="Write here...">' + data.data.product_desc + '</textarea>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-4 col-sm-4 col-xs-12">' +
                        '<figure class="producttView">' +
                        '<img src="' + data.data.file_url + '" alt="product">' +
                        '</figure>' +
                        '</div>';

                    $("#show_preview_items").html($html);
                    $("#price_section_html").html($hidden_html);



                }

            },
            complete: function () {

                $("#show_preview_data").html("Next");
                $(".addnewproduct-screen-second").css("display", "none");
                $(".addnewproduct-screen-third").css("display", "block");


            },
            error: function () {
                alert('Something went wrong. Please try again');
            }

        });


    },


    __submit_product_data: function (prodata) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/submit-product-data',

            data: prodata,

            beforeSend: function () {
                $("#final_submit_data").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            dataType: 'json',


            success: function (data) {


                if (parseInt(data.code) == 200) {
                    window.location = 'product-listing';
                }

            },
            complete: function () {
                $("#final_submit_data").html('Finish');
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

$('body').on('keyup','#searchproduct',function(){
    var searchTerm = $(this).val();

    if(searchTerm.length == 0) {

        $("#selected_cat_id").val("");
    }
});


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
            $("#selected_cat_id").val(ui.item.category_id);
        } else {
            $("#category_id").val($("#selected_cat_id").val());
            $("#pro_name").val($("#searchproduct").val());
            $('#addProductModal').modal({backdrop: 'static', keyboard: false});
            $('#addProductModal').modal('show');
        }

        return false;
    },
    change: function (event, ui) {
        $("#selected_cat_id").val(ui.item ? ui.item.category_id : "");
        $("#searchproduct_id").val(ui.item ? ui.item.id : 0);
    },
    minLength: 2,
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {

            return (item.id) ? $('<li>')
                .append("<a><img src='"+ item.image + "' width='50' height='50'>" + item.value + '<span> THC :' + item.thc + '  CBD :' + item.cbd + "</span></a>")
                .appendTo(ul) : ((typeof item.value != 'undefined') ? $('<li>').append("<a>" + item.value + "</a>").appendTo(ul) : $('<li>'));



        };
    }
});

// driver function for all //
$("body").on('change', '#selected_cat_id', function () {
    $("#searchproduct").val('');
    $("#searchproduct_id").val(0);
});

$('body').on('click', '#nex_button_select_qty', function () {
    var id = $('#searchproduct_id').val();

    if (!id || "" == $('#searchproduct').val()) {
        // $("#error_product_search").html(HANDLE_PRODUCT_ADD.errors.product_required);
        swal({
            title:"Product",
            text:HANDLE_PRODUCT_ADD.errors.product_required
        })
        return false;
    }
    HANDLE_PRODUCT_ADD.__fetch_quantity_product(id);
});
$('body').on('click', '#show_preview_data', function () {
    $("#error_submit_qty").html("");
    var id = $('#searchproduct_id').val();
    var selectArray = [];

    var is_price_filled = true;
    var is_offered_price_valid = true;
    var is_empty_description = true;
    var variety_valid = true;
    $('.add-product').each(function () {
        var price = $(this).val();
           
           console.log(price);
           
        if ($.trim(price) == "" || price<0 || price > 10000) {

            is_price_filled = false;
        }
    });


    $('body').find('input[name="price[pack]"]').each(function () {
        var qty = $(this).val();

        if ($.trim(qty) == "" || qty<0 || qty> 10000) {

            is_price_filled = false;
        }

    });

    $('body').find('select.sel-quant').each(function (index, val) {
        var cTextVal = $(val).find('option:selected').text().trim();
        if (jQuery.inArray(cTextVal, selectArray) == "-1") {
            selectArray.push(cTextVal);
        } else {
            variety_valid = false;
        }
    });

   

    // $('body').find('input[name="price[offered]"]').each(function (index, val) {
    //     if ($(val).val()) {
    //         if (parseInt($(val).val()) >= parseInt($(val).closest('.form-group').find('.searchproduct1').val())) {
    //             is_offered_price_valid =  false;
    //         }
    //     }
    // });
    //comment

    // if (!is_offered_price_valid){
    //     $("#error_submit_qty").html(HANDLE_PRODUCT_ADD.errors.offered_price_validation);
    //     return false;
    // }
    if (!variety_valid){
        $("#error_submit_qty").html(HANDLE_PRODUCT_ADD.errors.duplicate_variety);
        return false;
    }

    if (!is_price_filled) {
       
        $("#error_submit_qty").html(HANDLE_PRODUCT_ADD.errors.qty_field_required);
        return false;
    }


    HANDLE_PRODUCT_ADD.__submit_product_price_qty(id);
});

var add_counter = 1;

$('body').on('click', '#add_more_button', function () {
    // console.log($('select[name="price[choice]"]').eq().children('option:selected').val());
    
    var html = '<div class="form-group">' +
        '<input type="text" maxlength="5" name="price[quant_price]" onkeypress="validate(event)" class=" pl-210 searchproduct1 add-product" placeholder="Enter actual price (in $)" required>' +
        '<input type="text" maxlength="5" name="price[offered]"  onkeypress="validate(event)" class=" quantity hidden" placeholder="Enter offered price" required>' +
        '<input type="text" maxlength="5" name="price[pack]"  onkeypress="validate(event)" class="quantity" placeholder="Enter quantity" required><i class="fa fa-trash prdctdelete" style="color:red" aria-hidden="true"></i>';

    html += '<div class="selectpanel sel-quant" id="option_selected_">';
    html += $("#option_selected_").html();
    html += '</div></div>';

    $("#add_more_div").append(html);

});


$("body").on('click', '#final_submit_data', function () {
    var formele = $("#final_product_submision").serialize();
    $('body').find('textarea.add_description').each(function (index, val) {
        if ($(val).val() == "") {
            $(val).closest('.form-group').after('<span class="input-error error">Enter product description.</span>');
            return false;
        }
    });
    
    HANDLE_PRODUCT_ADD.__submit_product_data(formele);
});

$("body").on('click', '.prdctdelete', function () {

    $(this).closest('.form-group').remove();

});

$('body').on('keyup', '#text_area_data', function () {
    var value = $(this).val();
    $("#hidden_pro_description").val(value);

});

//Add new product validation


$("#requestedFormId").validate({
    rules: {
        product_name: {
            required: true,
            maxlength: 150
        },
        thc: {
            required: true
        },
        cbd: {
            required: true
        },
        product_desc: {
            required: true,
        }
    },
    messages:{
        "product_name":{
            required: "Please enter product name"
        },
        "thc": {
            required: "Please enter valid THC value",
        },
        "cbd": {
            required: "Please enter valid CBD value",
        },
        "product_desc": {
            required: "Please enter description"
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});

$(".closeBtn").click(function () {
    $('#requestedFormId').trigger("reset");
    $('#addProductModal').modal('hide');

})



