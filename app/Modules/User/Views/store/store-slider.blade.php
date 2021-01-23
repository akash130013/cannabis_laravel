<div id="store-detail-owl" class="owl-carousel">
    <!--repeat item-->
    @if(!empty($storeDetail['store_images']))
    @foreach ($storeDetail['store_images'] as $item)
    <div class="item">
       <figure class="banner_img">
          
             <img src="{{$item}}" alt="Kingdom" onerror="imgStoreError(this);"> 
           
             <div class="banner_container store-banner-content">
             {{-- <h1 class="store-banner-name"> {{$storeDetail['store_name'] ?? 'N/A'}}</h1> --}}
                   {{-- <span class="review">
                             <div class="review_count">
                             <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$storeDetail['rating'] ?? '0'}}</span>
                                 <span class="total">{{$storeDetail['review_count']}} Reviews</span>
                             </div>
                    </span> --}}
             </div>
        
       </figure>
    </div>
    @endforeach
          
    @endif
    <!--repeat item close-->
 </div> 