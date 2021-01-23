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
    data_table = $('#user_table').DataTable({
       // stateSave: true,
        pageResize: true,
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
            "url": "user-list",
            "data": function (d) {
                d.promoCode = $('#promoCode').val();
                d.status    = $('#status').val();
                d.startDate = $('#startDate').val();
                d.endDate   = $('#endDate').val();
                d.startDOB  = $('#startDOB').val();
                d.endDOB    = $('#endDOB').val();
                d.length    = $('#length').val();
                d.search    = $('#search').val();
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
                "title": "Date of Registration",
                "data": "created_at",
            },
            {
                "title": "Name",
                "data": "user_name",
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
            {
                "title": "Date of birth",
                "data": "dob",
                "orderable": false,
            },
           
           
            {
                "title": "Profile Pic",
                "data": "user_image",
                "orderable": false,
                render: function ( data, type, row ) {
                   return '<img loading="lazy" style="width:100px;height:100px" src="'+data+'">';
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
                        buttons += '<a title="Detail"  href="/admin/user/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';  

                        if ('active' === data.status) {
                            buttons += '<a title="Deacvtivate" data-type="user"  data-id="' + data.id + '" data-text="' + localMsg.blockUser + '" id="warning-alert" href="javascript:void(0); "><i class="fas fa-unlock"></i></a>';
                        }else{
                            buttons += '<a title="Activate" data-type="user"  data-id="' + data.id + '" data-text="' + localMsg.unBlockUser + '" id="info-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/block.svg"></a>';
                        }
                        // buttons += '<a title="delete"   data-id="' + data.id + '" data-type="user" data-text="' + localMsg.deleteUser + '" id="danger-alert"><i class="fas fa-trash"></i></a>';

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
   //      "dom": '<"top"lf>Bti<"bottom"p>',
    //     buttons: [
    //         {
    //             extend: 'excel',
    //             action: newExportAction,
    //             text : 'Export to Excel',
    //     }
    // ],
    });
    $(".dataTables_filter input").attr("placeholder", localMsg.userPlaceholder);
}


//Filters START
// $('body').on('change','#status', function () {
//     setTags();  
// });

//START & END REGISTRATION DATE FILTER
// $('#startDate').on('dp.change',function () {
//     setTags();
// });
// $('#endDate').on('dp.change',function () {
//     setTags();
// });

// //START & END DATE OF BIRTH FILTER
// $('#startDOB').on('dp.change',function () {
//     setTags();
// });
// $('#endDOB').on('dp.change',function () {
//     setTags();
// });
$('#applyUserFilter').on('click',function(){
    setTags();
})

// getting data maximum user defined row wise
$('#length').on('change',function () {
    setTags();
});

// getting data searching wise
$('#search').keyup(function () {
    setTags();
});
