<form action="{{route('store.update.delivery.address')}}" method="post" id="submit_working_hours">
    @csrf 
    <div id="businessHoursContainer3">
    </div>
    <button type="button" class="custom-btn green-fill btn-effect" id="submit_button">Save</button>
    <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
    <input type="hidden" name="workinghours" id="workinghours_store"> 
</form>
<input type="hidden" value="{{$defaultTime}}" id="default_result">  
<script src="{{asset('asset-store/js/timepicker.js')}}"></script>    
<script src="{{asset('asset-store/js/edit-store-operatinghours.js')}}"></script>
