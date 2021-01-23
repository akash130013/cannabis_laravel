@extends('User::dashboard.layout')
@include('User::includes.header')

         <!--header close-->
@section('content')
         <!--Onboarding flow--->
         <div class="form-container">
            <div class="formBgWrapper formBgWrapperright">
               <div class="custom_container flex-row align-items-center">
                  <div class="frm-rt-sd">
                     <div class="ins-frm-lt-sd">
                        <span class="hd">Location</span>
                        <span class="shd">Enter your delivery location or auto detect 
                        the location.</span>
                        </span>

                        <form action="{{route('submit.user.delivery.location')}}" id="user_details_submit" method="get">
                        <div class="frm-sec-ins">
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-field-group">
                                        <div class="text-field-wrapper"> 
                                              <input type="text"  placeholder="Auto Detect  or Type Location" name="address" id="location" value="{{$data->formatted_address ?? ''}}">
                                            
                                            <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}" class="upload" id="autolocation"></span>  
                                        </div>
                                        <span id="loacation-span"></span>
                                        @if(Session::has('errors'))
                                        <span class="error">{{Session::get('errors')->first('address')}}</span>
                                       @endif



                                        </div>

                                    <input type="hidden" name="lat" id="lat" value="{{$data->lat ?? ''}}">
                                    <input type="hidden" name="lng" id="lng" value="{{$data->lng ?? ''}}">
                                    <input type="hidden" name="locality" id="locality" value="{{$data->city ?? ''}}">
                                    <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1" value="{{$data->state ?? ''}}">
                                    <input type="hidden" name="country" id="country" value="{{$data->country ?? ''}}">
                                    <input type="hidden" name="postal_code" id="postal_code" value="{{$data->zipcode ?? ''}}">
                                    <input type="hidden" name="street_number" id="street_number">
                                    <input type="hidden" name="ip" id="ip">
                                    <input type="hidden" name="route" id="route">

                                    </div>
                                </div>
                             
                                <div class="row">
                                    <div class="col-sm-12 mt-50 mobile-space">
                                        <button type="submit" class="custom-btn green-fill getstarted btn-effect" id="submit_button">Finish </button>
                                       <a class="ch-shd back line-effect" href="{{route('users.age.verification')}}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                     </div>
                  </div>
                  <div class="frm-lt-sd">
                     <div class="lft-msg onboard-right-content">
                        <div class="lft-ms-ico">
                           <img src="{{asset('asset-user-web/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                        </div>
                        <h2>Provide the location 
                           where you want the 
                           happiness to be
                           delivered
                        </h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>

@endsection
@section('pagescript')
    <script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places"></script>
    <script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
    <script src="{{ asset('asset-user/js/location.allow.prompt.js')}}"></script>
    <script src="{{ asset('js/disableBackButton.js')}}"></script>
<script>
    $("#location").geocomplete({
    details: "#user_details_submit",
    componentRestrictions: { country: "us" }
});
$("#user_details_submit").validate({
     errorClass:'error',
    errorElement:'span',
     ignore: [],
        rules: {
            address:{
                required:true,
            },
        },
        errorPlacement: function(error, element) {
            // $(element).parent('div').parent("div").addClass('error-message');
            // error.insertAfter(element);
            error.insertAfter("#loacation-span");
     },
     success: function(label,element) {
        label.parent().parent().removeClass('error-message');
        label.remove(); 
    },
        submitHandler: function(form, event) { 
                // event.preventDefault();
                $("#submit_button").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                form.submit();
        },
    });
    
   

</script>
@endsection

        