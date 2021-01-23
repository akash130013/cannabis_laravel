$(window).on("load", function () {
    // Handler for .load() called.'
    $("#example tr").eq(1).addClass('selected-row');

});


$('.order-row').on('click', function () {
    var data = $(this).data();
    var $this = $(this);
    $('.order-row').removeClass('selected-row');
    $.ajax({
        url: data.url,
        type: "GET",
        success: function (response) {
            $('#side-detail').html(response.html);
            $this.addClass('selected-row');
        }
    })
})

$('body').on('click', '.location_status', function () {

    swal({
        title: 'Order Status',
        text: $(this).attr('data-lang'),
        closeOnClickOutside: true,
        buttons: {
            cancel: "Dismiss",
            confirm: $(this).attr('data-msg'),

        }
    }).then((value) => {
        if (value) {
            url = $(this).attr('data-href')
            $.ajax({
                url,
                type: 'PUT',
                data: { 'status': $(this).attr('data-status') },
                success: function (response) {
                    swal({
                        title: 'Order Status',
                        text: response.message,
                        closeOnClickOutside: true,
                        button: {
                            text: "Ok",
                            closeModal: true,
                        }
                    }).then((value) => {
                        window.location.reload()
                    })
                }
            })
        }

    });
});

$('body').on('click', '#rejectOrder', function () {
    swal({
        title: 'Reject Order Request',
        text: 'Enter the valid reason and reject your order request.',
        content: "input",
        closeOnClickOutside: false,
        buttons: {
            cancel: "Dismiss",
            confirm: "Reject",

        }
    })
        .then((name) => {
            if (!name) {
                swal({
                    title: 'Reject Order Request',
                    text: "Please add reject comment to proceed!"
                });
                return false
            }
            let url = $(this).attr('data-href');
            $.ajax({
                url,
                type: 'PUT',
                data: { 'reason': name },
                success: function (response) {
                    swal(
                        {
                            title: 'Order Status',
                            text: response.message
                        }
                    ).then((value) => {
                        window.location.reload()
                    })
                },
                error: function (err) {
                    if (err) {
                        swal("Oh noes!", "The AJAX request failed!", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                }
            })

        })

});

$('body').on('click', '#stock', function () {

    if ($(this).is(":checked")) {
        $('.button').find('button').attr('disabled', false);
        $('.location_status').removeClass('disabled');
    } else {
        $('.button').find('button').attr('disabled', true);
        $('.location_status').addClass('disabled');
    }
});


$(document).on('change', '#agree', function () {
    if ($(this).is(":checked")) {
        $('#assign-driver').removeClass('hide');
    }
    else {
        $('#assign-driver').addClass('hide');
    }
})


$(document).on('change', '.select_driver', function () {
    var url = $(this).data('url')
    order_id = $(this).val()
    var driver_id=$(this).data('driver-id');
    $("#driver_id").val(driver_id);
    $('#datepicker').datetimepicker({
        useCurrent: true,
        format: 'DD-MM-YYYY'
    })
    $('#datepicker').data("DateTimePicker").minDate(moment().format('DD-MM-YYYY'));

    datatable = $('#order_allocation').DataTable({
        // serverSide: true,
        ordering: false,
        searching: false,
        processing: true,
        "bDestroy": true,
        "language": {
            "emptyTable": "Currently No Order assigned",
          },
        // "pageLength": 10,
        ajax: {
            url,
            data: function (d) {
                // d.length = 2,
                    d.page = d.start
            }
        },
        columns: [
            {
                "title": 'S.No',
                "data": "sn",
            },

            {
                "title": "Order Id",
                "data": "Order_ID",
            },

            {
                "title": "Delivery Location",
                "data": "formatted_address",

            },

            {
                "title": "Delivery Date",
                "data": "delivery_date",
            },
            {
                "title": "Status",
                "data": "status",

            }
        ]
    });

    $('#allocation_detail').removeClass('hide')

    // $.ajax({
    //     url,
    //     type: 'GET',
    //     data: {'order_id': order_id},
    //     success: function (response) {
    //         $('#allocation_detail').removeClass('hide')
    //         $('#order_allocation').DataTable({
    //             ordering : false,
    //             searching : false
    //         });
    //         $('#datepicker').datetimepicker({
    //             useCurrent: true,
    //             format: 'DD-MM-YYYY'
    //         })
    //         $('#datepicker').data("DateTimePicker").minDate(moment().format('DD-MM-YYYY'));
    //     }
    // })

    //          $('#datepicker').datetimepicker({
    //             useCurrent: true,
    //             format: 'DD-MM-YYYY'
    //         })
    // $('#datepicker').data("DateTimePicker").minDate(moment().format('DD-MM-YYYY'));
})




$(document).on('click', '#submit-form', function () {
    if (!$('[name="driver"]').is(":checked")) {
        swal("Please select any one driver")
    } else {
        $(document).find('form#assign-driver').submit();
    }
})
