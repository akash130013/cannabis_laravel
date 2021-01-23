<div class="select">
    Sort By:@if(!empty($query) && (isset($query['sorting_id']))) {{config('constants.SORTING_FILTER')[$query['sorting_id']]}} @endif
       <span class="sort-downArrow"></span>
    <ul>

       <li class="all_filter_sort" data-num="1">
           <label class="dropdown" for="new">Price: High To Low</label> 
           <input type="radio" class="check_1"  name="sorting_id" id="new" value="1" @if(isset($query['sorting_id']) && $query['sorting_id']==1)) checked @endif>
        </li>

       <li class="all_filter_sort" data-num="2">
           <label class="dropdown" for="lowtohigh">Price: Low To High</label>
            <input type="radio" class="check_2"  name="sorting_id"  id="lowtohigh" value="2" @if(isset($query['sorting_id']) && $query['sorting_id']==2)) checked @endif>
        </li>
        
       {{-- <li class="all_filter_sort"><label class="dropdown" for="recommmended">Recommended Products</label> <input type="radio"  name="sorting_id"  id="recommmended" value="3" @if(isset($query['sorting_id']) && $query['sorting_id']==3)) checked @endif></li> --}}
       {{-- <li class="all_filter_sort"><label class="dropdown" for="whatnew">What's New</label> <input type="radio"  name="sorting_id" id="whatnew" value="4" @if(isset($query['sorting_id']) && $query['sorting_id']==4)) checked @endif></li> --}}
       <li class="all_filter_sort" data-num="5">
           <label class="dropdown" for="popularity">Popularity</label>
            <input type="radio" class="check_5"  name="sorting_id"  id="popularity" value="5" @if(isset($query['sorting_id']) && $query['sorting_id']==5)) checked @endif>
       </li>
       {{-- <li class="all_filter_sort"><label class="dropdown" for="relevence">Relevance Products</label> <input type="radio"  name="sorting_id" id="relevence" value="6" @if(isset($query['sorting_id']) && $query['sorting_id']==6)) checked @endif></li> --}}
   </ul>
 </div>