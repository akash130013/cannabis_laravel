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
        data_table = $('#cms_table').DataTable({
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
                "url": "cms-list",
                "data": function (d) {
                    d.length = $('#length').val();
                    d.search = $('#search').val();
                }
            },
            // "order": [
            //     [1, "desc"]
            // ],
            "columns": [{
                    "title": 'S.No',
                    "data": "sn",
                    "orderable": false,
                },

                {
                    "title": "Panel",
                    "data": "panel",
                },
                {
                    "title": "Title",
                    "data": "name",
                },

                {
                    "title": "Slug",
                    "data": "slug",
                    "orderable": false,
                },
            
                {
                    "title": "Content",
                    "data": "content",
                    "orderable": false,
                    render: function(data){
                        if(data){
                            return (data.length > 30)?data.substring(0, 30)+' ...':data;
                        } else {
                            return '--';
                        }
                    },
                },

                
                // {
                //     "width": "10%",
                //     "title": "Status",
                //     "data": "c_status",
                //     "orderable": false,
                
                // },
                {
                    "title": localMsg.Action,
                    "data": "action",
                    "orderable": false,
                    "render": function (data, type, row) {
                        var buttons = "";
                            // buttons += '<a title="detail"  href="/admin/promocode/show/'+data.id+'"><i class="fas fa-eye"></i></a>';  
                            buttons += '<a title="Edit"   data-id="' + data.id + '"href="/admin/cms-edit/'+data.id+'"><img src="'+asset_url+'/images/pencil-line.svg"></a>';

                            // if ('active' === data.offer_status) {
                            //         buttons += '<a title="Inactive" data-type="promocode"  data-id="' + data.id + '" data-text="' + localMsg.inactivePromocode + '" id="warning-alert" href="javascript:void(0); "><i class="fas fa-unlock"></i></a>';
                            // }else{
                            //     buttons += '<a title="Active" data-type="promocode"  data-id="' + data.id + '" data-text="' + localMsg.activePromocode + '" id="info-alert" href="javascript:void(0); "><i class="fas fa-lock"></i></a>';
                            // }
                            // buttons += '<a title="delete"   data-id="' + data.id + '" data-type="promocode" data-text="' + localMsg.deletePromocode + '" id="danger-alert"><i class="fas fa-trash"></i></a>';

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
