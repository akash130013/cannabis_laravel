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
    data_table = $('#notification_table').DataTable({
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
            "url": "notification-list",
            "data": function (d) {
                d.status = $('#status').val();
                d.startDate=$('#startDate').val();
                d.endDate=$('#endDate').val();
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
                "title": "Platform",
                "data": "platform",
            },
            {
                "title": "Push Message",
                "data": "message",
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
                "title": "Added On",
                "data": "created_at",
                "orderable": false,
            },
            {
                "title": localMsg.Action,
                "data": "action",
                "orderable": false,
                "render": function (data, type, row) {
                    var buttons = "";
                      
                        buttons += '<a title="Resend" data-type="notification"  data-id="' + data.id + '" data-text="' + localMsg.RepeatNotification + '" id="info-alert" href="javascript:void(0); "><i class="fas fa-repeat"></i></a>';

                        buttons += '<a title="Delete"   data-id="' + data.id + '" data-type="notification" data-text="' + localMsg.deleteNotification + '" id="danger-alert"><img src="'+asset_url+'/images/delete-bin-line.svg"></a>';
                    
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
$('#applyNotificationFilter').on('click',function () {
    setTags();
});

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

