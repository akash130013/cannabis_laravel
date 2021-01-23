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
    data_table = $('#order_table').DataTable({
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
            "url": "/admin/distributor/order-list",
            "data": function (d) {
                d.length = $('#length').val();
                d.search = $('#search').val();
                d.status = $('#status').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.minAmount=$('#minAmount').val();
                d.maxAmount=$('#maxAmount').val();
                d.distributorId = $('#distributorId').val();
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
                "data": "created_at",
                "orderable": true,
            },
            {
                "title": "Order Id",
                "data": "order_id",
                "orderable": false,
                render: function(data){
                    if(data){
                        return '<span class="td-text-wrap" title="'+data+'"> '+data+' </span>   ';
                    } else {
                        return '--';
                    }
                },
            },
            {
                "title": "Price",
                "data": "net_amount",
                "orderable": false,
            },
            
            {
                "title": "Status",
                "data": "status",
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
    $(".dataTables_filter input").attr("placeholder", localMsg.distributorOrderPlaceholder);
}


//Filters START
$('#applyDistributorOrderFilter').on('click', function () {
    setTags();  
});

// $('#minAmount').keyup(function () {
//     setTags();
// });
// $('#maxAmount').keyup(function () {
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
