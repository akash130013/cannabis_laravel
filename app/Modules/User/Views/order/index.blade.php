@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


@section('content')

@yield('nav-bar')

    
    <form action="{{route('user.order.listing')}}" method="get" id="filterFormId">
    <section class="inner_centerpanel">
        <div class="custom_container">
           <div class="flex-row align-items-center">
             
              <div class="flex-col-sm-6 flex-col-xs-6">
                 <h2 class="title-heading m-t-b-30">Orders</h2>
              </div>
           
              <div class="flex-col-sm-6 flex-col-xs-6 text-right mob_filter_select">

                 {{-- <div class="select filters">
                    <span>Filter</span>
                    <span class="filter-icon"></span>
                 </div> --}}
           
                 <div class="select">

                    Sort By: <span>
                        @if(!empty($query) && (isset(config('constants.ORDER_FILTER')[$query['type']]))) {{config('constants.ORDER_FILTER')[$query['type']]}} @endif
                     </span>
                    <span class="sort-downArrow"></span>
                       
                  <ul>

                      <li class="all_filter" data-num="1">
                               <label class="dropdown" for="all">All</label>
                               <input type="radio" class="check_1" name="type" id="all" value="" @if(!isset($query['type']) || $query['type']=='')) checked @endif>
                      </li>   

                      <li class="all_filter" data-num="2">
                             <label class="dropdown" for="pending">Pending</label>
                             <input type="radio" class="check_2" name="type" id="pending" value="pending" @if(isset($query['type']) && $query['type']=='pending')) checked @endif>
                      </li>

                      <li class="all_filter" data-num="3">
                             <label class="dropdown" for="processing">Processing</label>
                             <input type="radio" class="check_3"  name="type" id="processing" value="ongoing" @if(isset($query['type']) && $query['type']=='ongoing')) checked @endif>
                      </li>

                      <li class="all_filter" data-num="4">
                             <label class="dropdown" for="delivered">Delivered</label>
                             <input type="radio" class="check_4" name="type" id="delivered" value="completed" @if(isset($query['type']) && $query['type']=='completed')) checked @endif>
                      </li>
                

                    </ul>
                  
                 </div>
           
              </div>
           </div>
           
         

           <div class="flex-row card-row" id="scroller">
         
            @if(!empty($orderList['response']['data']['data']))
                @foreach ($orderList['response']['data']['data'] as $index => $item)
                
                @php
                $status = trans('userweborder.'.$item['order_status']);
                @endphp
                
            
              <div class="flex-col-sm-6 item">
                 <div class="order-card">
                    <div class="text-right">
                    
                  {{-- updated fnc --}}
                  @if(isset($item['cancel_by']))
                    <button type="button" class="btn_sm status-btn {{ $status }}">Rejected</button> 
                     @else
                     <button type="button" class="btn_sm status-btn {{ $status }}">{{ ucfirst($status) }} </button>  
                   @endif

                   
                     </div>
                    <div class="flex-row ordered-card-detail">
                       <div class="flex-col-sm-4">
                       <a href="{{route('users.store.detail',encrypt($item['store_id']))}}" target="_blank">                         
                         <figure class="ordered-img">
                             <img src="{{$item['store_images'][0] ?? ''}}" alt="ordered-item-image" onerror="imgStoreError(this);"/>
                          </figure>
                        </a>

                       </div>
                       <div class="flex-col-sm-8">
                          <div class="ordered-item-detail">
                          <label>{{$item['store_name'] ?? 'N/A'}}</label>
                          <p>{{$item['store_address'] ?? 'N/A'}}</p>
                          <p class="ordered-id">ORDER # {{$item['order_uid'] ?? 'N/A'}} | {{ \App\Helpers\CommonHelper ::convertFormat($item['order_created_date'], 'M d, Y')}}</p>
                             <div class="more-details">
                                <a href="javascript:void(0)" id="{{$item['order_uid']}}" onclick="showDetail($(this).attr('id'))">View Details</a>
                                @include('User::order.track-model')
                             <label>Total Paid <span>$ {{number_format($item['net_amount'] ?? 0,2)}}</span></label>
                             </div>
                          </div>
                       </div>
                    </div>
                    <hr>
                 
                    <div class="ordered-status">
                        @if(isset($item['cartSummary']) && !empty($item['cartSummary']))
                       <label>
                          
                           @foreach ($item['cartSummary'] as $row)
                               {{$row['product_name'] ?? 'N/A'}}  ({{$row['size']}}{{$row['size_unit']}}) x {{$row['quantity']}}
                               
                           @endforeach
                       </label>
                       @endif
                
                   @if($status=='pending')
                     <button type="button" id="{{'cancel-order'.$index}}"  value="{{$item['order_uid']}}"  class="custom-btn green-fill btn-effect btn-sm cancel-order">Order Cancel</button>
                     <a href="{{route('user.show.faq.page')}}"><button type="button" class="custom-btn green-fill outline-btn btn-effect btn-sm">Help</button></a>
               
                   @elseif($status=='processing') 

                            @if($item['order_status']=='on_delivery')     
                                <button type="button" class="custom-btn green-fill btn-effect btn-sm track-my-order" data-order_uid="{{$item['order_uid']}}">Track Order</button>
                            @elseif($item['order_status']!='on_delivery')
                                <button type="button" id="{{'cancel-order'.$index}}"  value="{{$item['order_uid']}}"  class="custom-btn green-fill btn-effect btn-sm cancel-order">Order Cancel</button>
                            @else
                             <a href="{{route('user.show.faq.page')}}"><button type="button" class="custom-btn green-fill outline-btn btn-effect btn-sm">Help</button></a>
                          @endif

                   @elseif($status=='delivered') 
                          <button type="button" id="{{'re-order'.$index}}"  value="{{$item['order_uid']}}" class="custom-btn green-fill btn-effect btn-sm re-order">Re-Order</button>

                          @if($item['is_rated']==false)
                              <button type="button" class="custom-btn green-fill outline-btn btn-effect btn-sm rateUsClass" data-id={{$loop->iteration}} data-item="{{json_encode($item)}}" >Rate Us</button>
                          @endif

                   @else
                              <button type="button" id="{{'re-order'.$index}}"  value="{{$item['order_uid']}}" class="custom-btn green-fill btn-effect btn-sm re-order">Re-Order</button>
                               {{-- <button type="button" class="custom-btn green-fill outline-btn btn-effect btn-sm">Help</button> --}}
                               <a href="{{route('user.show.faq.page')}}"><button type="button" class="custom-btn green-fill outline-btn btn-effect btn-sm">Help</button></a>
                   @endif  

                    </div>
                 </div>
              </div>
              @endforeach
              @else

              <div class="custom_container">

                  <figure class="nopro_found text-center">
                     <img src="{{asset('asset-user-web/images/noorder.jpg')}}">
                  </figure>
   
               </div>
              @endif
              @if(!empty($orderList['response']['data']['data']))
              <div class="scroller-status">
                   <div class="infinite-scroll-request loader-ellips">
                   </div>
                   <p class="infinite-scroll-last"></p>
                   <p class="infinite-scroll-error"></p>
             </div>
             @endif
             

        </div>
        
          <!--pagination -->
          <div class="pagination">
      <a href="@if(!empty($orderList['response']['data']['nextPage'])){{route('user.order.listing').'?page='.$orderList['response']['data']['nextPage'].'&&type='.$query['type']}} @else javascript:void(0) @endif" class="next">Next</a>
            </div>
     </section>
   </form>
     <!--section list filter close-->



     @include('User::order.review-rating-model')
     @include('User::order.track-order')
   
    
     <input type="hidden" id="review_rating_url" value="{{route('user.rating.submit')}}">
     <input type="hidden" id="order_url" value="{{route('user.order.listing')}}">
     <input type="hidden" id="track_order_url" value="{{route('user.order.track')}}">



     <input type="hidden" name="search_type" value="2">
      <input type="hidden" id="cart-listing-url" value="{{route('user.show.cart.list')}}"
     @endsection

@section('pagescript')
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{asset('asset-user/js/review-rating.js')}}"></script>         
@endsection