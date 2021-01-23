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
    data_table = $('#category_table').DataTable({
        stateSave: true,
        dom: '<"top">rt<"bottom"ip><"clear">',
        "processing": true,
        "serverSide": true,
        "autoWidth": false,
        // "scrollY": "500px",
        "scrollCollapse": true,
        "ordering": false,
        "bInfo" : true,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        "ajax": {
            "url": "category-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.minProduct = $('#minProduct').val();
                d.maxProduct = $('#maxProduct').val();
                d.length = $('#length').val();
                d.search = $('#search').val();
            }
        },
        "columns": [{
                "title": 'S.No',
                "data": "sn",
            },

            // {
            //     "title": "Category Id",
            //     "data": "Id",
            // },

            {
                "title": "Category Name",
                "data": "category_name",
                render: function(data){
                    if(data){
                        return '<span class="td-text-wrap" title="'+data+'"> '+data+' </span>   ';
                    } else {
                        return '--';
                    }
                },
            },

            {
                "title": "Added Date",
                "data": "created_at",
            },

            {
                "title": "Total Product",
                "data": "total_product",
            },

            {
                "title": "Category Image",
                "data": "category_image",
                "orderable": false,
                render: function ( data, type, row ) {
                   return '<img style="width:100px;height:100px" src="'+data+'">';
                }
               
            },


            {
                "title": localMsg.Status,
                "data": "c_status",
                "orderable": false,
               
            },
            {
                "title": localMsg.Action,
                "data": "action",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                        buttons += '<a title="Detail"  href="/admin/category/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';
                        buttons += '<a title="Edit"   data-id="' + data.id + '"   href="/admin/category/edit/'+data.id+'"><img src="'+asset_url+'/images/pencil-line.svg"></a>';

                        if ('active' === data.status) {
                            buttons += '<a title="Deactivate" data-type="category"  data-id="' + data.id + '" data-text="' + localMsg.blockCategory + '" id="warning-alert" href="javascript:void(0); "><i class="fas fa-unlock"></i></a>';
                        }else{
                            buttons += '<a title="Activate" data-type="category"  data-id="' + data.id + '" data-text="' + localMsg.unBlockCategory + '" id="info-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/block.svg"></a>';
                        }
                        // buttons += '<a title="delete"   data-id="' + data.id + '" data-type="category" data-text="' + localMsg.deleteCategory + '" id="danger-alert"><i class="fas fa-trash"></i></a>';

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
    $(".dataTables_filter input").attr("placeholder", localMsg.categoryPlaceholder);
}


//Filters START
$('#applyCategoryFilter').on('click', function () {
    setTags();  
});

// //min and max product filter
// $('#minProduct').keyup(function () {
//     setTags();
// });
// $('#maxProduct').keyup(function () {
//     setTags();
// });

// getting data maximum user defined row wise
$('#length').on('change',function () {
    setTags();
});

// getting data searching wise
$('#search').keyup(function () {
    setTags();
}); 



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