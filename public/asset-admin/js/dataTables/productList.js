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
    data_table = $('#product_table').DataTable({
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
            "url": "product-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.category_id = $('#category_id').val();
                d.minOrder = $('#minOrder').val();
                d.encryptStoreId = $('#encryptStoreId').val();
                d.maxOrder = $('#maxOrder').val();
                d.minStore=$('#minStore').val();
                d.maxStore=$('#maxStore').val();
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
                "title": "Product Id",
                "data": "Id",
            },

            {
                "title": "Product Name",
                "data": "product_name",
                render: function(data){
                    if(data){
                        return '<span class="td-text-wrap" title="'+data+'"> '+data+' </span>   ';
                    } else {
                        return '--';
                    }
                },
            },
           
            {
                "title": "Category",
                "data": "category_name",
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
                "title": "No. of store selling",
                "data": "total_store",
                "orderable": false,
            },

            {
                "title": "No. of orders",
                "data": "total_product",
                "orderable": false,
            },

          
            // {
            //     "title": "Product Image",
            //     "data": "category_image",
            //     "orderable": false,
            //     render: function ( data, type, row ) {
            //        return '<img style="width:100px;height:100px" src="'+data+'">';
            //     }
               
            // },


            {
                "title": localMsg.Status,
                "data": "p_status",
                "orderable": false,
               
            },
            {
                "title": localMsg.Action,
                "data": "action",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                        buttons += '<a title="Detail"  href="/admin/product/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';  
                        buttons += '<a title="Edit"   data-id="' + data.id + '"   href="/admin/product/edit/'+data.id+'"><img src="'+asset_url+'/images/pencil-line.svg"></a>';
                      

                        if ('active' === data.status) {
                            buttons += '<a title="Deactivate" data-type="product"  data-id="' + data.id + '" data-text="' + localMsg.blockProduct + '" id="warning-alert" href="javascript:void(0); "><i class="fas fa-unlock"></i></a>';
                        }else{
                            buttons += '<a title="Activate" data-type="product"  data-id="' + data.id + '" data-text="' + localMsg.unBlockProduct + '" id="info-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/block.svg"></a>';
                        }

                        // buttons += '<a title="delete"   data-id="' + data.id + '" data-type="product" data-text="' + localMsg.deleteProduct + '" id="danger-alert"><i class="fas fa-trash"></i></a>';
                    
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
$('#applyProductFilter').on('click',function () {
    setTags();
});

// //category filter
// $('#category_id').change(function () {
//     setTags();
// });
// $('#minStore').keyup(function () {
//     setTags();
// });
// $('#maxStore').keyup(function () {
//     setTags();
// });
// $('#minOrder').keyup(function () {
//     setTags();
// });
// $('#maxOrder').keyup(function () {
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

