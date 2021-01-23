$( document ).ready( function () {


   

    /**
     * @name: add cms content form
     * @description: Thie function is used to validate admin add content form in cms.
     */
    $( "#cms_add_form" ).validate( {
//$('.status_dropdown-error').hide();
        ignore: [ ],
        debug: false,
        errorClass: "alert-danger",
        rules: {
            title: {
                required: true,
                maxlength: 90
            },
            description: {
                required: true,
                // required: function ()
                // {
                //     tinymce.init.page_desc.updateElement();
                // },
            },
            status: {
                required: true,
            }
        },
        /* use below section if required to place the error*/
        errorPlacement: function ( error, element )
        {
            if ( element.attr( "name" ) == "description" )
            {
                $( '.description-error' ).show();
            }
            else if ( element.attr( "name" ) == "status" ) {
                $( '.status_dropdown-error' ).show();
            }
            else {
                $( '.title-error' ).show();
            }

        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );

    $( "#version_add_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            name: {
                required: true,
                maxlength: 20
            },
            title: {
                required: true,
                maxlength: 100
            },
            desc: {
                required: true,
                maxlength: 250
            },
            platform: {
                required: true,
            },
            update_type: {
                required: true,
            },
            current_version: {
                required: true,
            }
        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );


    $( "#notification_add_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            title: {
                required: true,
                rangelength: [ 10, 150 ]
            },
            message: {
                required: true,
                rangelength: [ 10, 250 ]
            },
            platform: {
                required: true,
            },
            gender: {
                required: true,
            },
            link: {
                url: true
            }
        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );




    $( "#password_change_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            old_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 50
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 50,
                equalTo: "#password"
            }
        },
        messages: {
            old_password: localMsg.oldpasswordEmpty,
            new_password: localMsg.newpasswordEmpty,
            confirm_password: {
                required: localMsg.confirmpasswordEmpty,
                equalTo: localMsg.passwordnotmatch
            }

        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );


    $( "#subadmin_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            admin_name: {
                required: true,
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_password: {
                required: true,
                minlength: 6,
                maxlength: 50
            },
            admin_repassword: {
                required: true,
                minlength: 6,
                maxlength: 50,
                equalTo: "#admin_password"
            }
        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );

    /**
     *
     */
    $( "#admin_edit_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            admin_name: {
                required: true,
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_password: {
                minlength: 6,
                maxlength: 50
            },
            admin_repassword: {
                minlength: 6,
                maxlength: 50,
                equalTo: "#admin_password"
            }
        },
        submitHandler: function ( form ) {
            form.submit();
        }
    } );

    /*** Change Password Page Script ***/
    $( document ).ready( function () {
        $( 'body' ).on( 'click', '.pass-show-hide', function () {
            if ( $( this ).parents( '.form-group' ).find( 'input' ).attr( 'type' ) === 'password' ) {
                $( this ).parents( '.form-group' ).find( 'input' ).attr( 'type', 'text' );
                $( this ).children().removeClass( 'fa-eye-slash' ).addClass( 'fa-eye' );
            }
            else {
                $( this ).parents( '.form-group' ).find( 'input' ).attr( 'type', 'password' );
                $( this ).children().removeClass( 'fa-eye' ).addClass( 'fa-eye-slash' );
            }
        } );
    } );




    /**
     * Send Notification form validation
     */
    $( "#send_notification_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            title: {
                required: true,
            },
            message: {
                required: true,
                minlength: 6,
                maxlength: 250
            }
        },
        submitHandler: function (  ) {
            sendNotification();
        }
    } );


    /**
     *
     * @returns {undefined}
     */
    var sendNotification = function () {
        var title = $( "#title" ).val();
        var link = $( "#link" ).val();
        var message = $( "#messagetext" ).val();
        var iss = $( "#iss" ).val();

        var data = {
            title: title,
            link: link,
            message: message,
            '_token': csrf_token,
            'iss': iss
        };

        $.ajax( {
            url: "send-user-notification",
            method: "post",
            data: data,
            error: function () {

            },
            beforeSend: function () {
                NProgress.start();
            },
            success: function ( res ) {
              
                if ( 200 == res.CODE ) {
                    NProgress.done();
                    toastr.success( res.MSG, 'Successfully', {
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": true
                    } );
                    $( ".notification-class" ).animate( { right: '-300px' } );

                    $( "#title" ).val( '' );
                    $( "#link" ).val( '' );
                    $( "#messagetext" ).val( '' );
                }
            }
        } );

    };


    $( document ).ready( function () {

        $( "#sendNotification" ).click( function () {
            $( ".notification-class" ).animate( { right: '0px' } );
            $( "#title" ).focus();
        } );


        $( "#filter_user_data" ).click( function () {
            $( ".filter-box-class" ).animate( { right: '0px' } );
            $( "#title" ).focus();
        } );

        $( "#cancel_btn" ).click( function () {
            $( ".notification-class" ).animate( { right: '-310px' } );
            $( ".filter-box-class" ).animate( { right: '-310px' } );
        } );


    } );



    /**
     *
     */
    $( "#subscription_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            subscription_name: {
                required: true,
                minlength: 5,
                maxlength: 200
            },
            price: {
                required: true,
                maxlength: 100
            },
            description: {
                required: true,
                maxlength: 250
            }
        },
        submitHandler: function ( form ) {
            saveSubscription();
        }
    } );





    /**
     *
     */
    $( "#subscription_update_form" ).validate( {
        errorClass: "alert-danger",
        rules: {
            updateName: {
                required: true,
                minlength: 5,
                maxlength: 200
            },
            updatePrice: {
                required: true,
                maxlength: 100
            },
            updateDescription: {
                required: true,
                maxlength: 250
            }
        },
        submitHandler: function ( form ) {
            updateSubscription();
        }
    } );

} );

