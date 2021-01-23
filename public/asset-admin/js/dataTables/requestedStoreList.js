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
    data_table = $('#requested_store_table').DataTable({
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
            "url": "requested-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
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
                "title": "Requested Date",
                "data": "created_at",
                // "orderable": true,
               
            },
            {
                "title": "Store Name",
                "data": "store_name",
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
                "title": "Business Name",
                "data": "business_name",
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
                "title": "Store Address",
                "data":  "addr",
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
                "title": "Delivery Locations",
                "data":  "locations",
                "orderable": false,
                render: function(data)
                {
                    return '<a title="Location Detail"  class="btnShowPopup numof" data-id="'+data.id+'" >'+data.count+'</a>'
                }
            },
            {
                "title": "Email",
                "data": "email",
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
                "title": "Contact No",
                "data": "phone",
                "orderable": false,
            },
            // {
            //     "title": "Store Image",
            //     "data": "avatar",
            //     "orderable": false,
            //     render: function ( data, type, row ) {
            //        return '<img loading="lazy" style="width:100px;height:100px" src="'+data+'">';
            //     }
               
            // },
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
                        buttons += '<a title="Detail"  href="/admin/store/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';  
                        if(data.status == 'pending')
                        {
                            buttons += '<a title="Approve" data-type="store"  data-id="' + data.id + '" data-text="' + localMsg.approveStore + '" id="approve-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/check-line.svg"></a>'
                            buttons += '<a title="Reject" data-type="store"  data-id="' + data.id + '" data-text="' + localMsg.rejectStore + '" id="reject-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/close-line.svg"></a>';

                        }
                        else if(data.status == 'reject')
                        {
                            buttons += '<a title="Approve" data-type="store"  data-id="' + data.id + '" data-text="' + localMsg.approveStore + '" id="approve-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/check-line.svg"></a>'
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
    $(".dataTables_filter input").attr("placeholder", localMsg.storePlaceholder);
 
   
}


//Filters START
$('#applyRequestedStoreFilter').on('click', function () {
    setTags();  
});

//min and max sore filter
// $('#startDate').on('dp.change',function () {
//     setTags();
// });
// $('#endDate').on('dp.change',function () {
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


