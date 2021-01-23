@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

<!--header close-->
@section('content')

@yield('nav-bar')


<section class="inner_centerpanel">
   <div class="custom_container">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Account Overview</h2>
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
         <img src="{{asset('asset-user-web/images/menu-line.svg')}}" class="profile-mobile-menu">
         </div>
      </div>
      <div class="flex-row account_wrapper">
         <!--Setting Menu Col-->
         @yield('left-panel')
         <!--Setting Menu Col Close-->
         <!--Setting Detail Col-->
         <div class="account-details-col">
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                  <h2 class="title-heading">Saved Addresses</h2>
               </div>
               <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                  {{-- <button type="button" class="green-fill-btn btn-effect green-fill btn-sm" data-toggle="modal" data-target="#myModal-edit-address"> Add New Address</button> --}}
                  <button type="button" class="green-fill-btn btn-effect green-fill btn-sm" id="add_address"> Add New Address</button>
              
               </div>
            </div>
            <div class="flex-row m-t-b-30">
               <div class="flex-col-sm-12">

                  @if($DeliveryLocations->count())
                  @foreach($DeliveryLocations as $val)
                  
                  <div class="address_card">
                     <div class="inner_wrapper">
                     <span class="save_address_type">{{$val->address_type ?? 'N/A'}}</span>
                        <h3 class="candidate_name">{{$val->name}}</h3>
                        <div class="address">
                           <p>House No: {{$val->address}} </p>
                           <p> {{$val->formatted_address}}, {{$val->zipcode}}</p>
                        <p> {{$val->state}}, {{$val->country}}</p>
                           <p>Mobile Number: {{$val->mobile}} </p>
                          
                        </div>
                     </div>
                     <div class="addressAccordian-buttons">
                        <div class="addressAccordian-button edit-address" data-edit-id="{{$val->id}}"> EDIT </div>
                        <div class="addressAccordian-buttonDivider"></div>
                        <div class="addressAccordian-button edit-remove-address" edit-remove-id="{{$val->id}}" data-toggle="modal" data-target="#myModal-delete-address"> REMOVE </div>
                     </div>
                  </div>
                  @endforeach
                  @else
                  <div class="address_card">
                     <span>No Address found. Please click on add address button to create one.</span>
                  </div>

                  @endif



               </div>
            </div>
         </div>
         <!--Setting Detail Col Close-->
      </div>
   </div>
</section>


<div class="modal fade" id="myModal-edit-address" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" onclick="location.reload()"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Add New Address</h4>
         </div>

         <form action="{{route('add.user.delivery.address')}}" method="get" id="add_delivery_address">
            <input type="hidden" name="address_type_val" value="Home">
            <div class="modal-body">
               <div class="modal-padding">

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="username" placeholder="Full Name*" class="remove-data" onkeypress="return removeSpace(event,$(this).val())">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-group">
                           <div class="text-field-wrapper">
                              <input type="tel" name="phone" maxlength="15" onkeypress="return isNumber(event)" id="phone" value="{{Auth::guard('users')->user()->country_code.Auth::guard('users')->user()->phone_number}}" placeholder="Contact Number*" data-smk-icon="glyphicon-asterisk" required="required" class="padding-left">
                           </div>
                           <span id="valid-msg" class="hide"></span>
                           <span id="error-msg" class="hide error-message"></span>

                           @if(Session::has('errors'))
                           <span class="error">{{Session::get('errors')->first('phone')}}</span>
                           @endif

                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">

                        <div class="form-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="address" placeholder="Auto Detect or Enter Location*" id="location" value="" required class="remove-data">
                              <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}"  id="autolocation"></span>
                           </div>
                           <span id="address-error"></span>
                        </div>

                        <input type="hidden" name="lat" id="lat" value="" class="remove-data">
                        <input type="hidden" name="lng" id="lng" value="" class="remove-data">
                        <input type="hidden" name="street_number" id="street_number" class="remove-data">
                        <input type="hidden" name="country" id="country" class="remove-data">
                        <input type="hidden" name="ip" id="ip" class="remove-data">
                        <input type="hidden" name="route" id="route" class="remove-data">

                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="locality" id="locality" placeholder="Locality/Town*" class="remove-data">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="administrative_area_level_1" id="administrative_area_level_1" placeholder="State*" class="remove-data">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="houseno" id="houseno" placeholder="House Number*" class="remove-data">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="postal_code" id="postal_code" maxlength="6" placeholder="Pincode*" class="remove-data">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <label class="form_label">Type Of Address</label>
                        <div class="form-field-group">
                           <div class="address_type_list">
                              <ul>  
                                 <li>
                                 <label class="address_type active" data-text="Home">
                                    <img src="{{asset('asset-user-web/images/home.svg')}}"> Home
                                 </label>
                                </li>
                                 <li>
                                 <label class="address_type" data-text="Office">
                              <img src="{{asset('asset-user-web/images/office.svg')}}"> Office
                           </label>
                                  </li>
                                 <li>
                                 <label class="address_type" data-text="Other">
                              <img src="{{asset('asset-user-web/images/location-sm.svg')}}"> Other
                           </label>
                                  </li>
                              </ul>
                           </div>

                        </div>
                     </div>
                  </div>



               </div>


            </div>

            {{-- <div class="addressAccordian-buttons">
               
               <button type="submit" class="btn btn-info addressAccordian-button" id="submit_button"> Add </button>
               <button type="button" class="btn btn-danger addressAccordian-button" onclick="location.reload()"> Cancel </button>
             
            </div> --}}
            <div class="button-wrapper text-center">
               <ul>
                 
                  <li>
                  <button type="submit" class="green-fill-btn btn-effect green-fill btn-sm" id="submit_button"> Add </button>
                  </li>

                  <li>
                       <a href="javascript:void(0)" class="line_effect" onclick="location.reload()"> Cancel</a>
                      
                      
                  </li>
               
               </ul>        
           </div>
            <input type="hidden" name="dialcode" id="setDialCodeId">
         </form>
      </div>
   </div>
</div>


<div class="modal fade" id="edit-address" role="dialog">
   <div class="modal-dialog" id="edit_html_id">
      <!-- Modal content-->
   </div>
</div>


<!--Edit Profile Close-->
<!--Delete Address Modal-->
<div class="modal fade" id="myModal-delete-address" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" data-dismiss="modal" class="modal-close"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Address Delete</h4>
         </div>
         
         <form action="{{route('user.remove.address')}}" method="get">
         <div class="modal-body">
            <div class="modal-padding">
               <h1 class="confirm_heading"> Delete Confirmation</h1>
               <p class="commn_para">Are you sure want to delete this address ?</p>
               <div class="flex-row m-t-30">
                  <div class="flex-col-sm-12 mt-50 mobile-space">
                     <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes, Delete</button>
                     <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal" >No, Cancel</a>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="id" id="hidden_remove_id">
         </form>

      </div>
   </div>
</div>
<input type="hidden" name="search_type" value="1">

@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>
<script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
<script src="{{ asset('asset-user/js/profile.location.autofill.js')}}"></script>

  

<script>

$("body").on('click','.address_type',function(){
   $('.address_type').each(function() {
      $(this).removeClass('active');
   })

   var type=$(this).data('text');
   $("input[name=address_type_val]").val(type);
   $(this).addClass('active');
})


$("#myModal-edit-address").on('shown.bs.modal', function (e) {
  // do something...
$("#location").geocomplete({
    details: "form",
    componentRestrictions: { country: "us" }
});

});



   $("#add_delivery_address").validate(
      {
      errorClass: 'error',
      errorElement: 'span',
      ignore: [],
      rules: {

         phone: {
            required: true,
         },
         address:{
            required:true,
         },
         locality:{
            required:true,
         },
         administrative_area_level_1:{
          required:true, 
         },
         houseno:{
          required:true,
         },
         username: {
            required: true,
            maxlength: 50,
            minlength: 4
         },
       
         postal_code: {
            required: true,
            digits: true
         }

      },
      errorPlacement: function(error, element) {
         // $(element).parent('div').parent("div").addClass('error-message');
         if (element.attr("name") == "address") {
                           error.insertAfter("#address-error");
                 }else{
                     error.appendTo($(element).parents('.text-field-wrapper')).next();
                 }
         // error.insertAfter(element);
      },
      // success: function(label, element) {
      //    label.parent().parent().removeClass('error-message');
      //    label.remove();
      // },
      submitHandler: function(form, event) {
         //event.preventDefault();

         if (iti.isValidNumber()) {
            $("#submit_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            var getCode = iti.b.dataset.dialCode;
            $("#setDialCodeId").val(getCode);
            form.submit();
         }
      },
   });

   var EDIT_ADDRESS_INFO = 
   {

      __handle_edit_address: function(id, $this) {

         $.ajax({
            type: "get",

            url: "{{route('user.get.edit.form')}}",

            data: {
               id: id
            },

            beforeSend: function() {

               $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');

            },

            success: function(response) {
               $("#edit_html_id").html(response.html);
               $('#edit-address').modal('show');
            },
            error: function() {

               alert("Something went wrong. Please try again");
            },
            complete: function() {

               $this.html('EDIT');
            }

         });

      },


      __submit_edit_address_form: function(form) {

         $.ajax({
            type: "get",

            url: form.attr("action"),

            data: form.serialize(),

            success: function(response) {

             

            }

         });

      }
   }

   $('body').on('click', '.edit-address', function() {
      var id = $(this).attr('data-edit-id');
      var $this = $(this);
      EDIT_ADDRESS_INFO.__handle_edit_address(id, $this);

   });

   $("body").on('click','.edit-remove-address',function(){
      var id = $(this).attr('edit-remove-id');
      $("#hidden_remove_id").val(id);
   });

  
  //**show model
$('body').on('click','#add_address',function () {
   
    $(".remove-data").each(function (e) {
       $(this).val('');
    })
    $('#myModal-edit-address').modal({backdrop: 'static', keyboard: false});
   $('#myModal-edit-address').modal('show');
})


</script>

@endsection

@endsection