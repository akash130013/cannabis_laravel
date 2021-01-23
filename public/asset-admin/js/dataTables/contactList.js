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
        data_table = $('#contact_query_table').DataTable({
            stateSave: true,
            dom: '<"top">rt<"bottom"ip><"clear">',
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            // "scrollY": "500px",
            "ordering": false,
            "scrollCollapse": true,
            "bInfo" : true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "ajax": {
                "url": "contact-query-list",
                "data": function (d) {
                    d.length = $('#length').val();
                    d.search = $('#search').val();
                }
            },
            "columns": [{
                    "title": 'S.No',
                    "data": "sn",
                    "orderable": false,
                },
                {
                    "title": "Name",
                    "data": "name",
                    "orderable": false,
                },
                {
                    "title": "Email",
                    "data": "email",
                    "orderable": false,
                },
                {
                    "title": "Reason",
                    "data": "reason",
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
                    "title": "Message",
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
        $(".dataTables_filter input").attr("placeholder", localMsg.promocodePlaceholder);
    }


    //Filters START
    $('body').on('change','#promotional_type', function () {
        setTags();  
    });

    // getting data maximum user defined row wise
    $('#length').on('change',function () {
        setTags();
    });

    // getting data searching wise
    $('#search').keyup(function () {
        setTags();
    }); 
