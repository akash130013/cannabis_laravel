<div class="order-detail-sidebar" id="track_{{$item['order_uid']}}">
        <div class="inner_wrap">
           <div class="detail-sidebar">
              <div class="sidebar-header">
                 <div class="wrapper">
                    <span>
                       <img src="{{asset('asset-user-web/images/close-line.svg')}}" alt="close"/>
                    </span>
                    <label>Order Detail</label>
                 </div>
               @if(isset($item['cancel_by']))
                    <button type="button" class="btn_sm status-btn {{$status}}" data-toggle="tooltip" title="Rejected By Store"> Rejected </button>
                @else
               <button type="button" class="btn_sm status-btn {{$status}}"> {{ ucfirst($status) }} </button>

               @endif
             
              </div>
           </div>
           <hr>

           <div class="detail-sidebar">
              <div class="item_detail">
                 <div class="track-detail">
                    <label>Order ID #{{$item['order_uid'] ?? 'N/A'}}</label>
                    <span>
                       {{-- {{ \App\Helpers\CommonHelper ::convertFormat($item['order_created_date'], 'M d, Y')}}  --}}
                     {{-- </br> --}}
                    
                     @if($status=='processing')
                     <span>Sheduled date:</span>
                       <span>@if(isset($item['schedule_date'])) {{\App\Helpers\CommonHelper ::convertFormat($item['schedule_date'], 'M d, Y')}}@else N/A @endif</span><br>
                     @endif
                     
                     @if($status=='delivered')
                     <span>Delivery date:</span>
                       <span>
                          @if(isset($item['delivery_time'])) 
                           {{\App\Helpers\CommonHelper ::convertFormat($item['delivery_time'], 'M d, Y')}}
                          @else 
                           N/A 
                          @endif
                        </span>
                        <br>
                     @endif

                     @if(!empty($item['distributor_name'])) BY @endif  {{ $item['distributor_name'] ?? 'No Driver Assigned'}}
                  </span>

                    <div>

                       <div class="track-status">
                          <div>
                          <label>{{$item['store_name'] ?? 'N/A'}}</label>
                          <span>{{$item['store_address'] ?? 'N/A'}}</span>
                          </div>
                          <div class="track-address">
                          <label>{{$item['delivery_address']['address_type'] ?? 'N/A'}}</label>
                          <span>{{$item['delivery_address']['formatted_address'] ?? 'N/A'}}</span>
                          </div>
                       </div>

                    </div>
                 </div>

                 <div class="items m-t-30">
                 <label class="form_label">{{$item['itemCount'] ?? '0'}} Item</label>

             @if(isset($item['cartSummary']) && !empty($item['cartSummary']))
             
                 @foreach ($item['cartSummary'] as $row)
                 
                    <div class="flex-row">
                       <div class="flex-col-sm-10">
                          <span class="item_name_sm"> {{$row['product_name'] ?? 'N/A'}}({{$row['size']}}{{$row['size_unit'][0]}}) x {{$row['quantity']}}</span>
                       </div>
                       <div class="flex-col-sm-2">
                       <label class="form_label text-right">$ {{number_format($row['item_subtotal'] ?? '0', 2)}}</label>
                       </div>
                    </div>
                    @endforeach
             @endif
                 </div>
               
                 <div class="total_items">
                    <div class="flex-row">
                       <div class="flex-col-sm-10">
                          <span class="item_name_sm">Total</span>
                       </div>
                       <div class="flex-col-sm-2">
                       <label class="form_label text-right">@if(isset($item['cartSummary']) && !empty($item['cartSummary'])) $ {{number_format(array_sum(array_column($item['cartSummary'],'item_subtotal')),2)}}@else $ 0.00 @endif</label>
                       </div>
                    </div>

                    <div class="flex-row">
                       <div class="flex-col-sm-10">
                          <label class="form_label">Additional Charges</label>
                       </div>
                       <div class="flex-col-sm-2 text-right">
                       <label class="form_label">$ {{number_format($item['additional_charges'] ?? 0,2)}}</label>
                       </div>
                    </div>
                   

                    <div class="flex-row">
                       <div class="flex-col-sm-10">
                          <label class="form_label primary_color">Discount</label>
                       </div>
                       <div class="flex-col-sm-2 text-right">
                       <label class="form_label primary_color">
                        @if(isset($item['discounts']['promo_discount']))
                           $ {!!isset($item['discounts']['promo_discount']) ? @round($item['discounts']['promo_discount'],2) : '0.00'!!}
                        @elseif(isset($item['discounts']['loyaltyPoint']))
                           $ {!!isset($item['discounts']['loyaltyPoint']) ? @round($item['discounts']['loyaltyPoint'],2) : '0.00'!!}
                        @else
                           $ 0.0
                        @endif
                     </label>
                       </div>
                    </div>

                 </div>

                 <div class="total_bill">
                    <div class="flex-row">
                       <div class="flex-col-xs-6">
                          <label class="total_bill_label">BILL TOTAL</label>
                          <label class="form_label txt-paid-via">Paid via Cash</label>
                       </div>
                       <div class="flex-col-xs-6 text-right">
                       <label class="total_bill_label">$ {{number_format($item['net_amount'] ?? '0',2)}}</label>
                       </div>
                    </div>
                 </div>
              </div>
           </div>

           <!-- order-detail sidebar -->
        </div>

     </div>