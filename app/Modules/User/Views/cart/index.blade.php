@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

@section('content')

@yield('nav-bar')
@php
   $flag=0;
 @endphp
<section class="inner_centerpanel">
   <div class="custom_container">
      <div class="flex-row">
         <div class="flex-col-sm-12">
            <div class="cart_step">

               <ul>
                  <li class="active"><span class="digit">1</span> <span> Cart</span> </li>
                  <li><span class="digit">2</span> <span> Address</span> </li>
                  <li><span class="digit">3</span> <span> Order Summary</span> </li>
               </ul>

            </div>
         </div>
      </div>

      <div class="flex-row align-items-center">

         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">My Cart ({{$items}} Items)</h2>
         </div>

         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
         </div>

      </div>

      
   @if(!empty($cartList))

      <div class="flex-row b-top">
         <div class="cart_left_col">

            @foreach($cartList as $key => $val)
           
            <div class="order-orderInfo-card">
               <div class="item-container">

                        <a href="{{route('users.product.detail',['id' =>encrypt($val['product_id']),'store_id' => encrypt($val['store_id'])])}}" target="_blank">

                  <figure class="items_img">
                     <img src="{{$val['product_image']}}" onerror="imgProductError(this);">
                  </figure>
                     </a>
                  <div class="items_details">
                     <div class="flex-row">
                        <div class="flex-col-sm-9">
                              <a href="{{route('users.product.detail',['id' =>encrypt($val['product_id']),'store_id' => encrypt($val['store_id'])])}}" target="_blank">
                                 <span class="item-name">{{$val['product_name']}}</span>
                              </a>
                                 <span class="item-category">{{$val['category_name']}}</span>
                              <a href="{{route('users.store.detail',['id'=>encrypt($val['store_id'])])}}" target="_blank">
                                 <span class="item-storekeeper">Sold By {{$val['storeDetail']}}</span>
                              </a>
                        </div>

                        <div class="flex-col-sm-3">
                           <div class="discount">
                              <span class="item_discount_price">$ {{number_format($val['per_item_selling_price'],2)}}</span>

                              @if($val['discount'])
                              <span class="item_mrp_price">{{$val['actual_price']}}</span> <span class="item_discount_off">{{$val['discountPercent']}}% OFF</span>
                              @endif

                           </div>
                        </div>

                     </div>

                     <div class="flex-row">
                        <div class="flex-col-sm-12 @if($val['is_available']==0 || $val['status']=='blocked' || $val['category_status']=='blocked') disabledbutton @endif">
                           {{-- <button class="outline_gry_btn">{{$val['size'].' '.$val['size_unit']}} </button> --}}
                           {{-- For unit --}}
{{--                           @php dump($val['size']); @endphp--}}
                           <select class="outline_gry_btn qty selectQty unit-update">
                              @foreach ($val['stock_product'] as $item)
                                 <option data-cartUid="{{$val['cart_uid']}}"
                                    @if($item['total_stock']<=0) disabled @endif
                                    @if($val['size_unit'] == $item['unit'] && $val['size'] == $item['quant_unit']) selected @endif
                                    data-unit="{{$item['unit']}}" value="{{$item['quant_unit']}}">
                                    {{$item['unit']}} {{$item['quant_unit']}}
                                 </option>
                              @endforeach
                           </select>
                           <span></span> 
                        <input type="hidden" id="size" value="{{$val['size']}}">
                        <input type="hidden" id="size_unit" value="{{$val['size_unit']}}">
                           {{-- for qty --}}
                           <select class="outline_gry_btn qty selectQty quantity-update">

                              @for($i = 1; $i<=config('constants.CART.MAX_SINGLE_ITEM_QUANTITY');++$i)
                                 <option data-cartUid="{{$val['cart_uid']}}" @if($i==$val['quantity']) selected @endif value="{{$i}}">Qty {{$i}} </option>
                              @endfor

                           </select>
                           <span></span>
                        </div>
                        @if($val['is_available']==0 || $val['status']=='blocked' || $val['category_status']=='blocked')
                         @php
                         $flag=1;
                         @endphp
                        <span class="error">This product is unavailable</span>
                        @endif
                     </div>

                  </div>
               </div>
               <div class="addressAccordian-buttons">
                  <div class="addressAccordian-button remove_from_cart" data-cartUid="{{$val['cart_uid']}}"> REMOVE </div>
                  <div class="addressAccordian-buttonDivider"></div>

                  @if(!$val['is_wishlisted'])
                     <div class="addressAccordian-button show_move_to_wish_list_id" data-product-id="{{$val['product_id']}}" data-cartUid="{{$val['cart_uid']}}" data-is_wish_list="{{$val['is_wishlisted']}}"> Move To Wishlist </div>
                     @else
                     <div class="addressAccordian-button disabledbutton"> Move To Wishlist </div>
                 @endif

               </div>
            </div>

            @endforeach
            @endif


         </div>

       @if($items>0)
        @include('User::cart.show-price-bar')
       @else
          <figure class="not_found"><img src="{{asset('asset-user-web/images/no-item-found.jpg')}}" alt=""></figure>
       @endif

</section>



<!--Apply coupon Modal-->
<div class="modal fade" id="myModal-coupon-code" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Apply Coupon</h4>
         </div>
         <div class="modal-body">
            <div class="modal-padding">

               <div class="form-field-group">
                  <div class="text-field-wrapper">
                     <input type="text" placeholder="Enter Coupon Code" maxlength="20" id="coupon_input" style="text-transform: uppercase" class="font_mob">
                     <span id="coupon_error" class="error"></span>
                     <button class="apply_btn" id="apply_button">APPLY</button>
                  </div>
               </div>

               @if($coupons)
               <span class="coupon_title">Best Coupon For You</span>
                @endif

               <div class="coupon_block_wrapper">
                  <!--Repeat Card-->
                  @if($coupons)

                  @foreach($coupons as $val)

                  <div class="coupon_block_row">
                     <div class="flex-row align-items-center">
                        <div class="flex-col-sm-6 flex-col-xs-6">
                           <span class="coupon_code">{{$val['coupon_code']}}</span>
                        </div>
                        <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                           <button class="apply_btn_outline btn-effect apply_button_promo_code" data-promocode="{{$val['coupon_code']}}">Apply</button>
                        </div>
                     </div>

                     <div class="flex-row align-items-center m-t-b-30">
                        <div class="flex-col-sm-12">
                           @if($val['promotional_type'] == 'fixed')
                           <span class="title">Save $ {{number_format($val['amount'], 2)}} <p class="comnn_para">Offer valid till <b>{{$val['end_time']}}.</b></span>
                           @else
                           <p class="comnn_para">Get {{$val['amount']}}% off upto  ${{number_format($val['max_cap'], 2)}}. Offer valid till <b>{{$val['end_time']}}.</b></p>
                           @endif
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
   </div>
</div>
<!--Apply coupon Modal Close-->

<!--Delete Address Modal-->
<div class="modal fade" id="myModal-delete-address" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Move To WishList</h4>
         </div>
         <div class="modal-body">
            <form action="{{route('user.wishlist.action')}}" id="wish_list_submit_form" method="post">
               @csrf
               <div class="modal-padding">
                  <h1 class="confirm_heading">Confirmation</h1>
                  <p class="commn_para">Are you sure want to move this item to wish list. </p>

                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes,Move</button>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="is_wishlisted" id="is_wishlisted_id" value="">
               <input type="hidden" name="product_id" id="move_to_wish_list_id" value="">
               <input type="hidden" name="is_cart_remove" value="1">
               <input type="hidden" name="cartUid" id="cart_uid">
            </form>

         </div>
      </div>
   </div>
</div>

<input type="hidden" id="promo_code_submit_url" value="{{route('user.validate.promo.code')}}">
<input type="hidden" value="{{$orderId}}"  id="order_id_cart">



<!--Delete Address Modal-->
<div class="modal fade" id="myModal-delete-cart-list" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Remove From Cart</h4>
         </div>
         <div class="modal-body">
            <form action="{{route('user.cart.remove.item')}}" id="wish_list_submit_form" method="post">
               @csrf
               <div class="modal-padding">
                  <h1 class="confirm_heading">Confirmation</h1>
                  <p class="commn_para">Are you sure want to remove this item from the cart. </p>

                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes</button>
                        <button type="button" class="ch-shd back line_effect" data-dismiss="modal">No</button>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="id" id="cart_uid_remove">
            </form>

         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="myModal-coupon-code-remove" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Remove Coupon Code</h4>
         </div>
         <div class="modal-body">
            <form action="{{route('user.remove.coupon.code')}}" id="wish_list_submit_form" method="post">
               @csrf
               <div class="modal-padding">
                  <h1 class="confirm_heading">Confirmation</h1>
                  <p class="commn_para">Are you sure want to remove applied coupon code. </p>

                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes</button>

                        <button type="button" class="ch-shd back line_effect" data-dismiss="modal">No</button>

                     </div>
                  </div>
               </div>
               <input type="hidden" name="id" value="{{$orderId ?? ''}}">

               <input type="hidden" name="promo_code" value="{{empty($total['promo_code_applied']) ? '' : $total['promo_code_applied'] }}">
            </form>

         </div>
      </div>
   </div>
</div>



<div class="modal fade" id="myModal-cart-update-quantity" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Update Product Quantity</h4>
         </div>
         <div class="modal-body">
            <form action="{{route('user.update.quantity')}}" id="wish_list_submit_form" method="get">

               <div class="modal-padding">
                  <h1 class="confirm_heading">Confirmation</h1>
                  <p class="commn_para">Are you sure want to update product quantity. </p>

                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes</button>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No</a>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="cart_uid" id="cart_uid_cart_update">

               <input type="hidden" name="quantity" value="" id="quantity_update_cart">
            </form>

         </div>
      </div>
   </div>
</div>

<input type="hidden" id="update_qty_url" value="{{route('user.update.quantity')}}">
<input type="hidden" id="loyalty_point_redumption_url" value="{{route('user.loyality-point.redumption')}}">

<input type="hidden" name="token" id="token" value="{{$token}}">
<input type="hidden" name="search_type" value="1">
@endsection
@section('pagescript')
<script src="{{asset('asset-user/js/cart-list.js')}}"></script>
@endsection
