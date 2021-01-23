@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


<!--header close-->
@section('content')

@yield('nav-bar')

  <!--section list filter-->
  <section class="inner_centerpanel">
            <div class="custom_container">
               <div class="flex-row">
                  <div class="flex-col-sm-12">
                     <div class="cart_step">
                        <ul>
                         <li class="active"><a href="{{route('user.show.cart.list')}}"><span class="digit">1</span> <span> Cart</span></a> </li>
                           <li  class="active"><span class="digit">2</span> <span> Address</span> </li>
                           <li><span class="digit">3</span> <span> Order Summary</span> </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading m-t-b-30">Select Delivery Address</h2>
                  </div>
                  <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                  </div>
               </div>
               <div class="flex-row b-top">
                  <div class="cart_left_col">


                  <div class="add_new_address">
                     <div class="apply_coupon">
                        <img src="{{asset('asset-user-web/images/add-address.svg')}}" alt="add-address"> Add New Delivery Address
                     </div>
                     <a href="{{route('user.add.new.delivery.address')}}"><button type="button" class="add-btn green-fill btn-effect">Add New</button></a>
                  </div>

                  <!--Address Card-->
                        @if($deliveryAddress)
                            @foreach($deliveryAddress as $val)
                                <div class="address_card m-t-30">
                                    <div class="inner_wrapper">
                                        <span class="delete_icon edit-remove-address" edit-remove-id="{{$val->id}}" data-toggle="modal" data-target="#myModal-delete-address">
                                      
                                            <img src="{{asset('asset-user-web/images/delete-bin-5-line.svg')}}">
                                        </span>  
                                       <span class="save_address_type {{$val['address_type']}}">{{$val['address_type']}}</span>
                                        <h3 class="candidate_name">{{$val['name']}}</h3>
                                        <div class="address">
                                            <p> {{$val->formatted_address}}</p>
                                        <p> {{$val->state}}, {{$val->country}},{{$val->zipcode ?? ''}}</p>
                                            <p>Mobile Number: {{$val->mobile}} </p>
                                            <p>House No: {{$val->address}} </p>
                                        </div>
                                    </div>
                                    <div class="addressAccordian-buttons">
                                    <div class="addressAccordian-button edit-address" data-edit-id="{{$val->id}}"> EDIT </div>
                                        <div class="addressAccordian-buttonDivider"></div>
                                        <div class="addressAccordian-button"><a href="{{route('user.select.delivery.location').'?address_id='.$val['id'].'&order_id='. $orderId}}">  Deliver Here </a> </div>
                                    </div>
                                </div>
                           @endforeach
                        @endif

                         <!--Address Card Close-->  


                        
                            {{-- <div class="text-center"><a href="{{route('user.add.new.delivery.address')}}">Add New Delivery Address</a></div> --}}
                         
                    
                    </div>
                  
                  
                <div class="cart_right_col">
                     <div class="item_detail">

                     

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



                        <div class="items m-t-30">
                        <label class="form_label">{{$items}} Items</label>

                            @if(!empty($summary))
                            @foreach($summary as $val)

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
                  {{-- <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label">Order Packing Charges</label>
                     </div>
                     <div class="flex-col-sm-2 text-right">
                        <label class="form_label">$3.05</label>
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label">Order Packing Charges</label>
                     </div>
                     <div class="flex-col-sm-2 text-right">
                        <label class="form_label">$3.05</label>
                     </div>
                  </div> --}}

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
               </div>


                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!--section list filter close-->




<div class="modal fade" id="edit-address" role="dialog">
   <div class="modal-dialog" id="edit_html_id">
      <!-- Modal content-->
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


<!--Edit Profile Close-->
<!--Delete Address Modal-->
<div class="modal fade" id="myModal-delete-address" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Address Delete</h4>
         </div>
         
         <form action="{{route('user.remove.address')}}" method="get">
         <div class="modal-body">
            <div class="modal-padding">
               <h1 class="confirm_heading"> Delete Confirmation</h1>
               <p class="commn_para">Are you sure want to delete this address ?</p>
               <div class="flex-row m-t-30">
                  <div class="flex-col-sm-12 mt-50 mobile-space">
                     <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes, Delete</button>
                     <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="id" id="hidden_remove_id">
         </form>

      </div>
   </div>
</div>
<input type="hidden" name="search_type" value="1">
@section('pagescript')
<script>

$("body").on('click','.address_type',function(){
   $('.address_type').each(function() {
      $(this).removeClass('active');
   })

   var type=$(this).data('text');
   $("input[name=address_type_val]").val(type);
   $(this).addClass('active');
})


 var EDIT_ADDRESS_INFO = 
   {

      __handle_edit_address: function(id, $this) {

         $.ajax({
            type: "get",

            url: "{{route('user.get.edit.form')}}",

            data: {
               id: id
            },

            beforeSend: function() {

               $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');

            },

            success: function(response) {
               $("#edit_html_id").html(response.html);
               $('#edit-address').modal('show');
            },
            error: function() {

               alert("Something went wrong. Please try again");
            },
            complete: function() {

               $this.html('EDIT');
            }

         });

      },


      __submit_edit_address_form: function(form) {

         $.ajax({
            type: "get",

            url: form.attr("action"),

            data: form.serialize(),

            success: function(response) {

             

            }

         });

      }
   }

   $('body').on('click', '.edit-address', function() {
      var id = $(this).attr('data-edit-id');
      var $this = $(this);
      EDIT_ADDRESS_INFO.__handle_edit_address(id, $this);

   });

   $("body").on('click','.edit-remove-address',function(){
      var id = $(this).attr('edit-remove-id');
      $("#hidden_remove_id").val(id);
   });

</script>
@endsection



@endsection