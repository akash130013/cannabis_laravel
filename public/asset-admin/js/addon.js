$('#addon_form').validate({
    errorElement: 'span',
    errorClass: 'help-text error-message text-danger',
    rules: {
        name: {
            required: true,
            minlength: 2,
            maxlength: 50
        },
        price: {
            required: true,
            number: true,
            min: 1,
            max: 1000
        },
        category: {
            required: true,
        },
        status: {
            required: true,
        }
    },
    messages: {

    },
    submitHandler: function (form) {
        form.submit();
    }
});

$('#addon_edit_form').validate({
    errorElement: 'span',
    errorClass: 'help-text error-message text-danger',
    rules: {
        name: {
            required: true,
            minlength: 2,
            maxlength: 50
        },
        price: {
            required: true,
            number: true,
            min: 1,
            max: 1000
        },
        category: {
            required: true,
        },
        status: {
            required: true,
        }
    },
    messages: {

    },
    submitHandler: function (form) {
        form.submit();
    }
});


$(document).on('click', '.edit-details', function () {
    $('input[name="addon_id"]').val($(this).data('addon-id'));
    $('input[name="addon_name"]').val($(this).data('name'));
    $('input[name="addon_price"]').val($(this).data('price'));
    $('.addon_status').selectpicker('val', $(this).data('status'));
    $('.addon_status').selectpicker('refresh');
    var cat = $(this).data('category').toString();
    cat = cat.split(',');

    $('.addon_category').selectpicker('val', cat);

    $('.addon_category').selectpicker('refresh');
    $('#myModal-edit-dishon').modal('show');
});