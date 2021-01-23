var images = [];
if($("#image-push").val()!=''){
  images = ($("#image-push").val().split(','));
}
var imagesPop = [];
var idAppend = 1;
/**
 * @Upload image to s3 server
 */
var aws_config = {
  region: 'us-east-1',
  bucket: 'appinventiv-development',
  poolid: 'us-east-1:b1f250f2-66a7-4d07-96e9-01817149a439',
  S3_URL: 'https://s3.amazonaws.com/appinventiv-development/'
}
AWS.config.region = aws_config.region;
AWS.config.httpOptions.timeout = 3000000;
AWS.config.credentials = new AWS.CognitoIdentityCredentials({
  IdentityPoolId: aws_config.poolid
});
AWS.config.credentials.get(function (err) {
  if (err) alert(err);
});
var bucketName = aws_config.bucket;
var bucket = new AWS.S3({
  params: {
    Bucket: bucketName
  }
});
navigator.getUserMedia = (navigator.getUserMedia ||
  navigator.webkitGetUserMedia ||
  navigator.mozGetUserMedia ||
  navigator.msGetUserMedia);
var ctxstock = false;
var video;
var mediaStreamTrack;

function startWebcam() {
  if (navigator.getUserMedia) {
    navigator.getUserMedia(

      // constraints
      {
        video: true,
        audio: false
      },

      // successCallback
      function (localMediaStream) {
        video = document.querySelector('video');
        video.srcObject = localMediaStream;
        mediaStreamTrack = localMediaStream;
        $('#webCemModal').show();
        $('#profilePicError').text('');
      },

      // errorCallback
      function (err) {
        alert('Web cam not found');
       
      }
    );
  } else {
    
  }
}

function stopWebcam() {
  mediaStreamTrack.getTracks()[0].stop();

}
//---------------------
// TAKE A SNAPSHOT CODE
//---------------------
var canvas, ctx;

init();
function init() {
  // Get the canvas and obtain a context for
  // drawing in it
  canvas = document.getElementById("myCanvas");
  ctx = canvas.getContext('2d');
}

function snapshot() {

  canvas = document.getElementById("myCanvas");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctxstock = true;
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  cropper.replace(canvas.toDataURL());
  $('#cropImageModal').show();
  $('#webCemModal').hide();
  stopWebcam();
}

function hideWebCemModal() {
  $('#webCemModal').hide();
  stopWebcam();
}



function getRoundedCanvas(sourceCanvas) {
  var canvas = document.createElement('canvas');
  var context = canvas.getContext('2d');
  var width = sourceCanvas.width;
  var height = sourceCanvas.height;

  canvas.width = width;
  canvas.height = height;

  context.imageSmoothingEnabled = true;
  context.drawImage(sourceCanvas, 0, 0, width, height);
  context.globalCompositeOperation = 'destination-in';
  context.beginPath();
  context.rect(0, 0, width, height);

  context.rect(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
  context.fill();

  return canvas;
}

var cropper;
myInitCode();


//  window.addEventListener('DOMContentLoaded', function () {

function myInitCode() {
  var image = document.getElementById('image');
  const cropper = new Cropper(image, {
    aspectRatio: 1 / 1,
    movable: false,
    rotatable: true,
    // responsive: true,
    guides: true,
    // aspectRatio: 1,
    viewMode: 2, // if 0 : no restrictions
    dragMode: 'move',
    cropBoxMovable: true,
    // minCropBoxWidth: 100,
    // minCropBoxHeight: 100,
    crop(event) {
      // minCropBoxWidth: 100
      // minCropBoxHeight: 100
    },
  });
  document.getElementById('upload-pic').onchange = function () {
    
    $(".btnLoadercrop").css("display", "none");

    var input = this;
    var ext = $('#upload-pic').val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
      $('#profilePicError').text('only png,jpg,jpeg ext are allowed');
    }
    else if (input.files && input.files[0]) {

      var reader = new FileReader();
      canvas = null;

      reader.onload = function (e) {

        $('#cropImageModal').show();
        cropper.replace(e.target.result);
        $('#upload-pic').val('');
        $('#profilePicError').text('');
      }
      reader.readAsDataURL(input.files[0]);

    }


  };

  document.getElementById('saveCropImage').onclick = function () {
    $("#saveCropImage").attr("disabled", true);
    $(".sm-loader").removeClass('hide'); //loader is used to show when upload image
    var croppedCanvas;
    var roundedCanvas;
    var roundedImage;
    croppable = true;
    if (!croppable) {
      return;
    }

    // Crop
    croppedCanvas = cropper.getCroppedCanvas();

    // Round
    roundedCanvas = getRoundedCanvas(croppedCanvas);

    var blobimg = roundedCanvas.toDataURL();

    var objKey = Math.random() + ".png";
    var image = dataURLtoFile(blobimg);

    function dataURLtoFile(dataurl) {
      const arr = dataurl.split(',');
      const mime = arr[0].match(/:(.*?);/)[1];
      const bstr = atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], objKey, { type: mime });
    }
    var results = document.getElementById('#crop_image_error');
    $(".btnLoadercrop").css("display", "block");
    var params = {
      Key: objKey,
      ContentType: 'image/png',
      Body: image,
      ACL: 'public-read'
    };
    bucket.putObject(params, function (err, data) {
      if (err) {
        $('#crop_image_error').html('ERROR: ' + err);
      } else {
        idAppend = idAppend + 1;
        var delParams = '"' + objKey + '", ' + '"imageFig_' + idAppend + '"';
       
        
        // console.log(aws_config.S3_URL + objKey);
        $('#add-image').prepend(`<figure id='imageFig_` + idAppend + `' class='add-img wrapper'>
         <img  src='' id='imageview'> <span onclick='removeImage(` + delParams + `)' class='remove-img-sm'>
         <img src='/web/images/cross-black.svg'></span></figure>`);
        $('#imageview').attr('src', aws_config.S3_URL + objKey);
        $('#imageview').css('background-image', 'url(' + aws_config.S3_URL + objKey + ')');
        $('#coverPicInput').val(aws_config.S3_URL + objKey);
        $('#cropImageModal').hide();
        $("#saveCropImage").attr("disabled", false);
        $(".sm-loader").addClass('hide');
        $('#image-error').text('');
        images.push(objKey)
        $('#image-push').val(images);
      }
    })

  };


  // document.getElementById('btnZoomPlus').onclick = function () {
  //   cropper.zoom(0.1);
  // }

  // document.getElementById('btnZoomMinus').onclick = function () {

  //   cropper.zoom(-0.1);

  // }

  //});
}


function hideCropImgModal() {
  $('#cropImageModal').modal('toggle');

}


function removeImage(image, id) {
  
  
  for (var j = 0; j < images.length; j++) {
    if (images[j] == image) {
      var bucketInstance = new AWS.S3();
      var params = {
        Bucket: bucketName,
        Key: image
      };
      bucketInstance.deleteObject(params, function (err, data) {
        if (data) {
          images.splice($.inArray(image, images),1);
          $('#image-push').val(images);
          $('#' + id).remove();
          // console.log('#' + id);
          
        }
        else {
          alert("Check if you have sufficient permissions : " + err);
        }
      });
    }
  }
}

function removeImageEdit(image, id) {
  imagesPop.push(image);
  $('#image-pop').val(imagesPop);
  $('#' + id).remove();
}


