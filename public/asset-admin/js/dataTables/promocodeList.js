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
        data_table = $('#promocode_table').DataTable({
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
                "url": "promocode-list",
                "data": function (d) {
                    d.couponDateType = $('#coupon_date_type').val();
                    d.promotionalType = $('#promotional_type').val();
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                    d.minAmount = $('#minAmount').val();
                    d.maxAmount = $('#maxAmount').val();
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
                    "title": "Promo Code Name",
                    "data": "promo_name",
                    render: function(data){
                        if(data){
                            return '<span class="td-text-wrap" title="'+data+'"> '+data+' </span>   ';
                        } else {
                            return '--';
                        }
                    },
                },

                {
                    "title": "Coupon Code",
                    "data": "coupon_code",
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
                    "title": "No. of Coupons",
                    "data": "total_coupon",
                    "orderable": false,
                },

                {
                    "title": "Promotional Type",
                    "data": "promotional_type",
                    "orderable": false,
                },

                {
                    "title": "Discount Amount",
                    "data": "amount",
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
                    "title": "Promotional Start Date",
                    "data": "start_time",
                    "orderable": false,
                },
                {
                    "title": "Promotional End Date",
                    "data": "end_time",
                    "orderable": false,
                },

                {
                    "title": "Offer Status",
                    "data": "offer_status",
                    "orderable": false,
                
                },
                {
                    "title": localMsg.Action,
                    "data": "action",
                    "orderable": false,
                    "render": function (data, type, row) {
                        var buttons = "";
                            buttons += '<a title="Detail"  href="/admin/promocode/show/'+data.id+'"><img src="'+asset_url+'/images/eye-line.svg"></a>';  
                            buttons += '<a title="Edit"   data-id="' + data.id + '"href="/admin/promocode/add/'+data.id+'"><img src="'+asset_url+'/images/pencil-line.svg"></a>';

                            if ('active' === data.offer_status) {
                                    buttons += '<a title="Deactivate" data-type="promocode"  data-id="' + data.id + '" data-text="' + localMsg.inactivePromocode + '" id="warning-alert" href="javascript:void(0); "><i class="fas fa-unlock"></i></a>';
                            }else{
                                buttons += '<a title="Activate" data-type="promocode"  data-id="' + data.id + '" data-text="' + localMsg.activePromocode + '" id="info-alert" href="javascript:void(0); "><img src="'+asset_url+'/images/block.svg"></a>';
                            }
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

    //min and max amount filter
    $('#applyPromocodeFilter').on('click',function () {
        setTags();
    });
    // $('#endDate').on('dp.change',function () {
    //     setTags();
    // });
    // //Filters START
    // $('body').on('change','#promotional_type', function () {
    //     setTags();  
    // });
    // $('body').on('change','#coupon_date_type', function () {
    //     setTags();  
    // });

    // //min and max amount filter
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

    // getting data searching wise
    $('#search').keyup(function () {
        setTags();
    }); 



  