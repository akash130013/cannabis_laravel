@extends("Store::layouts.master")
@section('content') 
<!-- Internal Container End -->
<div class=" custom_container p40">
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="flex-row">
         <div class="flex-col-sm-3 flex-col-xs-12">
            <figure class="user_image">
               <img src="{{$driver->profile_image}}" onerror="imgUserError(this);">
            </figure>
         </div>
         <div class="flex-col-sm-9 flex-col-xs-12">
            <div class="dr-srt-detials">
               <div class="review_count">
                  <span class="rating"><img src="{{asset('asset-store/images/xsm-leaf.png')}}">{{$avgRating ?? 0}}</span>
                  <span class="total">{{$reviewCount ?? 0}} @if($reviewCount<=1) Review @else Reviews @endif</span>
               </div>
               <div class="flex-row m-bt-20">
                  <div class="flex-col-sm-4">
                     <div class="form-fiel-wrapper">
                        <label class="form-label">Name</label>
                        <span class="show-label">{{$driver->name}}</span>
                     </div>
                  </div>
                  <div class="flex-col-sm-4">
                     <div class="form-fiel-wrapper">
                        <label class="form-label">Email</label>
                        <span class="show-label">{{$driver->email}}</span>
                     </div>
                  </div>
               </div>
               <div class="flex-row m-bt-20">
                  <div class="flex-col-sm-4">
                     <div class="form-fiel-wrapper">
                        <label class="form-label">Gender</label>
                        <span class="show-label">{{$driver->gender}}</span>
                     </div>
                  </div>
                  <div class="flex-col-sm-4">
                     <div class="form-fiel-wrapper">
                        <label class="form-label">Phone Number</label>
                        <span class="show-label">{{$driver->phone_number}}</span>
                     </div>
                  </div>
               </div>
               <div class="flex-row ">
                  <div class="flex-col-sm-6">
                     <div class="button_wrapper">
                        <ul>
                           <li><a href="{{route('store.driver.edit',$driver->id)}}" class="primary_btn green-fill btn_sm btn-effect">Edit Profile</a> </li>
                           <li>
                              @if($driver->status == config('constants.STATUS.ACTIVE') )
                              <button type="button" data-request="ajax" data-status="{{config('constants.STATUS.BLOCKED') }}" data-message="Are you sure you want to deactivate this driver ?" data-url="{{route('store.driver.destroy',$driver->id)}}" class="primary_btn green-fill outline-btn  btn_sm">Deactivate</button>
                              @else
                              <button type="button" data-request="ajax" data-status="{{config('constants.STATUS.ACTIVE') }}" data-message="Are you sure you want to activate this driver ?" data-url="{{route('store.driver.destroy',$driver->id)}}"  class="primary_btn green-fill outline-btn  btn_sm">Activate</button>
                              @endif
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="flex-col-sm-6">
                     <div class="button_wrapper text-right">
                        <ul>
                           <li><button class="green-fill outline-btn btn_sm" id="reset-btn">Create Password</button> </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="flex-row m-bt-20">
         <div class="flex-col-sm-12">
            <span class="form_title m-b-20">Vehicle Details</span>
         </div>
      </div>
      <div class="flex-row m-bt-20">
         <div class="flex-col-sm-4">
            <div class="form-fiel-wrapper">
               <label class="form-label">Vehicle Number</label>
               <span class="show-label">{{$driver->vehicle_number ?? 'N/A'}}</span>
            </div>
         </div>
         <div class="flex-col-sm-4">
            <div class="form-fiel-wrapper">
               <label class="form-label">License Number</label>
               <span class="show-label">{{$driver->dl_number ?? 'N/A'}}</span>
            </div>
         </div>
      </div>
      <div class="flex-row m-bt-20">
         <div class="flex-col-sm-4">
            <div class="form-fiel-wrapper">
               <label class="form-label">License Expiry</label>
               <span class="show-label">{{$driver->dl_expiraion_date ?? 'N/A'}}</span>
            </div>
         </div>
         <div class="flex-col-sm-4">
            <div class="form-fiel-wrapper">
               <label class="form-label">Proofs Document</label>
               @foreach ($driver->proofs as $key=> $item)
               <a href="{{$item->file_url}}" target="_blank">
               <span class="show-label">
               @if($item->type == 'other')
               Vehicle Image
               @else
               {{str_replace('_',' ',$item->type)}}
               @endif
               </span>
               </a>
               @if(++$key < count($driver->proofs)),
               @else .
               @endif
               @endforeach
            </div>
         </div>
      </div>
      {{-- {{print_r($statsticData)}} --}}
      <hr class="full_ruller m-b-20">
      @if($reviewCount >0)
      <div class="flex-row align-items-center ">
         <div class="flex-col-sm-3">
            <div class="review-progress">
               <ul>
                  @foreach ($statsticData as $key => $val)
                  <li>
                     <span class="rate-digit">{{$key}}</span>
                     <span class="progress_bar">
                     <span class="pro-ruller" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($val, $ratingCount)}}%;"></span>
                     </span>
                  </li>
                  @endforeach
               </ul>
            </div>
         </div>
         <div class="flex-cols-sm-3">
            <div class="total_review">
               <div class="flex-row align-items-center">
                  <span class="digit-driver">{{$avgRating ?? 0}}</span>
                  <span class="rate">
                     <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <ul class="active" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($avgRating, 5)}}%;">
                           <li></li>
                           <li></li>
                           <li></li>
                           <li></li>
                           <li></li>
                        </ul>
                     </ul>
                  </span>
               </div>
               <a href="javascript:void(0)" style="cursor: default" class="count">{{$ratingCount ?? 0}} @if(isset($ratingCount) && $ratingCount==1) Rating @else Ratings @endif and  {{$reviewCount ?? 0}} @if(isset($reviewCount) && $reviewCount==1) Review @else Reviews @endif </a>
            </div>
         </div>
      </div>
      @endif
      <!--Review Progress close-->
      <div id="scroller">
         @if(!empty($reviews))
         <!--Review Progress Close--> 
         @foreach ($reviews as $item)
         <div class="item-review">
            <!--Repeat Review User-->
            <div class="flex-row">
               <div class="flex-col-sm-12">
                  <div class="reviewer-name-rate">
                     <span class="name">{{$item->user->name ?? 'N/A'}}</span>
                     <span class="reviewer-rate">
                        <div class="review_count">
                           <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}"> {{$item->rate ?? 'N/A'}} </span>
                        </div>
                     </span>
                  </div>
                  <span class="date">{{$item->created_at ?? 'N/A'}}</span>
                  <p class="commn_para m-t-30"> 
                     {{$item->review ?? 'N/A'}}
                  </p>
               </div>
            </div>
            <hr class="pro-ruler">
         </div>
         <!--Repeat Review User Close-->
         @endforeach
         @endif
         @if(!empty($reviews))
         <div class="scroller-status">
            <div class="infinite-scroll-request loader-ellips">
            </div>
            <p class="infinite-scroll-last"></p>
            <p class="infinite-scroll-error"></p>
         </div>
         @endif
      </div>
      <div class="pagination">
         <a href="{{$reviews->nextPageUrl()}}" class="next"></a>
      </div>
   </div>
</div>
@section('modal')
<!---Email Modal Start-->
<div id="password-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal">
            <img src="/asset-store/images/close-card.svg"></button>
            <h4 class="modal-title">Create Password</h4>
         </div>
         <div class="modal-body">
            <div class="modal-padding">
               <div class="form-field-group">
                  <label class="form-label">Enter password</label>
                  <div class="text-filled-wrapper">
                     <input type="password" required  placeholder="Enter Password" name="driver_password" class="modal-input" id="password_type" />
                     <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                     <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                  </div>
                  {{-- <div id="password-strength-status" style="color:red;"></div> --}}
                  <span id="pass-error" class="error"></span>
               </div>
               <input type="hidden" name="driver_email" value="{{$driver->email}}">
               <input type="hidden" name="driver_name" value="{{$driver->name}}">
               <input type="hidden" name="driver_mobile" value="{{$driver->phone_number}}">
               <button class="green-fill btn_sm btn-effect" id="submit-btn">Update</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!---Email Modal End-->
<input type="hidden" name="hidden_pass_url" id="hidden_pass_url" value="{{route('store.driver.change.password')}}">
@endsection
@endsection
@push('script')
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script>
   $('#scroller').infiniteScroll({
            // options
            path: '.next',
            append: '.item-review',
            history: false,
            status: '.scroller-status',
            checkLastPage: true,
            hideNav: '.pagination'
         });
   
   
   
   $("body").on('click','#reset-btn',function(){ 
       $("input[name=driver_password]").val('');
       $("#pass-error").text("");
   
        $('#password-modal').modal('show');
        $('#password-modal').modal({backdrop: 'static', keyboard: false});
   
   })
   
   $("body").on('click','#submit-btn',function(){ 
        
       var pass=$("input[name=driver_password]").val();
       var email=$("input[name=driver_email]").val();
       var name=$("input[name=driver_name]").val();
       var mobile=$("input[name=driver_mobile]").val();
       pass = $.trim(pass);
       passLength = pass.length;
       
      
       
      if(pass=='' || pass==null || pass==undefined){
          $("#pass-error").text("Please enter driver password").addClass('fadeout-error');
          return false;
      }
      if(passLength < 6)
       {
           $("#pass-error").text("Password length must be greater then or eqaul to 6");
           return false;
       }
   
      
    if(pass!='' && email!=''){
   
       $.ajax({
               type: "get",
               url: $("#hidden_pass_url").val(),
               data: {
                   "password": pass,
                   "email": email,
                   "name":name,
                   "mobile_num":mobile,
               },
               cache: false,
               beforeSend: function () {
                   $("#submit-btn").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                   // $("#submit-btn").prop('disabled',true);
               },
               dataType: 'json',
               success: function (response) {
                  
   
                   if (parseInt(response.code) == 200) {
                         swal(response.message);
                         $('#password-modal').modal('hide');
                   } else {
                       $("#pass-error").text(response.message);
                   }
               },
               error: function () {
                   alert('Something went wrong.. Please try again');
               },
               complete: function () {
                   $("#submit-btn").html('');
                   $("#submit-btn").text('Submit');
                  
               }
           });
   
       }else{
           alert('Something went wrong.. Please try again');
       }
   
   
   })
      
   
   
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
</script>
@endpush
@push('css')
@endpush