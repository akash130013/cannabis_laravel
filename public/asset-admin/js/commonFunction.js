/*
 * Author : Appinventiv Technology Pvt. Ltd.
 */
    //Panel Domain Name
    const domain = window.location.hostname;

    //Panel Protocol https/http
    const host = window.location.protocol;

    //Panel used port
    const port = window.location.port;

    // Generated URL
    const URL = host + "//" + domain + ":" + port;

    /**
     * @desc used to manage all the count
     * @date 07/01/2018
     */


    //Delete Warning
    $('body').on('click', '#danger-alert', function () {

        //Text to display on alert
        var text = $(this).attr("data-text");

        //data id
        var id = $(this).attr("data-id");

        //type
        var type = $(this).attr("data-type");

        //Open Alert BOX
        deleteWarningBox(text, id, type);
    });



    // Block Warning
    $('body').on('click', '#warning-alert', function () {

        //Text to display on alert
        var text = $(this).attr("data-text");

        //data id
        var id = $(this).attr("data-id");
        //data calling from datatables or blade files
        var call = $(this).attr("data-call")?$(this).attr("data-call"):'';
        //type
        var type = $(this).attr("data-type");

        //Open Alert BOX
        blockWarningBox(text, id, type,call);
    });

    //approve warning
     $('body').on('click', '#approve-alert', function () {

        //Text to display on alert
        var text = $(this).attr("data-text");

        //data id
        var id = $(this).attr("data-id");
        //data calling from datatables or blade files
        var call = $(this).attr("data-call")?$(this).attr("data-call"):'';
        //type
        var type = $(this).attr("data-type");

        //Open Alert BOX
        approveWarningBox(text, id, type,call);
    });

    //reject warning
    $('body').on('click', '#reject-alert', function () {

        //Text to display on alert
        var text = $(this).attr("data-text");

        //data id
        var id = $(this).attr("data-id");
        //data calling from datatables or blade files
        var call = $(this).attr("data-call")?$(this).attr("data-call"):'';
        //type
        var type = $(this).attr("data-type");

        //Open Alert BOX
        rejectWarningBox(text, id, type,call);
    });



    // Unblock Warning
    $('body').on('click', '#info-alert', function () {
    //    console.log("11111");
       
        //Text to display on alert
        var text = $(this).attr("data-text");
        //data calling from datatables or blade files
        var call = $(this).attr("data-call")?$(this).attr("data-call"):'';
        
        //data id
        var id = $(this).attr("data-id");

        //type
        var type = $(this).attr("data-type");
        
        //Open Alert BOX
        unblockWarningBox(text, id, type,call);
    });

     // Inactive Warning
     $('body').on('click', '#info-alert1', function () {
        
            //Text to display on alert
            var text = $(this).attr("data-text");
           
            
            //data id
            var id = $(this).attr("data-id");
    
            //type
            var type = $(this).attr("data-type");
              
            var plan=$(this).data('plan');
           
            
            if(plan==1){
              swal(text);  
            }else{
            inactiveWarningBox(text, id, type);

            }
            
            //Open Alert BOX
            // inactiveWarningBox(text, id, type);
        });


         // Warning to change status of beacons
     $('body').on('click', '#info-alertStatus', function () {    
            //Text to display on alert
            var text = $(this).attr("data-text");
            
            //data id
            var id = $(this).attr("data-id");
    
            //type
            var type = $(this).attr("data-type");
            
            //Open Alert BOX
            statusWarningBox(text, id, type);
        });

        // Confirmation popup to close the settlement
     $('body').on('click', '#settlement-alert', function () {    
        //Text to display on alert
        var text = $(this).attr("data-text");
        
        //data id
        var id = $(this).attr("data-id");

        //type
        var type = $(this).attr("data-type");
        
        //Open Alert BOX
        settlementConfirmationBox(text, id, type);
    });

    //Settlement confirmation Data
var settlementConfirmationBox = function (text, id, type,call) {
    swal({
            title: localMsg.BeSure,
            text: text,
            type: "info",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
            confirmButtonText: localMsg.confirmStatus,
            cancelButtonText: localMsg.Cancel,
            closeOnClickOutside: true,
            closeOnEsc: true
        },
        function (isConfirm) {
            if (isConfirm) {
                changeStatus(id, type, 2, call);
            }
        }

    );
};

//Unblock Data
var statusWarningBox = function (text, id, type,call) {
    swal({
            title: localMsg.BeSure,
            text: text,
            type: "info",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
            confirmButtonText: localMsg.changeStatus,
            cancelButtonText: localMsg.Cancel,
            closeOnClickOutside: true,
            closeOnEsc: true
        },
        function (isConfirm) {
            if (isConfirm) {
                changeStatus(id, type, 1, call);
            }
        }

    );
};



 //Unblock Data
 var inactiveWarningBox = function (text, id, type) {
    swal({
            title: localMsg.BeSure,
            text: text,
            type: "info",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
            confirmButtonText: localMsg.Activated,
            cancelButtonText: localMsg.Cancel,
            closeOnClickOutside: true,
            closeOnEsc: true
        },
        function (isConfirm) {
            if (isConfirm) {
                changeStatus(id, type, 1);
            }
        }

    );
};


    //Delete Data
    var deleteWarningBox = function (text, id, type) {
        swal({
                title: text,
                // text: text,
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Delete,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatus(id, type, 3);
                }
            }
        );
    };

    //Block Data
    var blockWarningBox = function (text, id, type, call ='') {
        swal({
                title: text,
                // text: text,
                type: "warning",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Deactivate,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatus(id, type, 2,call);
                }
            }
        );
    };

     //Approve Data
     var approveWarningBox = function (text, id, type, call ='') {
        swal({
                title: text,
                // text: text,
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Approve,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatus(id, type, 4,call);
                }
            }
        );
    };
    //Reject Data
    var rejectWarningBox = function (text, id, type, call ='') {
        swal({
                title: text,
                // text: text,
                type: "warning",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Reject,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatus(id, type, 5,call);
                }
            }
        );
    };
    //Unblock Data
    var unblockWarningBox = function (text, id, type, call='') {
        swal({
                title:text,
                // text: text,
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Activated,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatus(id, type, 1, call);
                }
            }

        );
    };

    // alert($('meta[name="csrf-token"]').attr('content'));
    //change data status
    var changeStatus = function (id, type, toChange, call ='') {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var data = {
            "type": type,
            "id": id,
            "toChange": toChange,
            "_token": csrf_token
        };


        $.ajax({
            method: "POST",
            url: URL + "/admin/changeDataStatus",
            data: data,
            beforeSend: function () {
                ajaxBeforSend();
            },
            error: function () {
                swal("Sorry!!");
                NProgress.done();
            },
            success: function (res) {
                if (200 == res.CODE) {
                    ajaxSuccess(res.MSG,call);
                }
            }
        });
    };


    /**
     *
     * @returns {undefined}
     */
    var ajaxBeforSend = function () {
        NProgress.start();
    };

 


    /**
     *
     * @returns {undefined}
     */
    var ajaxSuccess = function (msg,call) {
        NProgress.done();
        if(call != '' && call == 'blade')
        {
            window.location.reload();
        }
        else{
            //Refresh Data table
            data_table.ajax.reload(null, false);
        }
        

        toastr.success(msg, 'Successfully', {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true
        });
    };






    $('body').on("click", "#send-notification", function () {

        //data id
        var id = $(this).attr("data-id");

        notificationAskBox(id);
    });


    //Unblock Data
    var notificationAskBox = function (id) {
        swal({
                title: localMsg.ChoseOption,
                text: localMsg.SelectOption,
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
                confirmButtonText: localMsg.EditSend,
                cancelButtonText: localMsg.SendNow,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
              
              
                if (isConfirm) {
                   
                    window.location.href = "/notification/" + id + "/edit";
                } else {
                    // alert("2");
                    // return false;
                    sendNotification(id);
                }
            }

        );
    };


    /**
     * to send Bulk notification
     *
     * @param {int} id
     * @returns {void}
     */
    var sendNotification = function (id) {
        $.ajax({
            url: "send-notification/" + id,
            data: "",
            method: "get",
            beforeSend: function () {
                ajaxBeforSend();
            },
            success: function (res) {
                if (res.CODE == 200) {
                    ajaxSuccess(res.MSG);
                }else{
                    swal(res.MSG);
                }
                
            }
        });
    };


    $('body').on("click", ".checkbox", function () {

        //data id
        var id = $(this).attr("data-id");
        var beaconId = $("input[name=beaconId]").val();
        // console.log(beaconId);
        

        if (beaconId != undefined) {    
            var data = {
                "beaconId": beaconId,
                "id": id,
                "_token": csrf_token
            };

            $.ajax({
                method: "POST",
                url: URL + "/assign-beacon",
                data: data,
                beforeSend: function () {
                    ajaxBeforSend();
                },
                error: function () {
                    swal("Sorry!!");
                    NProgress.done();
                },
                success: function (res) {
                 
                    if (200 == res.CODE) {
                      
                        window.location.assign('/beacons/1');
                    } else if(202 == res.CODE){
                        swal("Max Beacon Limit Exceeded, You can't assign more beacons until user upgrade his plan or pay for additional beacon");
                        $('.checkbox').prop( "checked", false );

                        NProgress.done();
                    }else{
                        swal("Something went wrong!!");
                        NProgress.done();
                    }
                }
            });

        } else {
            alert("Please select a Beacon");
            $(this).attr('checked', false);
        }

    });


    /**
     * User Profile Actions Start
     */

    //    Delete user Profile
    $("#delete_user").click(function () {
        var id = $(this).attr('data-id');
        var toChange = $(this).attr('data-status');

        swal({
                title: localMsg.BeSure,
                text: $(this).attr('data-text'),
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Delete,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    chageProfileStatus(id, toChange);
                }
            }
        );
    });


    // Unblock User Function Call
    $("#unblock_user").click(function () {
        var id = $(this).attr('data-id');
        var toChange = $(this).attr('data-status');

        swal({
                title: localMsg.BeSure,
                text: $(this).attr('data-text'),
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Unblock,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    chageProfileStatus(id, toChange);
                }
            }
        );
    });

    // Block User Function Call
    $("#block_user").click(function () {
        var id = $(this).attr('data-id');
        var toChange = $(this).attr('data-status');

        swal({
                title: localMsg.BeSure,
                text: $(this).attr('data-text'),
                type: "warning",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Block,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    chageProfileStatus(id, toChange);
                }
            }
        );
    });


    //user chage Profile Status Ajax hit
    var chageProfileStatus = function (id, toChange) {

        var data = {
            "type": "user",
            "id": id,
            "toChange": toChange,
            "_token": csrf_token
        };

        $.ajax({
            method: "POST",
            url: URL + "/changeDataStatus",
            data: data,
            beforeSend: function () {
                ajaxBeforSend();
            },
            error: function () {
                swal("Sorry!!");
                NProgress.done();
            },
            success: function (res) {
                if (200 == res.CODE) {
                    if (3 == toChange) {
                        window.location.href = 'users';
                        return;
                    }
                    window.location.reload();
                }
            }

        });
    };

    /**
     * User Profile Actions
     */


    $("#logoutLink").click(function () {
        swal({
                title: "Do you want to logout?",
                type: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: localMsg.Logout,
                cancelButtonText: localMsg.Cancel,
                closeOnClickOutside: true,
                closeOnEsc: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = "logout-admin";
                }
            });
    });

    /**
     *
     */
    $(document).on("keyup", '.dataTables_filter input', function () {
        var search = $(this).val();
        var sLength = search.length;

        if (sLength) {
            transformicons.transform('.tcon');
        } else {
            transformicons.revert('.tcon');
        }

    });


    /**
     *
     */
    $(document).on("click", ".tcon-transform", function () {
        $(".dataTables_filter input").val("");
        transformicons.revert('.tcon');
        dataTable();
    });


    /**
     *
     * @returns {undefined}
     */
    var dataTable = function () {
        data_table.search("").draw();
    };

    //Cross Button in Search box end




// setting tags to header
var setTags = function () {
    var html = "";
    $("#filtered_tags").html("");

    $(".filter-select").each(function () {
        if ("" != $(this).val()) {
            var tag = $(this).attr("data-text") + ": " + $("#" + $(this).attr("id") + " :selected").text();
            html += '<span class="filter-tags">' + tag + ' <a href="javascript:void(0)" data-id="' + $(this).attr("id") + '" class="remove-tag"> x </a></span>';
        }
    });


    $(".filter-text").each(function () {
        if ("" != $(this).val()) {
            var tag = $(this).attr("data-text") + ": " + $(this).val();
            html += '<span class="filter-tags">' + tag + ' <a href="javascript:void(0)" data-id="' + $(this).attr("id") + '" class="remove-tag"> x </a></span>';
        }
    });

    $("#filtered_tags").html(html);
    data_table.page.len($("#length").val()).draw();
    //ok
};


//remove tags and filter


$(document).on('click', '.remove-tag', function () {
    var id = "#" + $(this).attr("data-id");
    $(id).val("");
    setTags();
});



//Apply reset filter
$("#applyFilter").click(function () {

    $("#filtered_tags").html("");

 
    $(".filter").each(function () {   
        $(this).val("");
    });
    
   

    $(".filter-box-class").animate({
        right: '-310px'
    });
    
    $(".filter").selectpicker("refresh");

    data_table.ajax.reload(null, true);

}); //function end

/**
 * Filters ENDS
 */


var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");

$("#password").keyup(function () {
    var value = $(this).val();
    var pasLen = value.length;
    if (strongRegex.test(value)) {
        $("#passwd_strength").css({
            "background": "green",
            "width": "100%"
        });
    } else if (mediumRegex.test(value)) {
        $("#passwd_strength").css({
            "background": "orange",
            "width": "50%"
        });
    } else {
        if (pasLen > 6) {
            $("#passwd_strength").css({
                "background": "red",
                "width": "25%"
            });
            $("#oneMinimum").css({
                "color": "green",
                "font-weight": "bold"
            });
        } else if (pasLen < 6 && pasLen > 3) {
            $("#passwd_strength").css({
                "background": "red",
                "width": "1%"
            });
        } else {
            $("#passwd_strength").css({
                "background": "red",
                "width": "0%"
            });
        }

    }
});

//check phone number validation

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode == 46) {
        return true;
    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}



function isFloatNumber(item,evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46)
    {
    var regex = new RegExp(/\./g)
    var count = $(item).val().match(regex).length;
    if (count > 1)
    {
        return false;
    }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
    }
    return true;
    }


$("#menuToggle").click(function () {
    setTable();

});

var setTable = function () {
    if (01) {

        // console.log(data_table);
       
        setTimeout(() => {
            if (data_table) {
                data_table.destroy();
            }
            userDatatable();
        }, 300);

    }
};
$(document).ready(function () {
    if (typeof userDatatable !== 'undefined' && typeof userDatatable === 'function') {
        userDatatable();
    }

});

