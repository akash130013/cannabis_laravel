@extends('Store::register.layout')
@section('content')
{{-- @include('Store::includes.header') --}}
<!-- Header End -->
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="counter"><span>2</span>/3</div>
         <div class="ins-frm-lt-sd">
            <span class="hd">Business</span>
            <div class="shd business">Let us know by what name should be visible to customers</div>
            <form action="{{route('store.save.businessname')}}" id="store_business_name">
            <div class="frm-sec-ins">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-field-group">
                        <div class="text-field-wrapper">
                           <input type="text" name="business_name"  placeholder="Business Name">
                        </div>
                        @if(Session::has('errors'))
                        <span class="error">{{ Session::get('errors')->first('business_name') }}</span>
                        @endif 
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <button class="green-fill btn-effect">Next</button>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="trm-cond-sec">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="progressBorder"></div>
         <div class="step step2"></div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/community-line.svg')}}" alt=""></figure>
         <p class="para mobile">Business name should be visible to customers
         </p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script>
   $("#store_business_name").validate({
   rules: {
               business_name: {
                   required : true,
                   maxlength : 50
               }
   },
   messages: {
   business_name: {
                   required : "Please enter your business name",
                  
               }	
   }
       });
       
   
   
</script>
@endsection
@endsection