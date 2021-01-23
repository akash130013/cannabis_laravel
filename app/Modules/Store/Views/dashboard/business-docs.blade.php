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
         <div class="counter"><span>3</span>/3</div>
         <div class="ins-frm-lt-sd">
            <span class="hd">Business Detail</span>
            <div class="shd business-detail">Upload Proofs for Cannabis team to verify and make your account active</div>
            <form action="{{ route('store.save.proof')}}" id="save_business_proof">
               <div class="frm-sec-ins">
                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" value="{{old('licence_number')}}" minlength="9" required name="licence_number" placeholder="License Number">
                           </div>
                           <span></span>
                           @if(Session::has('errors'))
                           <span class="error alreadyTaken">{{ Session::get('errors')->first('licence_number')}}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text"  id="show_file_name" placeholder="Upload Proof" readonly>
                              <input type="file" accept=".jpg, .jpeg, .png, .pdf, .doc" name="document_proof" id="file_upload" onchange="s3_upload_directly(this.id,'error_file','hidden_file_input','show_file_name','','delete_display')"  placeholder="Upload Proof">
                              <label class="upload" for="file_upload">
                              <img src="{{asset('asset-store/images/upload.svg')}}" alt="upload">
                              </label>
                              <span id="delete_display" class="delete_file"></span>
                              <input type="hidden" name="file_input" id="hidden_file_input">
                           </div>
                           <span id="error_file"></span>
                           <span id="input_file_error"></span>
                           @if(Session::has('errors'))
                           <span class="error">{{ Session::get('errors')->first('file_input')}}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <button class="custom-btn green-fill getstarted btn-effect p-50" id="submit_button">Finish</button>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="trm-cond-sec">
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="progressBorder"></div>
         <div class="step step3"></div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/reserved-line.svg')}}" alt=""></figure>
         <p class="para mobile">Let’s upload document & active your account
         </p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script>
   $("#save_business_proof").validate({
       ignore: [],
       errorClass:'error',
       errorElement:'span',
   rules: {
               licence_number: {
                   required : true,
                   maxlength : 13,
                   minlength : 9
                 
               },
               file_input:  {
                   required : true
               }
       	
           },
          
           errorPlacement: function (error, element) {
               if (element.attr("name") == "file_input") {
                          error.insertAfter("#input_file_error");
                }else{
                    error.insertAfter(element);
                }
           },
   
   messages: {
   licence_number: {
                   required : "Please enter your license number",
                 
               },
               file_input : {
                   required : "Please upload document proof"
               }	
           },
           submitHandler: function (form, event) {
               event.preventDefault();
                $('.error').html(''); 
                form.submit();
           }
   });
   
</script>
@endsection
@endsection