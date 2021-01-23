@extends('User::dashboard.layout')
@include('User::includes.header')
@section('css')
<style>
.file_upload {
        position: absolute;
        top: 0;
        opacity: 0;
        height:61%;
        z-index:9;
    }
    .delete_file svg {
        width: 20px;
        height: 20px;
    }
    .delete_file {
        position: absolute;
        right: -30px;
        top: 13px;
    }

    .flex-col-sm-4 {
    width: 33.3%;
    padding: 0 10px;
}

.upload {
    width: 25px;
}



.modal.confirmation h2 {
        font-size: 40px;
        color: #2d2e30;
        font-weight: 600;
        line-height: 1.5;
        text-align: center;
        margin-bottom: 35px;
    }
    
    .modal.confirmation p {
        font-size: 16px;
        color: #2d2e30;
        font-weight: 500;
        line-height: 1.5;
        text-align: center;
        margin-bottom: 35px;
    }
    
    .btn-confirmation {
        margin: auto;
        text-align: center;
        display: block;
    }
    
    .modal.confirmation .modal-dialog {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-120%, -50%);
    }
    
    .modal.confirmation .modal-content {
        padding: 70px 0;
    }

    .pac-container {
        z-index: 100000;
    }
</style>
@endsection

@section('content') 
@php
      $day='';
      $month='';
      $year='';
       if(!empty($data) && $data->is_proof_completed==1){
            $time=strtotime($data->dob);
            $month=date("m",$time);
            $day=date("d",$time);
            $year=date("Y",$time);
       }
   @endphp


<!--Onboarding flow--->
         <div class="form-container">
            <div class="formBgWrapper formBgWrapperright">
               <div class="custom_container flex-row align-items-center">
                
                
                    <div class="frm-rt-sd">
                            <div class="ins-frm-lt-sd">
                                <span class="hd">Age Verification</span>
                                <div class="shd age">
                                    Upload your identification for the store to be just extra sure.
                                </div>
                               
                                @php
                                   $ageProofName='';  
                                  $medicalProofName=''; 
                                    if(isset($useAgeProof->file_url) && !empty($useAgeProof->file_url)){
                                       $ageProofName =(explode('/',$useAgeProof->file_url))[3];
    
                                    }
                                    if(isset($useMedicalProof->file_url) && !empty($useMedicalProof->file_url)){
                                       $medicalProofName =(explode('/',$useMedicalProof->file_url))[3];
                                    }
                                @endphp
                               
                            <form action="{{route('users.save.proof')}}" method="get" id="proof_form_id">
                            <input type="hidden" name="date_of_birth" id="dob">
                                <div class="frm-sec-ins">
                                          
                                
                                
                                    
                                <div class="form-field-group">


                                        <div class="flex-row">
                                                <div class="flex_col_sm_12">
                                                <div class="flex-row">
                                            <div class="flex-col-sm-4">
                                                 
                                                            <div class="text-field-wrapper">
                                                                <div class="selectWrapper">
                                                                        <select name="day" id="dobday">
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                    
                                            </div>

                                            <div class="flex-col-sm-4">
                                                    <div class="">
                                                            <div class="text-field-wrapper">
                                                                <div class="selectWrapper">
                                                                        <select name="month" id="dobmonth">

                                                                        </select>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>


                                            <div class="flex-col-sm-4">
                                                    <div class="">
                                                            <div class="text-field-wrapper">
                                                                <div class="selectWrapper">
                                                                        <select name="year" id="dobyear">  
                                                                            
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                    </div>
                                                </div>

                                             
                                                </div>

                                                <span id="dob-error">@if(Session::has('errors')){{ Session::get('errors')->first('date_of_birth') }}@endif </span>
                                                 </div>
                                        </div> 

                                       
                                            </div>
                                    
                                            @if($data->is_proof_completed==1)
                                            <input type="hidden" id="day" value="{{$day}}">
                                            <input type="hidden" id="month" value="{{$month}}">
                                            <input type="hidden" id="year" value="{{$year}}">
                                            @endif
    
                                    <div class="row">
                                        <div class="col-sm-12">
                                                <div class="form-field-group">
                                                        <div class="text-field-wrapper">
                                                            <input type="text" id="age_file_name" class="upload_input" placeholder="Upload Age Proof" readonly value="{{$useAgeProof->file_name ?? ''}}">
                                                            <input type="file" name="age_document_proof" value="{{$useAgeProof->file_name ?? ''}}" id="age_file_upload" onchange="s3_upload_directly(this.id,'hidden_age_file_input-error-custom','hidden_age_file_input','age_file_name','','delete_display_age')" class="file_upload" placeholder="Upload Proof">
                                                        
                                                            <label for="age_file_upload" class="detect-icon uplod_file">
                                                            <img src="{{asset('asset-store/images/upload.svg')}}" alt="" class="upload">
                                                            </label>
                                                        
                                                            <input type="hidden" class="validate" name="file_input_age" id="hidden_age_file_input" value="{{$useAgeProof->file_url ?? ''}}">
                                                            <input type="hidden" name="hidden_age_file_name" id="hidden_age_file_name" value="{{$useAgeProof->file_name ?? ''}}">
                                                           
                                                            <span id="delete_display_age" class="delete_file" title="Delete">
                                                                @if (!empty($ageProofName))
                                                        <a href="javascript:void(0)"><svg id="removeImage" data-pk="{{encrypt($useAgeProof->id)}}" data-file-name="hidden_age_file_name" data-delete="1" data-remove-url="hidden_age_file_input" data-display="age_file_name" data-file="age_file_upload" data-remove-id="delete_display_age" data-key="{{$ageProofName}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path fill="none" d="M0 0h24v24H0z"></path><path fill="#ff0000" d="M4 8h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8zm2 2v10h12V10H6zm3 2h2v6H9v-6zm4 0h2v6h-2v-6zM7 5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h5v2H2V5h5zm2-1v1h6V4H9z"></path></g></svg></a>
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <span class="upload-doc" id="hidden_age_file_input-error-custom"></span>
                                                </div>
                                        </div>
                                    </div>
                                
                                <input type="hidden" id="type" value="verification_image">
    
                                    <div class="row">
                                        <div class="col-sm-12">
                                                <div class="form-field-group">
                                                        <div class="text-field-wrapper">
                                                        <input type="text" id="medical_file_name" class="upload_input" placeholder="Upload Medical Proof (Optional)" readonly value="{{$useMedicalProof->file_name ?? ''}}">
                                                        <input type="file" name="medical_document_proof"   id="file_upload_medical" onchange="s3_upload_directly(this.id,'hidden_file_input_medical-error','hidden_file_input_medical','medical_file_name','','delete_display_medical')" class="file_upload" placeholder="Upload Proof">
                                                        <label for="file_upload_medical" class="detect-icon uplod_file">
                                                        <img src="{{asset('asset-store/images/upload.svg')}}" alt="" class="upload">
                                                        </label>
                                                        <input type="hidden" name="file_input_medical" id="hidden_file_input_medical" value="{{$useMedicalProof->file_url ?? ''}}">
                                                        <input type="hidden" name="hidden_medical_file_name" id="hidden_medical_file_name" value="{{$useMedicalProof->file_name ?? ''}}">
                                                        
                                                        <span id="delete_display_medical" class="delete_file" title="Delete">
                                                               @if (!empty($medicalProofName))
                                                               <a href="javascript:void(0)"><svg id="removeImage" data-file-name="hidden_medical_file_name" data-pk="{{encrypt($useMedicalProof->id)}}" data-delete="1" data-display="medical_file_name" data-remove-url="hidden_file_input_medical" data-file="file_upload_medical" data-remove-id="delete_display_medical" data-key="{{$medicalProofName}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path fill="none" d="M0 0h24v24H0z"></path><path fill="#ff0000" d="M4 8h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8zm2 2v10h12V10H6zm3 2h2v6H9v-6zm4 0h2v6h-2v-6zM7 5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h5v2H2V5h5zm2-1v1h6V4H9z"></path></g></svg></a>
                                                               @endif
                                                        </span>
                                                        </div>
                                                        <span class="upload-doc" id="hidden_file_input_medical-error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12 mt-50 mobile-space">
                                            <button type="submit" class="custom-btn green-fill getstarted btn-effect" id="submit_button">Submit</button>
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
                               <h2>A bit additional process to for stores to validate you when you place order</h2>
                            </div>
                         </div>
                        

        <div class="modal fade confirmation" id="minAgeModel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h2>OOPS !!</h2>
                        <p>Seems like you don't meet the minimum age qualification to view this site.</p>
                        <div class="row">
                            <div class="col-sm-12 mt-50 mobile-space">
                                <a href="javascript:void(0)" class="btn custom-btn green-fill getstarted btn-confirmation" data-dismiss="modal">Re-Enter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

               </div>
            </div>
         </div>
       @endsection
       @section('pagescript')
    <script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
    <script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>
    <script src="{{asset('asset-user/js/moment.js')}}"></script>

    <script src="{{asset('asset-user/js/Minimalist-jQuery-Plugin-For-Birthday-Selector-DOB-Picker/dobpicker.js')}}"></script>
   

    <script>
   
       @if($data->is_proof_completed==1)
       $(window).on('load', function() {
         var day=$("#day").val();
         var month=$("#month").val();
          var year=$("#year").val();
          $("#dobday").val(day);
          $("#dobmonth").val(month);
          $("#dobyear").val(year);
        //   $('.selectpicker').selectpicker('refresh');
       });
       @endif
        </script>
        <script src="{{ asset('asset-user/js/user-age-verify.js')}}"></script>
    @endsection