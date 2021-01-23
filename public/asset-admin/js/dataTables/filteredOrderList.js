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
    data_table = $('#filtered_order_table').DataTable({
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
            "url": "order-list",
            "data": function (d) {
                d.length = $('#length').val();
                d.userId = $('#userId').val();
                d.productId = $('#productId').val();
                d.storeId = $('#storeId').val();
                d.search = $('#search').val();
                d.status = $('#status').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.minAmount=$('#minAmount').val();
                d.maxAmount=$('#maxAmount').val();
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
                "title": "Store Name",
                "data": "store_detail",
                "orderable": false,
                render: function ( data, type, row ) {
                    return '<a href="/admin/store/show/'+data.id+'">'+data.name+'</a>';
                }
            },
           
           
            {
                "title": "Customer Details",
                "data": "customer_detail",
                "orderable": false,
                render: function ( data, type, row ) {
                        return '<a href="/admin/user/show/'+data.id+'">'+data.name+'</a>';
                    }
            },

            {
                "title": "Delivery Location",
                "data": "location",
                "orderable": false,
                render: function(data)
                {
                    return '<span class="td-text-wrap" title="address">'+data+' </span>';
                }
            },

            {
                "title": "Amount ($)",
                "data": "amount",
                "orderable": false,
            },
            {
                "title": "Order Status",
                "data": "status",   
                "orderable": false,
            },
            {
                "title": localMsg.Action,
                "data": "action",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                        buttons += '<a title="Detail"  href="/admin/order/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';  
                       if ("" == buttons) {
                        buttons = "--";
                    }
                    return buttons;

                }
            }
            // {
            //     "title": "Product Image",
            //     "data": "category_image",
            //     "orderable": false,
            //     render: function ( data, type, row ) {
            //        return '<img style="width:100px;height:100px" src="'+data+'">';
            //     }
               
            // },


            // {
            //     "title": localMsg.Status,
            //     "data": "p_status",
            //     "orderable": false,
               
            // },
           
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

$('#applyOrderListFilter').on('click',function () {
    setTags();
});
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
///======================beacon list model of change status of assign beacon 
// $("#logoutLink").click(function () {


/**used to export full data */
var oldExportAction = function (self, e, dt, button, config) {
    if (button[0].className.indexOf('buttons-excel') >= 0) {
        if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
        }
        else {
            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
        }
    } else if (button[0].className.indexOf('buttons-print') >= 0) {
        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
    }
};

var newExportAction = function (e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;

    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;

        dt.one('preDraw', function (e, settings) {
            // Call the original action function 
            oldExportAction(self, e, dt, button, config);

            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });

            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);

            // Prevent rendering of the full data to the DOM
            return false;
        });
    });

    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};