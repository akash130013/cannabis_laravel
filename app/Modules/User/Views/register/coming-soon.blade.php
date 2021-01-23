<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <link rel="icon" href="assets/images//favicon.ico" type="image/x-icon">
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/routine.css')}}" />
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400&display=swap" rel="stylesheet">
      <title>Cannabis</title>
   </head>
   <body>
      <style>
         header {
         background: #fff;
         padding: 17px 0;
         box-shadow: 0px 4px 9.8px 0.2px rgba(113, 113, 113, 0.08);
         position: fixed;
         width: 100%;
         z-index: 999;
         top: 0;
         }
         body{
         font-family: 'Open Sans', sans-serif;
         font-weight: 400;
         }
         .header_inner{
         display: flex;
         justify-content: space-between;
         align-items: center;
         width: 1280px;
         margin: 0 auto;
         padding:0 10px
         }
         .branding {
         width: 240px;
         margin: 0;
         }
         .new-logo{
             width: 60px;
         }
         .log-sign-btn.fill {
         background: #8cc83b;
         color: #fff;
         }
         .log-sign-btn {
         border-radius: 5px;
         padding: 10px 21px;
         border: 1px solid #8cc83b;
         font-weight: 600;
         font-size: 16px;
         margin: 0 0 0 15px;
         color: #8cc83b;
         }
         .dummy_page_wrapper {
         padding: 50px 0 0;
         margin: 40px 0 0;
         box-shadow: 0 0 11px rgba(0, 0, 0, 0.06);      
         }
         .primary_button {
         border-radius: 8px;
         box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.05);
         background-color:#ccc;
         color: #fff;
         padding: 12px 30px;
         }
         .custom_container {
         width: 1260px;
         margin: 0 auto;
         }
         .flex-row {
         display: flex;
         margin: 0 -10px;
         flex-flow: wrap;
         }
         .flex-col-sm-12 {
         width: 100%;
         padding-right: 10px;
         padding-left: 10px;
         }
         .flex-col-sm-6{
         width: 50%;
         padding-right: 10px;
         padding-left: 10px;
         }
         .align-items-center {
         align-items: center;
         }
         .col-left, .col-right {
         width: 100%;
         padding: 0 10px;
         }
         .mob-screen {
         text-align: right;
         }
         .fwsb {
         text-align: center;
         color: #2d2e30;
         font-weight: 600;
         margin: 18px 0;
         padding: 0;
         }
         .sub_heading {
         font-size: 32px;
         margin: 0;
         color: #0e0d47;
         padding: 0;
         text-align: center;
         }
         .form-field-group {
         margin-bottom: 30px;
         }
         input[type=email], input[type=tel], input[type=number], input[type=password], input[type=text], textarea {
         font-size: 14px;
         width: 100%;
         padding: 12px 20px;
         margin: 0;
         resize: none;
         -webkit-appearance: none;
         border-radius: 5px;
         font-weight: 400;
         color: #0a0a0a;
         border: 1px solid #c3d1df;
         }
         input[type=password]:focus,
            input[type=text]:focus, input[type=email]:focus, input[type=tel]:focus,
            textarea:focus {
                box-shadow: 0 0px 8px rgba(14, 13, 71, 0.21);
                border-left: 4px solid #0e0d47;
                border-radius: 5px
            }

         .green-fill {
         background: #0e0d47;
         color: #fff;
         border: 1px solid #0e0d47;
         box-shadow: 0 3px 7px rgba(14, 13, 71, 0.26);
         outline: none;
         padding: 15px 60px;
         cursor: pointer;
         }
         .contactus_wraper {
         padding: 40px 60px;
         width: 800px;
         margin: 0 auto;
         }
         .contactus_wraper p {
         margin: 0;
         font-size: 16px;
         line-height: 1.9;
         margin: 0 0 25px 0;
         }
         .contactus_wraper h3 {
         font-size: 24px;
         margin: 0 0 20px;
         }
         .error-messg {
         color: #f00;
         text-align: left;
         display: block;
         font-size: 12px;
         padding-left: 20px;
         }
         .insta-icon{
         margin: 12px 0;
         }
         .alert {
         padding: 15px;
         margin-bottom: 20px;
         border: 1px solid transparent;
         border-radius: 4px;
         }
         .alert-success {
         color: #3c763d;
         background-color: #dff0d8;
         border-color: #d6e9c6;
         }
         .text-right{
         text-align: right;
         }
         .green-fill:hover {
    background: #18165d;
}

         @media (max-width:1200px){
         .custom_container{
         width:90%;
         }
         .new-logo{
             width: 55px;
         }
         }
         @media(max-width:768px){
         .flex-col-xs-6{
         width: 100%;
         padding-right: 10px;
         padding-left: 10px;
         }
         .contactus_wraper{
         width: 100%;
         padding: 20px 20px;
         }
         .tree-des img {
         width: 57px;
         }
         .new-logo{
             width: 50px;
         }
         }
      </style>
      <div class="app_wrapper">
         <!--header-->
         <header>
            <div class="header_inner">
               <!-- Branding new logo-->
               <a href="#" class="branding"><img src="{{asset('asset-user-web/images/new-logo.png')}}" alt="Kingdom" class="new-logo"></a>
               <!-- Branding End -->
               <!-- Right Container -->
               <!-- Right Container End -->
            </div>
         </header>
         <!--header close-->
         <div class="custom_container">
            <div class="dummy_page_wrapper">
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-12">
                     <h2 class="fwsb">Thank you for choosing 420 Kingdom, Kern County’s Premier Delivery Service...
                     </h2>
                     <h3 class="sub_heading">COMING SOON!</h3>
                     @if(Session::has('message'))
                     {{-- 
                     <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                     --}}
                     <div class="alert alert-success">
                        <strong>Success!</strong> {{ Session::get('message') }}
                     </div>
                     @endif 
                  </div>
                  <div class="col-left">
                     <div class="contactus_wraper">
                        <p>Delivering great products <b>10am-10pm</b> 7days a week guaranteed in hour</p>
                        <h3>“The Power of the flower, delivered.”</h3>
                        <p>Be the first “in the know” on all launch details, 
                           promotions, new product info, company news & more by connecting with us now:
                        </p>
                        <form action="{{route('user.coming-soon')}}" method="POST">
                           @csrf
                           <div class="flex-row">
                              <div class="flex-col-sm-6 flex-col-xs-6">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="text"  placeholder="Full Name *" required name="full_name" maxlength="50" value="">
                                    </div>
                                    @if($errors->has('full_name'))
                                    <span class="error-messg">{{$errors->first('full_name')}}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="flex-col-sm-6 flex-col-xs-6">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="email"  placeholder="Email*" required name="email" maxlength="50" value="">
                                    </div>
                                    @if($errors->has('email'))
                                    <span class="error-messg">{{$errors->first('email')}}</span>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="flex-row">
                              <div class="flex-col-sm-6 flex-col-xs-6">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="text"  placeholder="Phone*" name="phone" required maxlength="12" value="" onkeypress="return isNumber(event)">
                                    </div>
                                    @if($errors->has('phone'))
                                    <span class="error-messg">{{$errors->first('phone')}}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="flex-col-sm-6 flex-col-xs-6">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="text"  placeholder="Favourite Products*" required name="favourite_product" maxlength="100" value="">
                                    </div>
                                    @if($errors->has('favourite_product'))
                                    <span class="error-messg">{{$errors->first('favourite_product')}}</span>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="form-field-group">
                              <div class="text-field-wrapper text-center">
                                 <button type="submit" class="custom-btn green-fill getstarted" id="signup_button">Submit</button>
                              </div>
                           </div>
                        </form>
                        <div class="flex-row">
                           <div class="flex-col-sm-6">
                              <div class="form-field-group">
                                 <span> Follow us on Instagram!</span>
                                 <figure class="insta-icon"> 
                                    <a target="_blank" href="https://instagram.com/420kingdom.official?igshid=159543vgmvcjl"><img src="{{asset('asset-user-web/images/instagram.png')}}" alt="" srcset=""></a>
                                 </figure>
                              </div>
                           </div>
                           <div class="flex-col-sm-6">
                              <div class="form-field-group text-right">
                                 <span>Mob. No.</span>
                                 <p>
                                    661-777-KING
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-right">
                     <figure class="mob-screen">
                        <img src="https://www.420kingdom.com/asset-user-web/images/cannabis-app.png">
                     </figure>
                     </div> -->
               </div>
            </div>
         </div>
      </div>
      <script src="{{asset('asset-admin/js/common.js')}}"></script>
   </body>
</html>