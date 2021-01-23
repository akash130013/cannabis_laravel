<!DOCTYPE html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
   <meta name="token" content="{{ csrf_token()}}"/>
   <title>Kingdom</title>
   <!-- Favicon -->
   <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
   <link rel="shortcut icon" href="{{asset('asset-store/images/favicon.ico')}}" type="image/x-icon">
   <!-- Favicon End -->
   <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
   <link href="{{asset('asset-store/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
   <link href="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/css/routine.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/css/style.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/css/inner-style.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/css/tooltip.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/css/swal.css')}}" rel="stylesheet">
   <link href="{{asset('asset-admin/css/cropper.min.css')}}" rel="stylesheet" />
   <link href="{{asset('asset-admin/js/circle-loader/css/jCirclize.min.css')}}" rel="stylesheet">
   <link rel="stylesheet" href="{{asset('asset-store/css/jquery.ui.css')}}">
   <!-- <link rel="stylesheet" href="https://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css" /> -->
   <link rel="stylesheet" href="{{asset('css/offline.css')}}">
   <link rel="stylesheet" href="{{asset('css/offlinelang.css')}}">
   <link rel="stylesheet" href="{{asset('asset-store/css/bootstrap.css')}}">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
   <link rel="stylesheet" href="{{asset('asset-store/js/businessHours-master/jquery.businessHours.css')}}"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="{{asset('asset-user-web/css/cannabis.css')}}">
   <link href="{{asset('asset-store/css/inner-media.css')}}" rel="stylesheet">
   @stack('css')
</head>
<body>
   <div class="app_in_wrapper">
      <header>
         <div class="header_inner">
            <!-- Branding -->
            <div class="nav-brand">
               <a href="{{route('store.dashboard')}}" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt="Kingdom"></a>
            </div>
            <!-- Branding End -->
            <!--nav wrapper-->
            <nav>
               <ul class="headr_wrap">
                  <li class="header_dropdown">
                     <a href="{{route('store.notification.index')}}" class="headr_notify">
                        <figure class="h-icon">
                           <span class="digit"></span>
                           <!-- <img src="{{asset('asset-store/images/notification.svg')}}">  -->
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="notify-icon">
                              <path fill="none" d="M0 0h24v24H0z"/>
                              <path d="M5 18h14v-6.969C19 7.148 15.866 4 12 4s-7 3.148-7 7.031V18zm7-16c4.97 0 9 4.043 9 9.031V20H3v-8.969C3 6.043 7.03 2 12 2zM9.5 21h5a2.5 2.5 0 1 1-5 0z" />
                           </svg>
                        </figure>
                        <span>Notification</span>
                     </a>
                     <div class="fisrtlevl_list user_notification">
                        <h4 class="txt_title">Notifications</h4>
                        <ul>
                           @if(Session::get('notificationList'))
                           @foreach(Session::get('notificationList') as $val)
                           <li>
                              <p class="txt_para">{{$val->title}}</p>
                              <span class="txt_time">{{$val->created_at->diffForHumans()}}</span>  
                           </li>
                           @endforeach
                           @endif
                        </ul>
                        <a href="{{route('store.notification.index')}}">See All Notifications</a>
                     </div>
                  </li>
                  <li class="header_dropdown">
                     <a href="javascript:void(0)">
                        @if(Auth::guard('store')->user()->avatar ==null)
                        <figure class="user-img-sm"> {{ucfirst(substr(Auth::guard('store')->user()->name,0,1)).ucfirst(substr(Auth::guard('store')->user()->last_name,0,1))}} </figure>
                        @else
                        <figure class="user-img-sm"><img src="{{Auth::guard('store')->user()->avatar}}" /></figure>
                        @endif 
                     </a>
                     <div class="fisrtlevl_list">
                        <ul>
                           <li> <a href="{{route('storeprofile.index')}}">My Profile</a> </li>
                           <li> <a href="{{route('store.order.list',['type'=>'pending'])}}">My Orders</a> </li>
                           <li><a data-toggle="modal" data-target="#logout" title="Logout from store panel">Sign-out</a></li>
                        </ul>
                     </div>
                  </li>
               </ul>
            </nav>
            <!--nav wrapper close-->
         </div>
         <hr class="header-ruler">
         <div class="header_inner in-head-pad text-center">
            <span class="mobile-menu">
            <img src="{{asset('asset-store/images/menu-line.svg')}}"  alt="mobile menu"/>
            </span>
        
            <!--header menu-->
            <div class="head-nav tab_wrapper">
               <ul>
                  <li>
                     <a src="{{route('store.location.list')}}" href="{{route('store.location.list')}}" class="{{ ((in_array(request()->route()->getName(),['store.location.list'])) ? 'active' : '') }}">Locations</a>
                  </li>
                  <li>
                     <a src="{{route('store.driver.list',['status'=>'all'])}}" class="{{ (request()->segment(2) == 'driver' ? 'active' : '')}}" href="{{route('store.driver.list',['status'=>'all'])}}">Drivers</a>
                  </li>
                  <li>
                     <a src="{{route('store.product.dashboard')}}" class="{{ ((in_array(request()->route()->getName(),['store.product.dashboard','store.product.add-page','show.product.detail','store.edit.product'])) ? 'active' : '') }}"  href="{{route('store.product.dashboard')}}">Products</a>
                  </li>
                  <li>
                     <a  class="{{ (request()->segment(2) == 'order' ? 'active' : '')}}" href="{{route('store.order.list',['type'=>'pending'])}}">Orders</a>
                  </li>
                  <li>
                     <a href="{{route('store.earning.list')}}" class="{{ ((in_array(request()->route()->getName(),['store.earning.list'])) ? 'active' : '') }}">Earnings</a>
                  </li>
                  <li>
                     <a href="{{route('store.offer.list')}}" class="{{ ((in_array(request()->route()->getName(),['store.offer.list','store.add.offer.page','offer.edit'])) ? 'active' : '') }}" >Offers</a>
                  </li>
               </ul>
            </div>
            <!--header menu close-->
         </div>
      </header>
      <!-- Header End -->
      <!-- Internal Container -->
      <!-- Internal Container End -->
      @yield('content')
      <input type="hidden" id="product_error_url" value="{{config('constants.DEAFULT_IMAGE.STORE_PRODUCT_IMAGE')}}">
      <input type="hidden" id="store_error_url" value="{{config('constants.DEAFULT_IMAGE.STORE_IMAGE')}}">
      <input type="hidden" id="user_error_url" value="{{config('constants.DEAFULT_IMAGE.USER_IMAGE')}}">
      <!-- Footer End -->      
   </div>
   <!--logout  Modal-->
   <div class="modal fade logout" id="logout" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" data-dismiss="modal">
               <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
               <h4 class="modal-title">Logout</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <h1 class="confirm_heading"> Logout Confirmation</h1>
                  <p class="commn_para"> Are you sure you want to logout?</p>
                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <a href="{{route('store.logout')}}">
                        <button type="button" class="custom-btn green-fill getstarted btn-effect">Logout</button>
                        </a>
                        <a class="ch-shd back line_effect" href="javascript:void(0)"  data-dismiss="modal">No, Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   
   <input type="hidden" id="controller_redirect_message" value="{{Session::get('success')['message'] }}">
   @if(isset(Session::get('success')['code']) && Session::get('success')['code']==config('constants.SuccessCode'))
      <input type="hidden" id="controller_redirect_message_type" value="success">
      @else
      <input type="hidden" id="controller_redirect_message_type" value="warning">
   @endif

   <div class="modal fade" id="activeInactiveModal" role="dialog">
      <div class="modal-dialog statusDialogue">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close closeStatus" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Change Status</h4>
            </div>
            <div class="modal-body">
               <p id="paraText"></p>
            </div>
            <input type="hidden" id="newStatus">
            <input type="hidden" id="Id">
            <input type="hidden" id="type" value="product">
            <div class="btn-group">
               <button type="button" class="btn custom-btn active-fill getstarted backbtn blockUnblockBtn"></button>
               <button type="button" class="btn custom-btn green-fill getstarted product_detail_view"  data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   @yield('modal')
   <!-- JS -->
   {{-- <script>
      var notiUrl = '{{}}';
   </script> --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
   <script src="{{asset('asset-store/js/jquery.min.js')}}"></script>
   <script src="{{asset('asset-store/js/bootstrap.min.js')}}"></script>
   {{-- <script src="{{asset('asset-store/js/bootstrap-select.js')}}"></script> --}}
   <script src="{{asset('js/offline.js')}}"></script>
   <script src="{{asset('asset-user/js/infinit.scroll.min.js')}}"></script>
   <script src="{{asset('asset-store/js/tooltip.js')}}"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places"></script>
   <script src="{{asset('asset-store/js/common.js')}}"></script>
   <script src="{{asset('asset-store/js/sweetalert.js')}}"></script>
   <script src="{{asset('asset-store/js/bootstrap-datetimepicker.min.js')}}"></script>
   <script src="{{asset('asset-store/js/toster.js')}}"></script>
   <script src="{{asset('asset-admin/js/lang/en/language.js')}}"></script>
   <script src="{{asset('js/disable.autocomplete.js')}}"></script>
   <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
   <script src="{{asset('asset-store/js/previewImage.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   <script>      
      //message-toaster
      var myToast = new Toast({
          title: '', 
          content: $("#controller_redirect_message").val(),
          append: false, // selector
          timeout: 10000,
          showProgress: true ,
          easing: 'quart-in-out',
          // warning, info, success, caution
          type: $("#controller_redirect_message_type").val()
      
      });
      
      @if(Session::has('success'))
        myToast.show();
      @endif
      
      
      
        Offline.options = {
          // to check the connection status immediatly on page load.
          checkOnLoad: false,
      
          // to monitor AJAX requests to check connection.
          interceptRequests: true,
      
          // to automatically retest periodically when the connection is down (set to false to disable).
          reconnect: {
            // delay time in seconds to wait before rechecking.
            initialDelay: 3,
      
            // wait time in seconds between retries.
            delay: 10
          },
      
          // to store and attempt to remake requests which failed while the connection was down.
          requests: true
        };
      
   </script>
   <!-- JS End -->
   <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
          }
      });
      $(document).ready(function () {
              $.ajax({
                      type: "get",
                      url: "{{route('store.notification.count')}}",
                      success: function(response) {
                          if(response <= 0)
                          {
                              $(".digit").remove();
                          }else{
                              $(".digit").html(response);
                          }
                              }
      
          });
      
      });
      
      $('#fileToUpload').on('change',function(){
          var xVal = $(this).val();
          $('#companylogo').val(xVal);
          
          if($('#companylogo').val()){
              $(".remove-file").show();
              $(".upload-btn").hide();
             
              $("#fileToUpload").val('');
              
          }
          else{
              $(".remove-file").hide(); 
              $(".upload-btn").show();
          }
      });
      $('.remove-file').on('click',function(){
          $(".upload-btn").show();
          $(".remove-file").hide(); 
          $('#companylogo').val('');
      });
      function showPassword() {
      var x = document.getElementById("password_type");
      if (x.type === "password") {
      $("#show_eye").show(); 
      $("#hide_eye").hide(); 
      x.type = "text";
      } else {
      x.type = "password";
      $("#show_eye").hide(); 
      $("#hide_eye").show(); 
      } 
      }
      function checkPasswordStrength() {
      var number = /([0-9])/;
      var alphabets = /([a-z])/;
      var upperCase = /([A-Z])/;
      var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
      if ($('#password_type').val().length < 8) {
      $('#password-strength-status').removeClass();
      $('#password-strength-status').addClass('weak-password');
      $('#password-strength-status').addClass('error');
      $('#password-strength-status').html("Weak (good to have atleast 8 characters.)");
      // $("#submit-btn").prop('disabled', true);
      $('#password-strength-status').css('color', 'red');
      // $('#password-strength-status').addClass('error');
      
      } else {
      if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
          $('#password-strength-status').removeClass();
          $('#password-strength-status').addClass('strong-password');
          $('#password-strength-status').html("Strong");
          $('#password-strength-status').css('color', 'green');
          $("#submit-btn").prop('disabled', false);
      } else {
          $('#password-strength-status').removeClass();
          $('#password-strength-status').addClass('medium-password');
          $('#password-strength-status').html("Medium");
         //  $("#submit-btn").prop('disabled', true);
          // $('#password-strength-status').css('color', 'red');
          $('#password-strength-status').addClass('error');
      
      }
      }
      }
      $(document).ready(function () {
        //your code here
        $('#datetimepicker3').datetimepicker({
             useCurrent: false,
             format: 'YYYY-MM-DD',
        });
        $('#datetimepicker4').datetimepicker({
             useCurrent: false,
             format: 'YYYY-MM-DD',
        });
        
      //   $(function () {
      //        $('select').selectpicker();
      //   });
      
      });  
   </script>    
   @stack('script')
</body>
</html>