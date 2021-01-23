  $(function() {
      $("#hamburger").on("click", function() {
          $(this).toggleClass("active");
          $('body').toggleClass("open-menu");
      });
  });

  $(function() {
      $(".dropmessage").hide();
      $(".info").on("click", function(event) {
          $(".dropmessage").show();
          event.stopPropagation();
      });
      $('body').on('click', function() {
          $(".dropmessage").hide();
      })
  });
  //   Change Input - password type Start
  function password(evt, evt1) {
      const checkbox = document.getElementById(evt);
      checkbox.addEventListener('load', (event) => {
        if (event.target.checked) {
            document.getElementById(evt1).setAttribute('type', "text");

        } else {
            document.getElementById(evt1).setAttribute('type', "password");
        }
    })
      checkbox.addEventListener('change', (event) => {
          if (event.target.checked) {
              document.getElementById(evt1).setAttribute('type', "text");

          } else {
              document.getElementById(evt1).setAttribute('type', "password");
          }
      })
  }
  //   Change Input - password type Ends

  //   Switch Toggle State Start
  var switchStatus = false;
  $(".switchToggle input").on('change', function() {
      let parentSibling = $(this).parent().parent().parent();
      if ($(this).is(':checked')) {
          switchStatus = $(this).is(':checked');
          document.getElementById('toggleLabel').innerHTML = "Open";
          parentSibling.nextAll().children('input').addClass('active')
        //   console.log();

          //   $(this).parent().parent().parent().nextSiblings().Children('.timepicker')
          //   $(this).parent().parent().parent().siblings().Children('.timepicker').addClass('active');

      } else {
          switchStatus = $(this).is(':checked');
          document.getElementById('toggleLabel').innerHTML = "Closed";
          parentSibling.nextAll().children('input').removeClass('active')
              //   $(this).parent().parent().parent().siblings().Children('.timepicker').removeClass('active');
      }
  });

  $('#show_tool_tip_message').qtip({ // Grab some elements to apply the tooltip to
    content: {
        text: 'You will be able to generate your new OTP once timer expires.'
    }
});
  //   Switch Toggle State Ends


  $(".togglesrch").click(function(){
    $(this).parent().parent().parent().toggleClass("active");
    var dataSrc = $(this).attr('data-src');
    var src = $(this).attr('data-src-old');

          if( $(this).parent().parent().parent().hasClass("active")){
             $(this).attr("src",dataSrc);
          }
          else{

             $(this).attr("src",src);
             $(".search input[type='text']").val('');
             $(".list li").show();
          }

        
 });

 function isNumber(evt) {
	evt = evt ? evt : window.event;
	var charCode = evt.which ? evt.which : evt.keyCode;

	if (charCode == 46) {
		return true;
	} else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}


$('.fadeout-error').delay(3000).fadeOut();


function imgProductError(image) {

    image.onerror = "";
    image.src = $("#product_error_url").val();
    return true;
}

function imgStoreError(image) {

    image.onerror = "";
    image.src = $("#store_error_url").val();
    return true;
}

function imgUserError(image) {

    image.onerror = "";
    image.src = $("#user_error_url").val();
    return true;
}
/**
 * 
 * @param {*} limitField 
 * @param {*} limitCount 
 * @param {*} limitNum 
 */
function limitText(limitField, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		// limitCount.value = limitNum - limitField.value.length;
	}
}



$(".mobile-menu").click(function(){               
    $(".head-nav").toggleClass("active")           
 });

 $(".filter_icon").click(function(){
    $(".filter-col").toggleClass("active");
    $(".close_filter").removeClass("active");
 });
 
 $(".close_filter").click(function(){
    $(".filter-col").removeClass("active");
 });

 $(".profile-menu").click(function(){               
    $(".col-left-nav").toggleClass("active")           
 });

 $(".close_left_nav").click(function(){               
    $(".col-left-nav").removeClass("active")           
});



 $(".order-state").click(function(){               
     $(".order-detail-col").toggleClass("active")           
 });


 $(".close_order_state").click(function(){               
    $(".order-detail-col").removeClass("active")           
});



