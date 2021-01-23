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
    data_table = $('#open_settlement').DataTable({
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
            "url": "/admin/store/open-settlement-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.startDate=$('#startDate').val();
                d.endDate=$('#endDate').val();
                d.length = $('#length').val();
                d.search = $('#search').val();
                d.encryptStoreId = $('#encryptStoreId').val();
                
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
                "data": "order_created_at",
                "orderable": true,
            },
            {
                "title": "Order id",
                "data": "order_uid",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                    buttons += '<a title="Detail"  href="/admin/order/show/'+data.order_id+'">'+data.order_uid+'</a>';  
                    return buttons;

                }
            },

            {
                "title": "Products",
                "data": "product_count",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                    
                    return data.count;

                }
            },
            
            
            {
                "width": "10%",
                "title": "Order Status",
                "data": "order_status",
                "orderable": false,
            },
            
            {
                "width": "10%",
                "title": "Total Amount ($)",
                "data": "total_amount",
                "orderable": false,
            },
            {
                "width": "10%",
                "title": "Billing Amount ($)",
                "data": "amount_received",
                "orderable": false,
            },
            {
                "width": "10%",
                "title": "Discount ($)",
                "data": "discount",
                "orderable": false,
            },
            {
                "width": "10%",
                "title": "Commission ($)",
                "data": "commission",
                "orderable": false,
                
            },
            {
                "width": "10%",
                "title": "Status",
                "data": "earning_status",
                "orderable": false,
            },
            
            {
                "width": "10%",
                "title": localMsg.Action,
                "data": "action",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                      
                    if (data.earning_status == 'open') {
                        buttons += '<button title="Settle" class="green-fill-btn"  data-id="' + data.store_earning_id + '" data-type="settlement" data-text="' + localMsg.approveSettlement + '" id="settlement-alert">Settle</button>';
                    }
                    if ("" == buttons) {
                        buttons = "--";
                    }
                    return buttons;

                }
            }
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
    //     "dom": '<"top"lf>Bti<"bottom"p>',
    //     buttons: [
    //         {
    //             extend: 'excel',
    //             action: newExportAction,
    //             text : 'Export to Excel',
    //     }
    // ],
    });
    $(".dataTables_filter input").attr("placeholder", localMsg.productPlaceholder);
}


//Filters START
$('#status').change(function () {
    setTags();
});

$('#minOrder').keyup(function () {
    setTags();
});
$('#maxOrder').keyup(function () {
    setTags();
});
// getting data maximum user defined row wise
$('#length').on('change',function () {
    setTags();
});
//min and max product filter
$('#startDate').on('dp.change',function () {
    setTags();
});
$('#endDate').on('dp.change',function () {
    setTags();
});
// getting data searching wise
$('#search').keyup(function () {
    setTags();
}); 
///======================beacon list model of change status of assign beacon 
// $("#logoutLink").click(function () {

