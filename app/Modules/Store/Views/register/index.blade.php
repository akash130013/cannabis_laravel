@extends('Store::register.layout')
@section('content')
<header>
   <div class="header_inner">
      <!-- Branding -->
      <a href="" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt=""></a>
      <!-- Branding End -->
      <!-- Right Container -->
      <!-- Right Container End -->
   </div>
   <!-- Tabs menu -->
   <div class="tabularProMenu">
      <div class="form-container">
         <ol>
            <li class="active"><span>Store Details</span></li>
            <li><span>Operating Hours</span></li>
            <li><span>Store Images</span></li>
            <li><span>Store Delivery Locations</span></li>
         </ol>
      </div>
   </div>
   <!-- Tabs menu End -->
</header>
<!-- Header End -->
<!-- Internal Container -->
<div class="internal-container">
   <figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
   <!-- Form Container -->
   <div class="form-container cstm-map stepForm step1 active">
      <h4>Store Details</h4>
      <div class="operat-hours">
         <div class="frm-lt-sd">
            <div class="ins-profilefrm-lt-sd">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="Enter Store Name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="Enter Store Contact Number">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="Enter Location as per google Maps">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <textarea placeholder="About Your Store"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="frm-rt-sd">
            <img src="{{asset('asset-store/images/map.jpg')}}" alt="">
         </div>
         <div class="frm_btn w-100">
            <div class="row">
               <div class="col-sm-12">
                  <div class="btn-group">
                     <button class="btn custom-btn green-fill getstarted nextBtn" data-datac="1">Next</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="form-container cstm-map stepForm step2">
      <h4>Store Operating Hours</h4>
      <div class="operat-hours">
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Sunday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Open</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker active" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker active" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Monday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Tuesday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Wednesday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Thursday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Friday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group w-100">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <label>Saturday</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <div class="switchToggle">
                        <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label>
                        <p id="toggleLabel">Closed</p>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" name="timepicker" class="timepicker" />
                  </div>
               </div>
            </div>
         </div>
         <div class="frm_btn">
            <div class="row">
               <div class="col-sm-12">
                  <div class="btn-group">
                     <button class="btn custom-btn trans-fill getstarted">Back</button>
                     <button class="btn custom-btn green-fill getstarted nextBtn" data-datac="2">Next</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="form-container cstm-map stepForm step3">
      <h4>Upload Store Images</h4>
      <div class="operat-hours">
         <div class="storeImages w-100">
            <input type="file"/>
            <img src="{{asset('asset-store/images/upload-store.svg')}}" alt="Upload Store Image">
            <p>Click to upload your store images</p>
         </div>
         <div class="uploadImages w-100">
            <div class="image">
               <img src="{{asset('asset-store/images/store1.jpg')}}" alt="store Image">
               <img src="{{asset('asset-store/images/close.svg')}}" alt="close" class="close">
            </div>
         </div>
         <div class="frm_btn">
            <div class="row">
               <div class="col-sm-12">
                  <div class="btn-group">
                     <button class="btn custom-btn trans-fill getstarted">Back</button>
                     <button class="btn custom-btn green-fill getstarted nextBtn" data-datac="3">Next</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="form-container cstm-map stepForm step4">
      <h4>Store Operating Hours</h4>
      <!-- <div class="frm-lt-sd">
         <div class="ins-profilefrm-lt-sd">
             <div class="frm-sec-ins">
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="form-group">
                             <input type="text" class="form-control" placeholder="Enter Store Name">
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="form-group">
                             <input type="text" class="form-control" placeholder="Enter Store Contact Number">
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="form-group">
                             <input type="text" class="form-control" placeholder="Enter Location as per google Maps">
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="form-group">
         
                             <textarea placeholder="About Your Store"></textarea>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         </div>
         <div class="frm-rt-sd">
         <img src="assets/images/map.jpg" alt="">
         </div> -->
      <div class="frm_btn">
         <div class="row">
            <div class="col-sm-12">
               <button class="btn custom-btn green-fill getstarted">Back</button>
               <button class="btn custom-btn green-fill getstarted nextBtn" data-datac="4">Submit</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Form Container End -->
</div>
@endsection