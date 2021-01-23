@extends("Store::layouts.master")

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{asset('asset-store/css/bootstrap.datepicker.css')}}">
@endpush

@section('content')


<div class="custom_container">
      @include('Store::layouts.pending-alert')
         <div class="white_wrapper offer">
            <figure class="bottom_img"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>

            <!--Step 1-->
            <div class="step1">
                  <div class="container_header">
                        <h2 class="title-heading">Update New Offer</h2>
                        <div class="counter"><span>1</span>/3</div>
                     </div>
                     <span class="progress_bar">
                           <span class="pro-ruller" style="width: 50%;"></span>
                        </span>
                  <div class="inner_container">
                     <div class="form-group">

                        <div class="text-field-wrapper">
                           <div class="detect-icon detect-icon-lt">
                              <select class="select_drop" id="selected_cat_id">
                                 <option value="">All Categories</option>
                                 @if($category)
                                    @foreach($category as $val)
                                       <option value="{{$val->id}}">{{$val->category_name}}</option>
                                    @endforeach
                                 @endif
                              </select>
                              <img src="{{asset('asset-store/images/droparrow-w.svg')}}" class="dropmenu" alt="drop down menu">
                           </div>
                           <input type="text" value="{{$storeProData->product->product_name}}"  id="searchproduct" class="form-control pl-230" placeholder="Search the product you wish to add">
                           <div class="cross" id="search_loader"></div>
                           
                        </div>




                        <div class="suggestions-wrapper">
                           <ul class="suggestions-list">
                             
                           </ul>
                        </div>


                     </div>
                     <div class="next-btn">
                        <button type="button" class="primary_btn green-fill nxt-btn" id="nex_button_select_qty">Next</button>
                     </div>
                  </div>
            </div>
            <!--Step 1 close-->

            <!--Step 2-->
            <div class="step2" id="step_two_div_section">
              
             </div>
            <!--Step 2 close-->    

            <!-- Step 3-->
            <div class="step3">
                     <div class="">
                     <figure class="bottom_img"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
                     <div class="container_header">
                        <h2 class="title-heading">Update New Offer</h2>
                        <div class="counter"><span>3</span>/3</div>
                     </div>
                     <span class="progress_bar">
                           <span class="pro-ruller" style="width: 100%;"></span>
                        </span>
                     <div class="inner_container">
                        <div class="offer-date">
                           <label class="offer-label">Enter Offer Start & End Date</label>
                           <div class="form-field-group">
                              <div class="input-group date" >
                                 <input type="text" class="form-control" value="{{date('d.m.Y',strtotime($storeProData->offer_start))}}" id="datetimepicker1" placeholder="Start Date">
                                 <label class="input-group-addon" for="datetimepicker1">
                                    <i class="fa fa-calendar"></i>
                                 </label>
                              </div>
                           </div>

                           <div class="form-field-group">
                              <div class="input-group date" >
                                 <input type="text" class="form-control" value="{{date('d.m.Y',strtotime($storeProData->offer_end))}}" id="datetimepicker2" placeholder="End Date">
                                 <label class="input-group-addon" for="datetimepicker2">
                                    <i class="fa fa-calendar"></i>
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="next-btn">
                           <button class="primary_btn green-fill outline-btn back3">Back</button>
                           <button class="primary_btn green-fill" id="step_three_add_date">Finish</button>
                        </div>
                     </div>
                  </div>
            </div>

            <!-- Step 3 Close-->


            <input type="hidden" value="{{$stockID}}" id="searchproduct_id">
            <input type="hidden" value="{{$storeProData->product_id}}" id="product_id">


         </div>


         
</div>



@push('script')

   <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
   <script src="{{asset('asset-admin/js/jquery.validate.min.js')}}"></script>
   <script src="{{asset('asset-admin/js/validation.js')}}"></script>
   <script src="{{asset('asset-store/js/commonFunction-store.js')}}"></script>
   <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script> 
   <link rel="stylesheet" href="{{asset('asset-store/css/jquery.ui.css')}}"> 
   <script src="{{asset('asset-store/js/datepicker.bootstrap.js')}}"></script>
   <script src="{{asset('asset-store/js/edit-offer.js')}}"></script>
   
@endpush


@endsection


