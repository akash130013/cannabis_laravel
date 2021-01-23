
@if (!empty($categories['data']))
<h3 class="filter-title">
    Product Category
    <div class="search srch-filter show-srch-filter">
       <div class="input_filter_search">
          <input type="text"  placeholder="Search" class="fltr-srch-input product-search" data-id="list_navigation">
          <button type="button" class="search-btn"><img class="" src="{{asset('asset-user-web/images/search-filter.svg')}}"></button>
       </div>
    </div>
 </h3>

 <!--Filter options main wrapper-->   
 <div class="filter_option_wrapper">
    <!--filter show options-->
    <ul class="list" id="list_navigation">


    <!-- seleted list  -->


    @if(!empty($categories['data']) && !empty($query['category_id']))
            @foreach ($categories['data'] as $key => $item)

                @if(in_array($item['id'],$query['category_id']))
             
                   <li>
                      <div class="input-holder acknowledge mt-23 clearfix">
                      <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                         <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                      </div>
                   </li>

                @endif
          
             @endforeach
       @endif



   

       @if(!empty($categories['data']))
          <?php $i = 1; $categoryCount = empty($query['category_id']) ? 0 : count(array_unique($query['category_id'])); ?>
            @foreach ($categories['data'] as $key => $item)

              @if($i <= (5 - $categoryCount))

                   @if(empty($query['category_id']))
                   <?php ++$i;?>
                
                      <li>
                         <div class="input-holder acknowledge mt-23 clearfix">
                         <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                            <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                         </div>
                      </li>

                   @else
                    @if(!in_array($item['id'],$query['category_id']))
                      <?php ++$i;?>

                      <li>
                         <div class="input-holder acknowledge mt-23 clearfix">
                         <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                            <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                         </div>
                      </li>

                      @endif

                   @endif

                @endif
          
             @endforeach
       @endif
    </ul>
    
    @if(isset($i) && !empty(count($categories['data'])-$i-$categoryCount+1))
    <a href="javascript:void(0)" class="show-more-filter">+{{count($categories['data'])-$i-$categoryCount+1}} More</a>
    @endif
    <!--filter show options-->
  
    <!--Full Filter-->
    <div class="full_filter">
       <div class="full-filter-header">
          <div class="flex-row align-items-center">
             <div class="flex-col-sm-6">
                <div class="text-field-wrapper pro-srchbox">    
                   <input type="text" id="full_filter_search" data-id="list_navigation_full_filter" placeholder="Search">
                   <span class="detect-icon"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>   
                </div>
             </div>
             <div class="flex-col-sm-6 text-right">
                <span class="close-full-filter">Close</span>
             </div>
          </div>
       </div>
      
       <div class="grid">
          <ul id="list_navigation_full_filter">
             <!-- <span class="alpha-title">A</span> -->
         @if(!empty($categories['data']))
         @foreach ($categories['data'] as $key => $item)
            
                <li class="@if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) {{'special'}} @endif">
                      <div class="input-holder acknowledge mt-23 clearfix">
                               <input type="checkbox"  name="category_id[]" class="all_filter category_id_{{$item['id']}}" id="category_id_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                               <label for="category_id_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                      </div>
                </li>
          

          @endforeach
       @endif
            
          </ul>
       </div>
    </div>
    <!--Full Filter view close-->
 </div>

 @endif