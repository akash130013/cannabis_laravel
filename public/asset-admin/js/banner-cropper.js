/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var inputCropper = document.getElementById( 'image-selector-banner' );
var imageCropper = document.getElementById( 'image-to-crop-banner');
var avatar = document.getElementById( 'cropped_image_preview_banner');

var previews = document.querySelectorAll( '.cropped_image_preview_banner');

// var $modal = $( '#cropper-modal-banner' );
var $alert = $( '.alert' );
var cropper = null;
var canvas = null;
var initialAvatarURL = null;


inputCropper.addEventListener( 'change', function ( e ) {
      
    var files = e.target.files;

    var validFileExtensions = ["jpg","JPG", "jpeg","JPEG", "png","PNG"];
    var fileErrors = new Array();
        var file = $(this).val();
        var ext = file.split('.').pop();
        if( $.inArray( ext, validFileExtensions ) == -1) {
            fileErrors.push(file);
        }
   
    if( fileErrors.length > 0 ){
            alert('* File:'+ file +' do not have a valid format!');
            $("#image-selector-banner").val('');
            return false;
    }


    var done = function ( url ) {
        inputCropper.value = '';
        imageCropper.src = url;
        $alert.hide();
        ShowBannerModal();
    };

    var reader;
    var file;


    if ( files && files.length > 0 ) {
        file = files[0];

        if ( URL ) {
            done( window.URL.createObjectURL( file ) );
        }
        else if ( FileReader )
        {
            reader = new FileReader();
            reader.onload = function ( e ) {
                done( reader.result );
            };
            reader.readAsDataURL( file );
        }
    }
} );


// Cropper will initiate when the modal is fully shown
$( '#cropper_modal_banner' ).on( 'shown.bs.modal', function () {
    
    //Start Cropper
    startBannerCropper();

} ).on( 'hidden.bs.modal', function () {
    $( '.modal-backdrop' ).remove();
    $( ".cropped_image_preview_banner").html( "" );
    $( '#cropper_modal_banner' ).removeClass( 'show' );
    cropper.destroy();
    cropper = null;
} );


/**
 *
 * @returns {undefined}
 *
 * viewMode : 0,1,2,3
 * aspectRatio : 0, Means 1=> 1:1 or if value is 2 means 1:2
 * movable : true|false
 * rotatable : true|false
 * responsive : true|false
 */
var startBannerCropper = function () {

    cropper = new Cropper( imageCropper, {
        movable: false,
        rotatable: true,
        responsive: true,
        guides: true,
        aspectRatio: 3/1,
        zoomable:true,
        viewMode: 1, // if 0 : no restrictions

        //start privew. If dont want to use preview remove code from here
        ready: function () {
            croppable = true;
            var clone = this.cloneNode();

            clone.className = '';
            clone.style.cssText = (
                    'display: block;' +
                    'width: 100%;' +
                    'min-width: 0;' +
                    'min-height: 0;' +
                    'max-width: none;' +
                    'max-height: none;'
                    );

            each( previews, function ( elem ) {
                elem.appendChild( clone.cloneNode() );
            } );

        },
        crop: function ( event ) {
            var data = event.detail;
            var cropper = this.cropper;
            var imageData = cropper.getImageData();
            var previewAspectRatio = data.width / data.height;

            each( previews, function ( elem ) {
                var previewImage = elem.getElementsByTagName( 'img' ).item( 0 );
                var previewWidth = elem.offsetWidth;
                var previewHeight = previewWidth / previewAspectRatio;
                var imageScaledRatio = data.width / previewWidth;

                elem.style.height = previewHeight + 'px';
                previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
                previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
                previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
                previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';

            } );
        }
        //Preview Ends.
    } );
};

/**
 *
 * @returns {undefined}
 */
var ShowBannerModal = function () {

    var show = document.createElement( "div" );
    show.className = ' modal-backdrop fade show ';
    document.body.appendChild( show );
    $( '#cropper_modal_banner' ).modal( 'show' );
    $( '#cropper_modal_banner' ).addClass( 'show' );
};


var each = function ( arr, callback ) {
    var length = arr.length;
    var i;

    for ( i = 0; i < length; i++ ) {
        callback.call( arr, arr[i], i, arr );
    }

    return arr;
};

/**
 * Crop Button Functionality
 */
document.getElementById( "crop_it_banner" ).addEventListener( 'click', function () {
   
    // $(".full-loader").css("display","flex");
    if ( cropper ) {  
        canvas = cropper.getCroppedCanvas( {
            width: 500
        });
        // $("#cropped_image_preview_banner".attr( 'src', canvas.toDataURL());
        $("#cropped_image_preview_banner").attr( 'src', canvas.toDataURL());
        $( '#blobImg' ).val(canvas.toDataURL() );
        $( '#cropper_modal_banner' ).modal( 'hide' );
        $( '#cropper_modal_banner' ).removeClass( 'show' );
        $('#cropper_modal_banner').addClass('hide');
        $('.camera').addClass('remove-img');
        $('.remove-img').removeClass('camera');
    }
} );
$(".close-cropper").click(function () {
    $( '#cropper_modal_banner' ).removeClass( 'show' );
    $( '#cropper_modal_banner' ).addClass( 'hide' );
});

function validateFileExtensions(val){
        var validFileExtensions = ["jpg", "jpeg", "gif", "png"];
        var fileErrors = new Array();

            var file = val
            var ext = file.split('.').pop();
            if( $.inArray( ext, validFileExtensions ) == -1) {
                fileErrors.push(file);
            }
       
        if( fileErrors.length > 0 ){
            var errorContainer = $("#validation-errors");
            for(var i=0; i < fileErrors.length; i++){
                errorContainer.append('<label for="title" class="error">* File:'+ file +' do not have a valid format!</label>');
            }
            return false;
        }
        return true;
    }

