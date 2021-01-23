@extends('Store::register.layout')
@section('content')
{{-- @include('Store::includes.header') --}}
<div class="tabularProMenu">
   <div class="form-container">
      <ol>
         <li> <span>Store Details </span></li>
         <li class="active"><span>Operating Hours</span></li>
         <li><span>Store Images</span></li>
         <li><span>Store Delivery Locations</span></li>
      </ol>
   </div>
</div>
<div class="internal-container">
   <form action="{{route('submit.store.working.hours')}}" method="post" id="submit_working_hours">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="form-container cstm-map stepForm step2 active">
         <h4>Store Operating Hours</h4>
         <div class="operat-hours">
            <div id="businessHoursContainer3">
            </div>
            <div class="frm_btn">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="btn-group">
                        <a  href="{{route('store.dashboard')}}" class="green-fill outline-btn store-bck-btn backbtn">Back</a>
                        <button class="green-fill btn-effect m-l-20" id="submit_button">Next</button>
                     </div>
                  </div>
               </div>
            </div>
            @if($errors->has('workinghours'))
            <span class="error fadeout-error">{{ $errors->first('workinghours') }}</span>
            @endif
         </div>
      </div>
      <input type="hidden" name="workinghours" id="workinghours_store">
   </form>
   <input type="hidden" value="{{$defaultTime}}" id="default_result">
</div>
@section('pagescript')
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script type="text/javascript" src="{{asset('asset-store/js/businessHours-master/jquery.businessHours.js')}}"></script>   
<script>
   var operatingHours = $("#default_result").val(); 
   
   if($.parseJSON(operatingHours).length) {
   
       var businessHours = $("#businessHoursContainer3").businessHours({
               operationTime : $.parseJSON(operatingHours),
               postInit:function(){
                   $('.operationTimeFrom, .operationTimeTill').timepicker({
                       'timeFormat': 'H:i',
                       'step': 15,
                       "ignoreReadonly": true
                       });
               },
               dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                   '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                   '<div class="weekday"></div>' +
                   '<div class="operationDayTimeContainer">' +
                   '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
                   '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
                   '</div></div>'
   });
       
   } else {
       
       var businessHours = $("#businessHoursContainer3").businessHours({
               postInit:function(){
                   $('.operationTimeFrom, .operationTimeTill').timepicker({
                       'timeFormat': 'H:i',
                       'step': 15,
                       "ignoreReadonly": true
                       });
               },
               dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                   '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                   '<div class="weekday"></div>' +
                   '<div class="operationDayTimeContainer">' +
                   '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
                   '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
                   '</div></div>'
   });
   
   }
   
   
   
   $('body').on('click','#submit_button',function(){
   
         var hours = businessHours.serialize();
         var is_atleast_one_working_hours_selected = false;
         $.each(hours,function(index,val){
               if(val.isActive) {
                   is_atleast_one_working_hours_selected = true;
               }
         });
   
         if(!is_atleast_one_working_hours_selected) {
           alert("You must select atleast one working hours");
           return false;
         }
   
       $("#workinghours_store").val(JSON.stringify(hours));
       $("#submit_working_hours").submit();       
   
   });
   
</script>
@endsection
@endsection