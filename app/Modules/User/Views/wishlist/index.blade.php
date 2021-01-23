@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


<!--header close-->
@section('content')

@yield('nav-bar')

<hr class="header-ruler">
<div class="header_inner in-head-pad">
   <!--header menu-->
   <div class="head-nav tab_wrapper">
      <ul>
         <li><a class="active">Products</a></li>
         <li><a href="{{route('user.wishlist.bookmark.list')}}">Stores</a></li>
      </ul>
   </div>
   <!--header menu close-->
</div>

<section class="inner_centerpanel">
   <div class="custom_container">
      <div class="flex-row">
         <div class="flex-col-sm-12">
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                  <h2 class="title-heading m-t-b-30">My Wishlist&nbsp;(<span id="wishCount">{{$wishList['total'] ?? 0}}</span>&nbsp;Items)</h2>
               </div>
               <div class="flex-col-sm-6 flex-col-xs-6 text-right">
               </div>
            </div>
            <div class="flex-row" id="scroller">
               <!--Repeat Card-->
              
               @if(!empty($wishList))
               @foreach($wishList['data'] as $val)
                
               <div class="flex-col-sm-4 item-wishlist" id="data-remove-id_{{$val['id']}}">
                  <div class="product_card">
                     <div class="product_card_inner_wrap card-effect">
                        <figure class="product_img">
                           <span class="remove_card" data-product-id="{{$val['id']}}"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></span>
                           <a href="{{route('users.product.detail',['id' =>encrypt($val['id'])])}}" target="_blank">
                              <img src="{{$val['product_images'][0]['file_url'] ?? ''}}" onerror="imgProductError(this);">
                           </a>
                        </figure>
                        <div class="product_srt_detail">
                           <div class="review_count">
                              <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$val['rating']}} </span>
                              <span class="total">{{$val['review_count']}} Reviews</span>
                           </div>
                           <a href="{{route('users.product.detail',['id' =>encrypt($val['id'])])}}" target="_blank">
                              <span class="pro_name">{{$val['product_name']}}</span>
                           </a>
                           <span class="pro_cateogry_name">{{$val['category_name']}}</span>
                           <span class="price">{{$val['price_range']}}</span>
                        </div>
                        {{-- <div class="product_by">
                           <a href="javascript:void(0)" class="add-to-cartbtn" id="add_cart_button">  Add To Cart</a>
                        </div> --}}
                     </div>
                  </div>
               </div>
              
               @endforeach

               @if(!empty($wishList['data']))
                   <div class="scroller-status">
                        <div class="infinite-scroll-request loader-ellips">
                        </div>
                        <p class="infinite-scroll-last"></p>
                        <p class="infinite-scroll-error"></p>
                    </div>
             @endif

               @endif

               <!--Repeat Card Close-->


            </div>
            @if(!empty($wishList['data']))
            <div class="pagination">
               <a href="@if(isset($wishList['nextPage']) && !empty($wishList['nextPage'])){{route('user.show.wish.list').'?page='.$wishList['nextPage']}}@else javascript:void(0)@endif" class="next"></a>
            </div>
            @endif

         </div>
      </div>
   </div>
</section>

<input type="hidden" name="remove_end_point" id="remove_end_point" value="{{url('/').config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST')}}">
<input type="hidden" name="bearer_token" id="bearer_token" value="{{$token ?? ''}}">
<input type="hidden" name="search_type" value="1">

@endsection

@section('pagescript')
<script src="{{asset('asset-user/js/user-product-detail.js')}}"></script>

<script>
   var REMOVE_FROM_WISH_LIST = {

      __handle_remove_from_wish_list: function(token, url, id,$this) {

         $.ajax({
            url: url,
            type: 'get',
            // Fetch the stored token from localStorage and set in the header
            headers: {
               "Authorization": token
            },
            beforeSend: function() {
               $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },
            success: function(response) {
               var wishCount=Number($("#wishCount").text());
               $("#data-remove-id_" + id).remove();
               $("#wishCount").text(wishCount-1);
             var para='Removed from your wishlist';
               showSnackbar(para);
            },
            error: function() {
               alert("Something went wrong. Please try again");
            }
         });

      }
   }

 // driver function //

   $("body").on('click', '.remove_card', function() {

      var url = $("#remove_end_point").val();
      var token = $("#bearer_token").val();
      var id = $(this).attr('data-product-id');
      var finalurl = url + "/" + id;

      swal({
            title: localMsg.BeSure,
            text: "Do you really want to remove from wishlist ?",
            type: "warning",
            icon:"warning",
            buttons: ["No", "Yes!"],
            showCancelButton: true,
            cancelButtonClass: 'btn-danger btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            cancelButtonText: "No",
            cancel:true,
            closeOnClickOutside: true,
            closeOnEsc: true
        }).then((isConfirm) => {
               if (isConfirm) {
                  REMOVE_FROM_WISH_LIST.__handle_remove_from_wish_list(token, finalurl, id,$(this));
               }
         })

      // REMOVE_FROM_WISH_LIST.__handle_remove_from_wish_list(token, finalurl, id,$(this));

   });



   $('#scroller').infiniteScroll({
         // options
         path: '.next',
         append: '.item-wishlist',
         history: false,
         status: '.scroller-status',
         checkLastPage: true,
         hideNav: '.pagination'
      });
</script>
@endsection









