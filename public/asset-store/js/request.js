$(document).on('click', '[data-request="ajax"]', function () {
    var data = $(this).data();
    var type = data.type != undefined ? data.type : 'DELETE';
    swal({
        title: "Confirmation!",
        text: data.message,
        buttons: true,
    }).then((isConfirm) => {
        if (isConfirm) {
            $.ajax({
                url: data.url,
                data,
                type,
                success: function (response) {
                    swal({
                        title: "Confirmation!",
                        text: response.message,
                    }).then(() => {
                        window.location.reload();
                    })
                }
            })
        }
    });
});


$(document).on('click', '[data-request="changestatus"]', function () {
    var data = $(this).data();
    swal({
        title: "Are you sure ?",
        text: data.message,
        // icon:"warning",
        buttons: true,
    }).then((isConfirm) => {
        if (isConfirm) {
            $.ajax({
                url: data.url,
                type : "GET",
                data : data,
                dataType : "json",
                success: function (response) {
                    // console.log(response);
                    swal({title:'Confirmed Status',
                        text:response.message}).then(() => {
                        window.location.reload();
                    })
                }
            })
        }
    });
});