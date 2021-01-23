$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var HANDLE_PRODUCT_ADD = {


    errors: {

        "product_required": "Please enter product",
    },


    __fetch_typed_products: function (searchTerm, catid, response) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/show-product',

            data: {term: searchTerm, category_id: catid},

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

            data: {id: product_id},

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
                }

            },

            complete: function () {

                $("#nex_button_select_qty").html("Next")

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

            data: {id: product_id},

            dataType: 'json',

            beforeSend: function () {

                $("#show_preview_data").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                if (parseInt(data.code) == 200) {

                    var $html = '<div class="col-md-8 col-sm-8 col-xs-12">' +
                        '<div class="prdctHeader">' +
                        '<h3>' + data.data.product_name + '</h3>' +
                        '<p>THC: ' + data.data.thc_per + '% CBD: ' + data.data.cbd_per + '%</p>' +
                        '</div>' +
                        '<div class="prdctDesp">' +
                        '<h5>Quantity & Price</h5>' +
                        '<div class="prdctQuantity">';


                    // loop over the data for the set of added products //

                    var $hidden_html = "";
                    var index = 0;

                    $('input[name="price[quant_price]"]').each(function () {


                        var hidden_quant = $('select[name="price[choice]"] :selected').eq(index).attr('data-quant_unit');
                        var hidden_quant_unit = $('select[name="price[choice]"] :selected').eq(index).attr('data-unit');
                        var price = $(this).val();
                        var price_pack = $('input[name="price[pack]"]').eq(index).val();

                        $html += '<div class="product">' +
                            '<div class="pd-brdr">' +
                            '<span>' + hidden_quant + ' ' + hidden_quant_unit.substring(0, 1) + '</span>' +
                            '</div>' +
                            '<p>$' + price + ' (' + price_pack + ' pac.)</p>';

                        $hidden_html += '<input type="hidden" name="price[unit][]" value="' + hidden_quant_unit + '">';
                        $hidden_html += '<input type="hidden" name="price[quant_unit][]" value="' + hidden_quant + '">';
                        $hidden_html += '<input type="hidden" name="price[price][]" value="' + price + '">';
                        $hidden_html += '<input type="hidden" name="price[packet][]" value="' + price_pack + '">';
                        ++index;


                    });

                    $html += '</div>' +
                        '</div>' +
                        '</div><div class="additionInfo">' +
                        '<h5>Additional Description</h5>' +
                        '<div class="form-group">' +
                        '<textarea class="add_description" required cols="30" rows="5" maxlength="500" placeholder="Write here...">' + data.data.product_desc + '</textarea>' +
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

                $("#show_preview_data").html("View");

            },
            error: function () {
                alert('Something went wrong. Please try again');
            }

        });


    },


    __submit_product_data: function (prodata) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/submit-product-edit-data',

            data: prodata,

            beforeSend: function (xhr, opts) {
                var valid_form = validateForm();
                if (valid_form == false) {
                    xhr.abort();
                    return;
                }
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

    },

    __add_more_price_quantity: function (product_id) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/get-product-add',

            data: {'id': product_id},

            beforeSend: function () {

                $("#add_more_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },

            dataType: 'json',


            success: function (data) {


                if (parseInt(data.code) == 200) {
                    $("#add_more_div").append(data.html);
                }

            },
            complete: function () {
                $("#add_more_button").html('Add more');
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

function validateForm() {
    // console.log(new Date().toJSON())
    var result = true;
    $('span.error').remove();
    var selectArray = [];
    // console.log(selectArray);
    $('body').find('select.sel-quant').each(function (index, val) {
        var cTextVal = $(val).find('option:selected').text().trim();
        if (jQuery.inArray(cTextVal, selectArray) == "-1") {
            selectArray.push(cTextVal);
        } else {
            // console.log("index "+index+" "+cTextVal);
            $(val).closest('.form-group').after('<span class="select-error error">Duplicate Variety</span>');
            return result= false;
        }
    });
    // console.log(selectArray);

    $('body').find('input.searchproduct1').each(function (index, val) {
        if ($(val).val() == "" || $(val).val()>10000 || $(val).val()<0) {
            $(val).closest('.form-group').after('<span class="input-error error">Please enter valid price(Upto 10000 $)</span>');
            return result  = false;
        }
    });
    
    $('body').find('textarea.add_description').each(function (index, val) {
        if ($(val).val() == "") {
            $(val).closest('.flex-row').after('<span class="input-error error">Enter product description.</span>');
            return result  = false;
        }
    });

    // $('body').find('input[name="price[offered][]"]').each(function (index, val) {
    //     if ($(val).val()) {
    //         if (parseInt($(val).val()) >= parseInt($(val).closest('.form-group').find('.searchproduct1').val())) {
    //             // console.log($(val).closest('.form-group').find('.searchproduct1').val());
    //             // console.log(parseInt($(val).val()));
    //             $(val).closest('.form-group').after('<span class="input-error error">Offered Price must be less than actual price</span>');
    //             return result =  false;
    //         }
    //     }
    // });

    $('body').find('input[name="price[packet][]"]').each(function (index, val) {
        if ($(val).val() == "" ||$(val).val()>10000 || $(val).val()<0) {
            $(val).closest('.form-group').after('<span class="input-error error">Please enter valid quantity(Upto 10000)</span>');
            return result  = false;
        }
    });


    return result;
}

$('body').on('click', '#add_more_button', function () {

    var productID = $("#search_product_id").val();
    HANDLE_PRODUCT_ADD.__add_more_price_quantity(productID);

});

$("body").on('click', '#final_submit_data', function () {
    var formele = $("#final_product_submision").serialize();
    HANDLE_PRODUCT_ADD.__submit_product_data(formele);
});

$("body").on('click', '.prdctdelete', function () {
    $(this).closest('.form-group').remove();
});


$("body").on('click', '#quantity_data', function () {
    var hiddenunitID = $(this).find('option:selected').attr('data-hidden-unit');
    var hiddenquantID = $(this).find('option:selected').attr('data-hidden-quant');
    var unit = $(this).find('option:selected').attr('data-unit');
    var quantunit = $(this).find('option:selected').attr('data-quant_unit');

    $("#" + hiddenunitID).val(unit);
    $("#" + hiddenquantID).val(quantunit);
    $(this).closest('#copy_div').find('.select-error').remove();
});


$('body').on('change', '.sel-quant', function () {
    $('span.error').remove();
})

$('body').on('keydown', 'input[type="text"]', function () {
    $('span.error').remove();
});
