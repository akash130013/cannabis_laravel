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
         <li><a href="{{route('user.show.wish.list')}}">Products</a></li>
         <li><a class="active">Stores</a></li>
      </ul> 
   </div>
   <!--header menu close-->
</div>
 <!--section list filter-->
 <section class="inner_centerpanel">
        <div class="custom_container">
           <div class="flex-row">
              <div class="flex-col-sm-12">
                 <div class="flex-row align-items-center">
                    <div class="flex-col-sm-6 flex-col-xs-6">
                       <h2 class="title-heading m-t-b-30">My Bookmarked Stores&nbsp;(<span id="wishCount">{{$bookmarks['total'] ?? 0}}</span>&nbsp;Items)</h2>
                    </div>
                    <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                    </div>
                 </div>
                 <div class="flex-row">
                    @if(!empty($bookmarks))
                    @foreach($bookmarks['data'] as $val)
                    <!--Repeat Card-->
                    <div class="flex-col-sm-4" id="data-remove-id_{{$val['store_id']}}">
                        <div class="product_card">
                            <div class="product_card_inner_wrap card-effect">
                                <figure class="product_img">
                                    <span class="remove_card" data-store-id="{{$val['store_id']}}"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></span>
                                    @foreach ($val['store_images'] as $img)
                                        <img src="{{$img}}" onerror="imgStoreError(this);">  
                                    @endforeach
                                    
                                </figure>
                                <div class="product_srt_detail">
                                    <div class="review_count">
                                    <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}"> {{$val['rating']}} </span>
                                    <span class="total">{{$val['review_count']}} Reviews</span>
                                    </div>
                                  <a href="{{route('users.store.detail',['id'=>encrypt($val['store_id'])])}}" target="_blank">  <span class="pro_name">{{$val['store_name']}}</span></a>
                                    {{-- <span class="pro_cateogry_name">Pure Kush | Flower</span>
                                    <span class="price">$345 - $440</span> --}}
                                </div>
                                {{-- <div class="product_by">
                                    <a href="javascript:void(0)" class="add-to-cartbtn"> Add To Cart</a>
                                </div> --}}
                            </div>
                        </div>
                        </div>
                    @endforeach
                    @endif
                    <!--Repeat Card Close-->
                 </div>
              </div>
           </div>
        </div>
     </section>
     <!--section list filter close-->
      <input type="hidden" name="remove_end_point" id="remove_end_point" value="{{url('/').config('userconfig.ENDPOINTS.HOME.REMOVE_BOOKMARK_LIST')}}">
      <input type="hidden" name="bearer_token" id="bearer_token" value="{{$token ?? ''}}">
      <input type="hidden" name="search_type" value="1">

@endsection
@section('pagescript')
<script>
   var REMOVE_FROM_BOOKMARK_LIST = {

      __handle_remove_from_bookmark_list: function(token, url, id,$this) {

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
               var para='Removed from your bookmark';
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
      var id = $(this).attr('data-store-id');
      var finalurl = url + "/" + id;
      // REMOVE_FROM_BOOKMARK_LIST.__handle_remove_from_bookmark_list(token, finalurl, id,$(this));
      swal({
            title: localMsg.BeSure,
            text: "Do you really want to remove from bookmark ?",
            type: "warning",
            icon: "warning",
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
                  REMOVE_FROM_BOOKMARK_LIST.__handle_remove_from_bookmark_list(token, finalurl, id,$(this));
               }
         })

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
