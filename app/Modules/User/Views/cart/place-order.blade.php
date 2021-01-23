@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


<!--header close-->
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
                           <li class="active"><a href="{{route('user.show.cart.list')}}"><span class="digit">1</span> <span> Cart</span></a> </li>
                           <li class="active"><a href="{{route('user.checkout.delivery.address')}}"><span class="digit">2</span></a> <span> Address</span> </li>
                             
                              <li class="active"><span class="digit">3</span> <span> Order Summary</span> </li>
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
               <div class="flex-row b-top">
                  <div class="cart_left_col">
                     <!--Repeat Card-->
                                 
                           @if(!empty($cartList))
                           @foreach($cartList as $key => $val)    
                           <div class="order-orderInfo-card">
                              <div class="item-container">
                                 <figure class="items_img">
                                    <img src="{{$val['product_image']}}" onerror="imgProductError(this);">
                                 </figure>
                                 <div class="items_details">
                                    <div class="flex-row">
                                       <div class="flex-col-sm-9">
                                          <span class="item-name">{{$val['product_name']}}</span>
                                          <span class="item-category">{{$val['category_name']}}</span>
                                          <span class="item-storekeeper">Sold By {{($val['storeDetail'])}}</span>
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
                                    {{-- <div class="flex-row">
                                       <div class="flex-col-sm-12">
                                          <button class="outline_gry_btn">{{$val['size'].' '.$val['size_unit']}} </button>
                                          <select class="outline_gry_btn qty selectQty quantity-update">

                                             @for($i = 1; $i<=config('constants.CART.MAX_SINGLE_ITEM_QUANTITY');++$i) 
                                                <option data-cartUid="{{$val['cart_uid']}}" @if($i==$val['quantity']) selected @endif value="{{$i}}">Qty {{$i}} </option>
                                              @endfor

                                          </select>
                                          <span></span>
                                       </div>
                                    </div> --}}
                                 </div>
                                 @if($val['is_available']==0 || $val['status']=='blocked' || $val['category_status']=='blocked')
                                        @php
                                        $flag=1;    
                                        @endphp
                                 @endif
                              </div>
                              {{-- <div class="addressAccordian-buttons">
                                 <div class="addressAccordian-button remove_from_cart" data-cartUid="{{$val['cart_uid']}}"> REMOVE </div>
                                 <div class="addressAccordian-buttonDivider"></div>

                                 @if(!$val['is_wishlisted'])
                                 <div class="addressAccordian-button show_move_to_wish_list_id" data-product-id="{{$val['product_id']}}" data-cartUid="{{$val['cart_uid']}}" data-is_wish_list="{{$val['is_wishlisted']}}"> Move To Wishlist </div>
                                 @endif

                              </div> --}}
                           </div>

                           @endforeach
                           @endif

                     </div>

                  <div class="cart_right_col">
                     <div class="item_detail">

                       <!--Before Apply Coupon Button close-->
               <!--After Apply Coupon Button-->
                           @if(!empty($total['promo_code_applied']))
                           <div class="apply_coupon">
                                    <div class="flex-row align-items-center">
                                       <div class="flex-col-sm-6 flex-col-xs-6">
                                          <span class="coupon_name">{{$total['promo_code_applied']}}</span>
                                          <span class="applied">Offer applied <span class="primary_color">(${{number_format($total['discounts']['promo_discount'], 2)}})</span></span>
                                       </div>

                                       <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                                          <span class="remove" data-toggle="modal" data-target="#myModal-coupon-code-remove" >Remove</span>
                                       </div>

                                    </div>
                              </div>
                           @endif
               <!--After Apply Coupon Button Close-->



                        <div class="items m-t-30">

                        <label class="form_label">{{$items}} Items</label>

                              @if(!empty($summary))
                              @foreach($summary as $key => $val)

                              <div class="flex-row">
                                 <div class="flex-col-sm-10">
                                    <span class="item_name_sm">{{$val['product_name']}} ({{$val['size']}} {{$val['size_unit']}}) x {{$val['quantity']}}</span>
                                 </div>
                                 <div class="flex-col-sm-2">
                                    <label class="form_label text-right">${{number_format($val['item_subtotal'], 2)}}</label>
                                 </div>
                              </div>

                              @endforeach
                              @endif

                        </div>


                      <div class="total_items">
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <span class="item_name_sm">Item Total</span>
                     </div>
                     <div class="flex-col-sm-2">
                        <label class="form_label text-right">${{empty($total['cartSubTotal']) ? 0 : number_format($total['cartSubTotal'], 2) }}</label>
                     </div>
                  </div>
                  

                  @if(!empty($total['discounts']))
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label primary_color">Discount Applied</label>
                     </div>
                     {{-- <div class="flex-col-sm-2 text-right">
                        <label class="form_label primary_color">-${{number_format($total['discounts']['promo_discount'], 2)}}</label>
                     </div> --}}
                     <div class="flex-col-sm-2 text-right">
                           @if(!empty($total['discounts']['promo_discount']))
                              <label class="form_label primary_color" data-toggle="tooltip" title="Coupan discount">-$ {{number_format($total['discounts']['promo_discount'], 2)}}</label>
                          @endif
                            @if(!empty($total['discounts']['loyaltyPoint']))
                               <label class="form_label primary_color" data-toggle="tooltip" title="Loyalty point discount">-$ {{number_format($total['discounts']['loyaltyPoint'], 2)}}</label>
                            @endif
                       </div>
                  </div>
                  @endif

               </div>


                        <div class="total_bill">
                           <div class="flex-row">
                              <div class="flex-col-xs-6">
                                 <label class="total_bill_label">BILL TOTAL</label>
                              </div>
                              <div class="flex-col-xs-6 text-right">
                                  <label class="total_bill_label">${{empty($total['net_amount']) ? 0 : number_format($total['net_amount'], 2) }}</label>
                              </div>
                           </div>

                           <div class="flex-row m-t-30">
                                 <div class="flex-col-sm-12">
                                    <label class="form_label py_info_icon" data-toggle="tooltip" title="Cash On Delivery">Payment</label>
                                    <span class="title">Cash On Delivery Only </span>
                                 </div>
                              </div>

                              @if(!empty($delivery))
                             
                              <div class="flex-row m-t-30">
                                    <div class="flex-col-sm-12">
                                          <span class="save_address_type">{{$delivery['address_type']}}</span>
                                       <label class="form_label">Deliver To</label>
                                       <span class="title"> {{$delivery['name']}} </span>
                                       <div class="address">
                                             <p> {{$delivery['zipcode']}} {{$delivery['formatted_address']}},</p>
                                             <p> {{$delivery['city']}}, {{$delivery['state']}}, {{$delivery['country']}}</p>
                                             <p>Mobile Number: {{$delivery['mobile']}} </p>
                                          </div>
                                    </div>
                                 </div>
                                 @endif


                                 <div class="flex-row m-t-30">
                                       <div class="flex-col-sm-12">
                                      @if(!$flag)
                                      <a href="{{route('user.place.order').'?order_id='.$orderId}}" class="full-btn custom-btn green-fill getstarted btn-effect">Place Order</a>
                                      @else
                                      <a href="javascript:void(0)" onclick="checkPlaceOrderAvailability()"><button   class="full-btn custom-btn green-fill getstarted btn-effect">Place Order</button></a>
                                      @endif
                                      
                                       </div>

                                       
                                    </div>


                        </div>



                     </div>
                  </div>
               </div>
            </div>
         </section>
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

<input type="hidden" id="cart-list-url" value="{{route('user.show.cart.list')}}">
<input type="hidden" id="update_qty_url" value="{{route('user.update.quantity')}}">        
<input type="hidden" name="search_type" value="1">
@endsection
@section('pagescript')
<script src="{{asset('asset-user/js/cart-list.js')}}"></script>

@endsection