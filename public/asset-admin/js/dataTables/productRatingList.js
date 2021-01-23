/*
 * Author : Appinventiv Technology Pvt. Ltd.
 * we approx 65+ columns in this table to show scroller  in table
 */

//start loader
$(function () {
    NProgress.start();
});
//stop loader
$(window).load(function () {
    NProgress.done();
});


/**
 *
 * @type type
 */
var data_table = null;
var userDatatable = function () {
    data_table = $('#product_rating_table').DataTable({
        stateSave: true,
        dom: '<"top">rt<"bottom"ip><"clear">',
        "processing": true,
        "serverSide": true,
        "autoWidth": false,
        // "scrollY": "500px",
        "scrollCollapse": true,
        "bInfo" : true,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        "ajax": {
            "url": "/admin/product/rating-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.encryptProductId = $('#encryptProductId').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.minRate=$('#minRate').val();
                d.maxRate=$('#maxRate').val();
                d.length = $('#length').val();
                d.search = $('#search').val();
            }
        },
        "order": [
            [1, "desc"]
        ],
        "columns": [{
                "title": 'S.No',
                "data": "sn",
                "orderable": false,
            },

            {
                "title": "Order Date",
                "data": "order_date",
            },

            {
                "title": "Order Id",
                "data": "order",
                render: function(data){
                    if(data.order_id){
                        return '<a href="/admin/order/show/'+data.order_id+'">'+data.order_uid+'</a>';
                    } else {
                        return '--';
                    }
                },
            },
           
            {
                "title": "User Name",
                "data": "user",
                "orderable": false,
                render: function(data){
                    if(data.user_id){
                        return '<a href="/admin/user/show/'+data.user_id+'">'+data.user_name+'</a>';
                    } else {
                        return '--';
                    }
                },
            },

            {
                "title": "Review",
                "data": "review",
                "orderable": false,
                render: function(data){
                    if(data){
                        return (data.length > 30)?data.substring(0, 30)+' <a title="'+data+'" class="numOf">...</a>':data;
                    } else {
                        return '--';
                    }
                },
            },

            {
                "title": "Rate",
                "data": "rate",
                "orderable": false,
            },
        ],
        "oLanguage": { // PLEASE DON NOT CHANGE HERE
            "sSearch": localMsg.sSearch,
            "sFirst": localMsg.sFirst,
            "sInfo": localMsg.sInfo,
            "sEmptyTable": localMsg.sEmptyTable,
            "sInfoEmpty": localMsg.sInfoEmpty,
            "sZeroRecords": localMsg.sZeroRecords,
            "sNext": localMsg.sNext,
            "sProcessing": localMsg.sProcessing,
            "sInfoFiltered": localMsg.sInfoFiltered
        },
    });
    $(".dataTables_filter input").attr("placeholder", localMsg.productPlaceholder);
}


$('#applyProductRatingFilter').on('click',function () {
    setTags();
});
// $('#maxRate').keyup(function () {
//     setTags();
// });
// getting data maximum user defined row wise
$('#length').on('change',function () {
    setTags();
});
//min and max product filter
// $('#startDate').on('dp.change',function () {
//     setTags();
// });
// $('#endDate').on('dp.change',function () {
//     setTags();
// });
// getting data searching wise
$('#search').keyup(function () {
    setTags();
}); 
