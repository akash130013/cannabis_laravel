<html>
<head>
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
     <link href="{{asset('asset-admin/css/bootstrap.min.css')}}" rel="stylesheet">
     {{-- <link href="{{ asset('asset-admin/css/dashboardapp.css')}}" rel="stylesheet"> --}}
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
     <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
     <link rel="stylesheet" href="{{asset('asset-admin/css/bootstrap-select.min.css')}}">
     <link rel="stylesheet" href="{{asset('asset-admin/css/admin-style.css')}}">  
     {{-- <link rel="stylesheet" href="{{asset('asset-admin/css/newstyle.css')}}">   --}}
     <link rel="stylesheet" href="{{asset('asset-admin/images/favicon.ico')}}">  
     <link rel="stylesheet" href="{{asset('asset-admin/css/loader.css')}}">
     <link rel="stylesheet" href="{{asset('asset-admin/css/icons.css')}}">
     <link rel="stylesheet" href="{{asset('asset-admin/css/sweet-alert.css')}}">
     <link rel="stylesheet" href="{{asset('asset-admin/css/selectric.css')}}">
     <link rel="stylesheet" href="{{asset('asset-admin/css/cropper.min.css')}}">
     <link rel="stylesheet" href="{{asset('asset-user-web/css/cannabis.css')}}">

     {{-- data table css --}}
     <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
     
     <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.5/css/fixedColumns.bootstrap4.min.css"/>
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
     {{-- end data table css --}}
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
     
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
     <link rel="stylesheet" href="{{asset('asset-admin/css/date-timepicker.min.css')}}">
     @yield('css')
     <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places"></script>
     
</head>
<input type="hidden"  id="csrf_toke_id" value="{{csrf_token()}}">
<body>
     
     @yield('content')
     
</body>
@include('Admin::includes.footer')

<script>
const asset_url = "{{asset('asset-admin')}}"
</script>
@yield('pagescript')

<script>
     <?php
     if (Session::has('message')) 
     {
          if ('error' === session('type')) {
               ?>
               toastr.error( "<?php echo session('message'); ?>", "", {
                    "closeButton": true
               } );
               
               <?php
          }
          else if ('success' === session('type')) 
          {
               ?>
               toastr.success( '<?php echo trim(session('message')); ?>', {
                    "closeButton": true
               } );
               <?php
          }
     }
     ?>
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
     
     var csrf_token = $("#csrf_toke_id").val();
     $(document).ready(function () {
          //your code here
          $('#datetimepicker1').datetimepicker({
               useCurrent: false,
               format: 'YYYY-MM-DD',
          });
          $('#datetimepicker2').datetimepicker({
               useCurrent: false,
               format: 'YYYY-MM-DD',
          });
          
          $(function () {
               $('select').selectpicker();
          });
          
          $('#promotionalType').change(
          function() {
               $('.error').html('');
               data =  $(this).val(),
               $('#maxCap').val(''),
               data == "fixed"? $("#checkPrmotionalType").hide():$("#checkPrmotionalType").show()
                if($(this).val() == "percentage"){
                    lab = "Percentage"
                }
                else
                {
                    lab = "Amount"
                }
                $('#amount_placeholder').html(lab);
          }
          )
          
          $('#notifyType').change(
          function() {
               data =  $(this).val();
               $('.searchNotifyType').html('');
               $('.searchNotifyType').val('');
               $('#notification_type_id').val('');
               (data == {{\App\Enums\NotificationType::Store_Detail }}|| data == {{\App\Enums\NotificationType::Product_Detail}})? $("#checkNotifyType").show():$("#checkNotifyType").hide()
          }
          )
     });  
     
     
     
     window.onload = function() {
          $('#promotionalType').val() == "fixed"? $("#checkPrmotionalType").hide():$("#checkPrmotionalType").show();
          if($('#promotionalType').val() == "percentage")
          {
             lab = "Percentage"
          }
          else
          {
               lab = "Amount"
          }
          $('#amount_placeholder').html(lab);
          ($('#notifyType').val() == {{\App\Enums\NotificationType::Store_Detail}} || $('#notifyType').val() == {{\App\Enums\NotificationType::Product_Detail}})? $("#checkNotifyType").show():$("#checkNotifyType").hide();
     }
     // this javascript is used to show delivery locations of store from store & settlement
     $('body').on('click','.btnShowPopup',function(){
          
          var title = "List of Delivery Locations";
          var body = $('#locationData').val();
          var storeId=$(this).data('id');
          $.ajax({
               url: '/admin/store/get-delivery-locations/'+storeId,
               type: "GET",
               dataType: 'json',
               beforeSend: function () {
                    $(".loader").show();
               },
               success: function (response) {
                   
                         $("#MyPopup .locationdiv>ul").html("");
                         let res = $.each(response, function (index, value) {
                              let data = '<li>'+(++index)+'. '+value.formatted_address+'</li>';
                              $("#MyPopup .locationdiv>ul").append(data);
                         })
                         $("#MyPopup .modal-title").html(title);
                         $("#MyPopup").modal("show");
                         //  } 
                    },
                    complete : function(){
                         $(".loader").hide();
                    }
               });
          });
          //  This javascript is used to show commision popup and submit as a approved store in the system
          $('body').on('click','.showCommissionPopup',function(){
               
               // $("#CommissionModal .storeId").html('');
               $("#CommissionModal .address>p").html('');
               var title = "Set Commissiion Percentage";
               var body = $('#locationData').val();
               var storeId=$(this).data('id');
               var storeDetail=$(this).data('store');
               
               $("#storeId").val(storeId);
               $("#CommissionModal .address>p").append(storeDetail);
               $("#CommissionModal .modal-title").html(title);
               $("#CommissionModal").modal("show");
          });
          
          function checkPasswordStrength() {
               var number = /([0-9])/;
               var alphabets = /([a-zA-Z])/;
               var upperCase = /([A-Z])/;
               var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
               if ($('#password_type').val().length < 8) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('weak-password');
                    $('#password-strength-status').html("Weak (should be atleast 8 characters.)");
                    $("#submit_button").prop('disabled', true);
                    $('#password-strength-status').css('color', 'red');
               } else {
                    if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
                         $('#password-strength-status').removeClass();
                         $('#password-strength-status').addClass('strong-password');
                         $('#password-strength-status').html("Strong");
                         $('#password-strength-status').css('color', 'green');
                         $("#submit_button").prop('disabled', false);
                    } else {
                         $('#password-strength-status').removeClass();
                         $('#password-strength-status').addClass('medium-password');
                         $('#password-strength-status').html("Medium (should include alphabets, uppercase, numbers and special characters.)");
                         $("#submit_button").prop('disabled', true);
                         $('#password-strength-status').css('color', 'red');
                    }
               }
          }
     </script>
     
     </html>