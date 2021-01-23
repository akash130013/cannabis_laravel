<div class="cart_right_col">
    <div class="item_detail">

       <!--Before Apply Coupon Button-->
       @if(empty($total['promo_code_applied']))
       <div class="apply_coupon" id="open-promo-model">
          <img src="{{asset('asset-user-web/images/discount.png')}}"> Apply Coupon
       </div>
       @endif



       <!--Before Apply Coupon Button close-->
       <!--After Apply Coupon Button-->
       @if(!empty($total['promo_code_applied']))
       <div class="apply_coupon">
                      <div class="flex-row align-items-center">
                         <div class="flex-col-sm-6 flex-col-xs-6">
                            <span class="coupon_name">{{$total['promo_code_applied']}}</span>
                            <span class="applied">Offer applied <span class="primary_color">(${{$total['discounts']['promo_discount']}})</span></span>
                         </div>
                         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                            <span class="remove" data-toggle="modal" data-target="#myModal-coupon-code-remove" >Remove</span>
                         </div>
                      </div>
                </div>
       @endif
       <!--After Apply Coupon Button Close-->

       <!--loyalty point info !-->
       @if(!empty(Session::get('loyaltyPoint')))
       <div class="items m-t-30">
           
       <label class="form_label">
         @if(!empty($total['discounts']['loyaltyPoint']))
            Value of loyalty point {{Session::get('loyaltyPoint')}}  is $ {{number_format($total['discounts']['loyaltyPoint'], 2)}}</span>
         @else
            Loyalty point ({{Session::get('loyaltyPoint')}}) 
         @endif
      </label>
                      
             <div class="form-group">
                   <div class="input-holder acknowledge mt-23 clearfix">
                       <input type="checkbox" name="loyalty_point" id="loyalty_point" value="@if(!empty($total['discounts']['loyaltyPoint'])) 1 @else 2 @endif"   @if(!empty($total['discounts']['loyaltyPoint'])) checked @endif>
                       <label for="loyalty_point">Use My loyalty Point</label>
                   </div>
               </div>
               <span id="spinner"></span>
       </div>
       @endif
    <!--close loyalty point info !-->

       <div class="items m-t-30">
          <label class="form_label">{{$items}} Items</label>

          @if(!empty($summary))
          @foreach($summary as $key => $val)

          <div class="flex-row">
             <div class="flex-col-sm-9">
                <span class="item_name_sm">{{$val['product_name']}} ({{$val['size']}} {{$val['size_unit']}}) x {{$val['quantity']}}</span>
             </div>
             <div class="flex-col-sm-3">
                <label class="form_label text-right">$ {{number_format($val['item_subtotal'], 2)}}</label>
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
                <label class="form_label text-right">${{number_format(empty($total['cartSubTotal']) ? 0 : $total['cartSubTotal'], 2) }}</label>
             </div>
          </div>
        
       
          @if(!empty($total['discounts']))
          <div class="flex-row">
             <div class="flex-col-sm-9">
                <label class="form_label primary_color">Discount Applied</label>
             </div>
             <div class="flex-col-sm-3 text-right">
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
             <div class="flex-col-sm-6">
                <label class="total_bill_label">BILL TOTAL</label>
             </div>
             <div class="flex-col-sm-6 text-right">
                <label class="total_bill_label">$ {{number_format(empty($total['net_amount']) ? 0 : $total['net_amount'], 2) }}</label>
             </div>
          </div>
       </div>

      
       <div class="flex-row">
          <div class="flex-col-sm-12">
             @if(!empty($items))
                @if(!$flag)
                    <a id="checkout" href="{{route('user.checkout.delivery.address')}}"><button   class="full-btn custom-btn green-fill getstarted btn-effect">CHECKOUT</button></a>
                @else
                <a href="javascript:void(0)" onclick="checkOrderAvailability()"><button   class="full-btn custom-btn green-fill getstarted btn-effect">CHECKOUT</button></a>
                @endif
                     
               @else
               
             <button   class="full-btn custom-btn green-fill getstarted btn-effect" disabled="disabled">CHECKOUT</button>
             @endif
          </div>
       </div>
    

    </div>
 </div>