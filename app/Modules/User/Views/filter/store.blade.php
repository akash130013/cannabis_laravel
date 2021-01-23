

@if (!empty($userNearStore['data']))
<!-- Stores names-->
<h3 class="filter-title">
   Stores
   <div class="search srch-filter show-srch-filter">
      <div class="input_filter_search">
         <input type="text" placeholder="Search" class="fltr-srch-input product-search" data-id="list-navigation-store">
         <button type="button" class="search-btn"><img class="" src="{{asset('asset-user-web/images/search-filter.svg')}}"></button>
      </div>
   </div>
</h3>
@endif

<div class="filter_option_wrapper">
   <!--filter show options-->
            <ul id="list-navigation-store">
         
      @if(!empty($userNearStore['data']) && !empty($query['store_id']))
           @foreach ($userNearStore['data'] as $key => $item)

               @if(in_array($item['store_id'],$query['store_id']))
            
                  <li>
                     <div class="input-holder acknowledge mt-23 clearfix">
                        <input type="checkbox" name="store[]" data-sid="{{$item['store_id']}}" class="all_filter_store store_id_{{$item['store_id']}}" id="store_{{$item['store_id']}}" value="{{$item['store_id'] ?? ''}}" @if(isset($query['store_id']) && (in_array($item['store_id'],$query['store_id']))) checked @endif>
                        <label for="store_{{$item['store_id']}}" class="checkbox_label">{{$item['store_name'] ?? ''}}</label>
                     </div>
                  </li>

               @endif
         
            @endforeach
      @endif


      @if(!empty($userNearStore['data']))
         <?php $i = 1; $storeCount = empty($query['store_id']) ? 0 : count(array_unique($query['store_id'])); ?>
           @foreach ($userNearStore['data'] as $key => $item)

             @if($i <= (5 - $storeCount))

                  @if(empty($query['store_id']))
                  <?php ++$i;?>
               
                     <li>
                        <div class="input-holder acknowledge mt-23 clearfix">
                        <input type="checkbox"  name="store_id[]"  class="all_filter_store store_id_{{$item['store_id']}}" id="store_{{$item['store_id']}}" value="{{$item['store_id']}}" @if(isset($query['store_id']) && in_array($item['store_id'],$query['store_id'])) data-sid="{{$item['id']}}" checked @endif>
                           <label for="store_{{$item['store_id']}}" class="checkbox_label">{{$item['store_name'] ?? ''}}</label>
                        </div>
                     </li>

                  @else
                   @if(!in_array($item['store_id'],$query['store_id']))
                     <?php ++$i;?>

                     <li>
                        <div class="input-holder acknowledge mt-23 clearfix">
                        <input type="checkbox"  name="store_id[]"  class="all_filter_store store_id_{{$item['store_id']}}" id="store_{{$item['store_id']}}" value="{{$item['store_id']}}" @if(isset($query['store_id']) && in_array($item['store_id'],$query['store_id'])) data-sid="{{$item['id']}}" checked @endif>
                           <label for="store_{{$item['store_id']}}" class="checkbox_label">{{$item['store_name'] ?? ''}}</label>
                        </div>
                     </li>

                     @endif

                  @endif

               @endif
         
            @endforeach
      @endif

            </ul>
            @if(isset($i) && !empty(count($userNearStore['data'])-$i-$storeCount+1))
            <a href="javascript:void(0)" class="show-more-filter">+{{count($userNearStore['data'])-$i-$storeCount+1}} More</a>
            @endif

   <!--Full Filter-->
   <div class="full_filter">
      <div class="full-filter-header">
         <div class="flex-row align-items-center">
            <div class="flex-col-sm-6">
               <div class="text-field-wrapper pro-srchbox">    
                  {{-- <input type="text" placeholder="Search"> --}}
                  <input type="text" id="full_filter_search_store" data-id="list_navigation_full_filter_store" placeholder="Search">

                  <span class="detect-icon"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>   
               </div>
            </div>
            <div class="flex-col-sm-6 text-right">
               <span class="close-full-filter">Close</span>
            </div>
         </div>
      </div>
      <div class="grid">
         <ul id="list_navigation_full_filter_store">
           
            @if(!empty($userNearStore['data']))
            @foreach ($userNearStore['data'] as $key => $item)
               
                   <li class="@if(isset($query['store_id']) && in_array($item['store_id'],$query['store_id'])) {{'special'}} @endif">
                         <div class="input-holder acknowledge mt-23 clearfix">
                                  <input type="checkbox"  name="store_id[]" class="all_filter_store store_id_{{$item['store_id']}}" id="store_id_{{$item['store_id']}}" value="{{$item['store_id']}}" @if(isset($query['store_id']) && in_array($item['store_id'],$query['store_id'])) data-sid="{{$item['store_id']}}" checked @endif>
                                  <label for="store_id_{{$item['store_id']}}" class="checkbox_label">{{$item['store_name'] ?? ''}}</label>
                         </div>
                   </li>
             

             @endforeach
          @endif

         </ul>
      </div>
   </div>
   <!--Full Filter view close-->
</div>