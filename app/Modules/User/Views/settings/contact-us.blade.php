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
                     <h2 class="sub-title">Contact Us</h2>
                     <p class="help_para">
                        Looking to contact 420 Kingdom? Send us a message using the fields below. <br>
                        We look forward to hearing from you!
                     </p>

                     <form action="{{route('user.submit.contactus')}}" method="post" id="contact_us_form">
                        @csrf
                     <div class="flex-row m-t-30">
                        <div class="flex-col-sm-6">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" name="name" placeholder="Your Name" onkeypress="return removeSpace(event,$(this).val())">
                              </div>
                              
                              @if(Session::has('errors'))
                                 <span class="error">{{Session::get('errors')->first('name')}}</span>
                              @endif

                           </div>
                        </div>
                     </div>
                     <div class="flex-row">
                        <div class="flex-col-sm-6">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" name="email" placeholder="Your Email">
                              </div>

                              @if(Session::has('errors'))
                                 <span class="error">{{Session::get('errors')->first('email')}}</span>
                              @endif

                           </div>

                         

                        </div>
                     </div>
                     <div class="flex-row">
                     <div class="flex-col-sm-6">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" name="reason" placeholder="Enter Reason" onkeypress="return removeSpace(event,$(this).val())" maxlength="250">
                              </div>
                              
                              @if(Session::has('errors'))
                                 <span class="error">{{Session::get('errors')->first('reason')}}</span>
                              @endif

                           </div>
                        </div>
                     </div>
                     <div class="flex-row">
                        <div class="flex-col-sm-6">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <textarea name="message" placeholder="Write Message here" maxlength="500"></textarea>
                              </div>

                              @if(Session::has('errors'))
                                 <span class="error">{{Session::get('errors')->first('message')}}</span>
                              @endif

                           </div>
                        </div>
                     </div>


                     <div class="btn-wrapper">
                        <ul>
                           <li>  <button type="submit" class="custom-btn green-fill getstarted btn-effect btn-sm" id="submit_button">Submit</button> </li>
                        </ul>
                     </div>
                     </form>
                  </div>
                  <!--Setting Detail Col Close-->
               </div>
            </div>
         </section>

<input type="hidden" name="search_type" value="1">

@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>

<script>
   $("#contact_us_form").validate({
      errorClass: 'error',
      errorElement: 'span',
      ignore: [],
      rules: {
         name: {
            required:true,
            minlength: 2,
            maxlength:50
         },
         email: {
            required:true,
            email: true,
            maxlength:250
         },
         reason: {
            minlength: 5,
            required:true
         },
         message: {
            required: true
         }
      },
      messages: {
        name: {
           maxlength: "Please enter name less than 50 characters.",
        },
    },
      errorPlacement: function(error, element) {
         $(element).parent('div').parent("div").addClass('error-message');
         error.insertAfter(element);
      },
      success: function(label, element) {
         label.parent().parent().removeClass('error-message');
         label.remove();
      },
      submitHandler: function(form, event) {
         //event.preventDefault()
         $("#submit_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
         form.submit();
      },
   });
</script>
@endsection

         @endsection