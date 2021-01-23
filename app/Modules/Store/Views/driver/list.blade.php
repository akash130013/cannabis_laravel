@extends("Store::layouts.master")
@section('content')
<form action="{{route('store.driver.list')}}" method="GET" id="list-form">
   <div class="custom_container">
   <div class="tab_wrapper_seprate">
      <!-- menu-->
      <div class="head-nav tab_wrapper">
         <ul>
            <li><a href="{{route('store.driver.list',['status'=>'all'])}}" class="active">Listing</a></li>
            <li><a href="{{route('store.driver.view')}}">Bird’s Eye View</a></li>
         </ul>
      </div>
      <!-- menu close-->
   </div>
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="flex-row flex-flow-mob align-items-center">
         <div class="flex-col-sm-3 flex-col-xs-3">
            <h2 class="title-heading">Driver</h2>
         </div>
         <div class="flex-col-sm-9 flex-col-xs-9 text-right">
            <div class="text-field-wrapper product-srch-col-header ui category search">
               <div class="text-field-wrapper pro-srchbox ui icon input">
                  <input class="prompt" type="text" placeholder="Search by Driver Name" id="searchElementProduct" name="keyword" value="{{request()->query('keyword')}}">
                  <i class="search icon"></i>  
                  @if(Request::has('keyword') && !empty(Request::get('keyword')) )
                  <a href="{{route('store.driver.list',['status'=>'all'])}}"><img  src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu" alt="cross"></a>
                  @endif
               </div>
               <div class="results"></div>
               <a class="m-l-20 btn-effect green-fill btn_sm m-l-20" href="{{route('store.driver.create')}}" >Add Driver</a>
            </div>
         </div>
      </div>
   </div>
   <div class="">
   <!-- <div class="wrap-row align-items-center">
      <div class="product-srch-col-header">
         
      
          <div class="product-srch-col-header ui search">
              <div class="text-field-wrapper  pro-srchbox ui left icon input">
               
          
              
          </div>
      
              
          </div>
              
          </div>
      
      </div>
      </div>
      </div> -->
   <div class="custom_container">
      <div class="m-bt-20">
         <div class="flex-row align-items-center">
            <div class="flex-col-sm-6 flex-col-xs-6">
               {{-- <span class="display">Display <b>1</b> of 10</span> --}}
            </div>
            <div class="flex-col-sm-6 flex-col-xs-6 text-right">
               {{-- 
               <div>
                  Sort By: 
                  <select id="status" class="select status">
                     <option value="" selected>All</option>
                     <option value="online" @if($status == 'online') selected @endif>Online</option>
                     <option value="busy" @if($status == 'busy') selected @endif>Busy</option>
                     <option value="offline" @if($status == 'offline') selected @endif>Offline</option>
                  </select>
               </div>
               --}}
               
               <div class="select">
                  Sort By:@if(!empty($status) && (isset($status))) {{config('constants.DRIVER_SORTING_FILTER')[$status]}} @endif
                  <span class="sort-downArrow"></span>
                  <ul>
                     <li class="all_filter">
                        <label class="dropdown" for="selectAll">Select All</label> 
                        <input type="radio"  class="status" id="selectAll" value="all" @if(isset($status) && $status=='all')) checked @endif checked>
                     </li>
                     <li class="all_filter">
                        <label class="dropdown" for="online">Online</label> 
                        <input type="radio"  class="status" id="online" value="Online" @if(isset($status) && $status=='Online')) checked @endif>
                     </li>
                     <li class="all_filter">
                        <label class="dropdown" for="busy">Busy</label> 
                        <input type="radio"  class="status"  id="busy" value="Busy" @if(isset($status) && $status=='Busy')) checked @endif>
                     </li>
                     <li class="all_filter">
                        <label class="dropdown" for="offlie">Offline</label> 
                        <input type="radio"  class="status"  id="offlie" value="offline" @if(isset($status) && $status=='offline')) checked @endif>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="white_wrapper">
         <div class="table-responsive" id="driver-list">
            <table class="list-table table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Driver Status</th>
                        <th>Driver Name</th>
                        <th>Vehicle Details</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @forelse ($list as  $key => $item)
                     
                    <tr>
                        <td>{{$srNo++}}</td>
                        <td>
                            <span class="driver-status @if($item->distributor->current_status == 'online') online 
                                    @elseif($item->distributor->current_status == 'busy')busy
                                    @else offline @endif">{{ucFirst($item->distributor->current_status)}}</span>
                        </td>
                        <td><span class="td-text-wrap">{{$item->distributor->name}}</span></td>
                        <td><span class="td-text-wrap">{{$item->distributor->vehicle_number ? $item->distributor->vehicle_number : 'N/A'}}</span></td>
                        <td><span class="rating_star">{{!empty($item->distributor->driverReview)?\App\Helpers\CommonHelper::getAvgRating($item->distributor->driverReview):0}}({{$item->distributor->driver_review_count??0}} @if($item->distributor->driver_review_count<=1) Review @else Reviews @endif)</span></td>
                        <td><span class="active">
                            @if($item->distributor->status == config('constants.STATUS.BLOCKED'))
                                Inactive
                            @else
                                {{ucFirst(str_replace('_',' ',$item->distributor->status))}}
                            @endif
                            </span>
                        </td>
                        <td class="user_info">
                            <span class="info_icon">
                                <img src="{{asset('asset-store/images/info.svg')}}">
                            </span>
                            <!-- <div class="user_info_window">
                                <div class="inner_wrap">
                                    <div class="flex-row mob-row-reverse m-b-20 align-items-center">
                                        <div class="flex-col-sm-6 text-left">
                                            <span class="driver-status @if($item->distributor->current_status == 'online') online 
                                                    @elseif($item->distributor->current_status == 'busy')busy
                                                    @else offline @endif">{{ucFirst($item->distributor->current_status)}} 
                                                    @if($item->distributor->current_status == 'offline')
                                                        | Last Login Time: 
                                                        @if(config('constants.NULL_DATE_TIME') != $item->distributor->last_login_time)
                                                            {{\App\Helpers\CommonHelper::convertFormat($item->distributor->last_login_time,'M d, Y h:i a')}}
                                                        @else
                                                        N/A
                                                        @endif
                                                    @endif

                                                </span>
                                            <div class="user-details">
                                                <figure class="driver_img_sm">
                                                    <img src="{{$item->distributor->profile_image}}" alt="driver-img" onerror="imgUserError(this);">
                                                </figure>
                                                <div class="details">
                                                    <span class="user_name">{{$item->distributor->name}}</span>
                                                    <span class="user_email">{{$item->distributor->email}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-col-sm-6">
                                            <div class="button_wrapper text-right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="flex-col-sm-6">
                                    <div class="button_wrapper text-right">
                                     
                                    </div>
                                 </div>
                              </div>
                              
                           </div> -->
                       
                           <div class="user_info_window">
                              <div class="inner_wrap">
                                 <div class="flex-row m-b-20 align-items-center">
                                    <div class="flex-col-sm-6 text-left">
                                       <span class="driver-status @if($item->distributor->current_status == 'online') online 
                                                    @elseif($item->distributor->current_status == 'busy')busy
                                                    @else offline @endif">{{ucFirst($item->distributor->current_status)}} 
                                                    @if($item->distributor->current_status == 'offline')
                                                        | Last Login Time: 
                                                        @if(config('constants.NULL_DATE_TIME') != $item->distributor->last_login_time)
                                                            {{\App\Helpers\CommonHelper::convertFormat($item->distributor->last_login_time,'M d, Y h:i a')}}
                                                        @else
                                                        N/A
                                                        @endif
                                                    @endif

                                                </span>
                                       <div class="user-details">
                                          <figure class="driver_img_sm">
                                              <img src="{{$item->distributor->profile_image}}" alt="driver-img" onerror="imgUserError(this);">
                                          </figure>
                                          <div class="details">
                                             <span class="user_name">{{$item->distributor->name}}</span>
                                                    <span class="user_email">{{$item->distributor->email}}</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="flex-col-sm-6">
                                       <div class="button_wrapper text-right">
                                      
                                            <ul>
                                          <li>
                                             <a href="{{route('store.driver.show',$item->distributor->id)}}" class=" green-fill outline-btn btn_sm">View Details</a>
                                          </li>
                                          <li>
                                             @if($item->distributor->status == config('constants.STATUS.ACTIVE') )
                                             <button type="button" data-request="ajax" data-status="{{config('constants.STATUS.BLOCKED') }}" data-message="Are you sure you want to deactivate this driver ?" data-url="{{route('store.driver.destroy',$item->distributor->id)}}" class="primary_btn green-fill btn-effect btn_sm">Deactivate</button>
                                             @else
                                             <button type="button" data-request="ajax" data-status="{{config('constants.STATUS.ACTIVE') }}" data-message="Are you sure you want to activate this driver ?" data-url="{{route('store.driver.destroy',$item->distributor->id)}}"  class="primary_btn green-fill btn-effect btn_sm">Activate</button>
                                             @endif
                                          </li>
                                       </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="flex-row">
                                    <div class="flex-col-sm-4">
                                       <div class="form_field_wrapper">
                                          <label class="form-label">Phone</label>
                                       <span class="show-label">{{$item->distributor->phone_number}}</span>
                                       </div>
                                    </div>
                                    <div class="flex-col-sm-4">
                                       <div class="form_field_wrapper">
                                         
                                            <label class="form-label">License Number</label>
                                            <span class="show-label">{{$item->distributor->dl_number ? $item->distributor->dl_number : 'N/A'}}</span>
                                       </div>
                                    </div>
                                    <div class="flex-col-sm-4">
                                       <div class="form_field_wrapper">
                                     
                                           <label class="form-label">Current Location </label>
                                       <span class="show-label">{{$item->distributor->format_location}}</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="7" class="text-center">No Records found</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
      <!--Pagenation-->
      <div class="flex-row">
         <div class="flex-col-sm-12 text-center">
            {{$list->links()}}
         </div>
      </div>
      <!--Pagenation Close-->
   </div>
</form>
<input type="hidden" name="searchUrl" value="{{route('store.driver.search')}}">
@endsection
@push('script')
<script src="{{asset('asset-store/js/bootstrap-select.js')}}"></script>
<script src="{{asset('asset-store/js/driver-list.js')}}"></script>
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
<script src="{{asset('asset-store/js/search-list.js')}}"></script>
<script>
   $('.status').on('click',function()
   {
      var status = $(this).val();
        window.location.href = '/store/driver/list?status='+status;
   })
   
   // window.onload = function()
   // {
       
       
   // }
</script>
@endpush