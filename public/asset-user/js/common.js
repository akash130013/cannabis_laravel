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
   $(function() {
       $(".field-close").hide();
       $(".product-search .inpt_prdct").on("click", function(event) {
           $(".field-close").show();
           event.stopPropagation();
       });
       $('body').on('click', '.field-close', function() {
               $(".product-search .inpt_prdct").val('');
               $(".field-close").hide();
           })
           //    $('body').on('click', function() {
           //        $(".field-close").hide();
           //    })
   });
   //   Change Input - password type Start
   function password(evt, evt1) {
       const checkbox = document.getElementById(evt);
       checkbox.addEventListener('change', (event) => {
           if (event.target.checked) {
               document.getElementById(evt1).setAttribute('type', "text");

           } else {
               document.getElementById(evt1).setAttribute('type', "password");
           }
       })
   }
   //   Change Input - password type Ends



  



 /**do not alloweb more than one space */

let space = 0;
let other = 0;
function removeSpace(e,val) {
     
    if (e.which == 32) {
        if (space > 0) {
            return false;
        }
        space++;
    } else {
        space = 0;
        other++;
    }
    if (e.which == 32 && !val.length) {
        e.preventDefault();
    }
}


/**
 * @desc used to show fadeout messages
 */


$('.fadeout-error').delay(3000).fadeOut();

/**
 * @desc used to close the error message when click on the close button
 * @date 01/02/19
 */
$('body').on('click', '.cross-icon', function() {
	$('.push-notification-wrap').remove();
});

/**snack bar html */
function showSnackbar(para) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
  
    // Add the "show" class to DIV
    x.className = "show";
   x.innerHTML=para;
//    alert(para);
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }


//***for the wish list added */
 $("body").on('click', '.mark_fav', function() {
    
    var baseUrl=$("#baseUrl").val();
    var token=$("#bearerToken").val();
    var id=$(this).data('id');
    
    
    var pageUrl=baseUrl+$("#addwishlist").val()+"/"+id;
   
    var para='Added to your wishlist';

    var $this = $(this);
    if($(this).hasClass("active")==true){
       para='Removed from your wishlist';
        pageUrl=baseUrl+$("#removewishlist").val()+"/"+id;
       
    }
    
    $("#noti_text").text(para);  //show popup
    $("#noti_head").text('Wishlist');
            $.ajax({
            url: pageUrl,
            type: 'get',
            // Fetch the stored token from localStorage and set in the header
            headers: {"Authorization": token},
            beforeSend: function () {
               
                $this.addClass('disabledbutton');
            },
            success : function (params) {     
            //   $(".push-notification-wrap").css('display','flex');
             $this.toggleClass('active');
             $this.removeClass('disabledbutton');
             showSnackbar(para);
            //  $('.push-notification-wrap').delay(1000).fadeOut();
            },
            error: function () {
                alert('Something went wrong.. Please try again');
            },
            complete: function () {
                $this.html('');
            }
           });
   })


   ///////////////////////////for the store aaded to bookmark/////
   $("body").on('click','.mark_fav_store',function(){

    var baseUrl=$("#baseUrl").val();
    var token=$("#bearerToken").val();
    var id=$(this).data('id');
    var pageUrl=baseUrl+$("#addBookMark").val()+"/"+id;
    var $this = $(this);
  
    var para='Store added to your bookmark';
    if($(this).hasClass("active")==true){
        para='Store removed from your bookmark';
        pageUrl=baseUrl+$("#removeBookMark").val()+"/"+id;
    }
    // $("#noti_head").text('Bookmark');
    // $("#noti_text").text(para);  //show popup
   
        $.ajax({
        url: pageUrl,
        type: 'get',
        // Fetch the stored token from localStorage and set in the header
        headers: {"Authorization": token},
        beforeSend: function () {
            // $this.html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $this.addClass('disabledbutton');
        },
        success : function (params) {     
        //  $(".push-notification-wrap").css('display','flex');
         $this.toggleClass('active');
        $this.removeClass('disabledbutton');
         showSnackbar(para);
        //  $('.push-notification-wrap').delay(1000).fadeOut();
        },
        error: function () {
            alert('Something went wrong.. Please try again');
        },
        complete: function () {
            $this.html('');
        }
       });
 });

///type only integeres

function isNumber(evt) {
	evt = evt ? evt : window.event;
    var charCode = evt.which ? evt.which : evt.keyCode;


  // console.log(charCode);

	if (charCode == 46) {
		return true;
	} else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}


//remove error messge when user finish typing

// function removeEroor(evt){
//     var num=$(this).val();
//     console.log(num);
//     if(num.length==0){
//         $('.error').text('');
//     }
    
// }

  // hide error message after 3 sec 
//   setTimeout(function() {
//     $('.alreadyTaken').fadeOut('fast');
//  }, 3000); 

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