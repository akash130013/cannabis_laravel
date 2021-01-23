<form  id="second_step_form">
               <div class="">
                     <figure class="bottom_img"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
                     
                     <div class="container_header">
                        <h2 class="title-heading">Update New Offer</h2>
                        <div class="counter"><span>2</span>/3</div>
                     </div>
                     <span class="progress_bar">
                           <span class="pro-ruller" style="width: 75%;"></span>
                        </span>
                        <div class="inner_container">
                           <div class="divappend">

                            @if($productStock)

                                @foreach($productStock as $val)
                              <div class="form_wrapper">
                                 <div class="form-group quantity-input-field">
                                    <div class="text-field-wrapper">
                                       <div class="detect-icon detect-icon-lt">
                                          <select class="select_drop select_option_offer">
                                             <option selected="selected" data-id = "{{$val->id}}" data-unit="{{$val->unit}}" value="{{$val->quant_unit}}">{{$val->quant_unit}} {{$val->unit}}</option>
                                          </select>
                                          <img src="{{asset('asset-store/images/droparrow-w.svg')}}" class="dropmenu" alt="drop down menu" />
                                       </div>
                                       <input type="hidden" name="stockUnitId[]"  value="{{$val->id}}" class="add-product-stock-unit" >
                                       <input type="hidden" name="price[]" value="{{$val->actual_price}}" class="add-product" >
                                       <p name="price[]" disabled onkeypress="validate(event)" value="{{$val->actual_price}}" placeholder="Last actual price set is :" class="form-control pl-230" >{{$val->actual_price}}</p>
                                    
                                    </div> 
                                 </div>
                                 <div class="form-group">
                                    <div class="text-field-wrapper">
                                       <input type="text" name="offerprice[]" onkeypress="validate(event)" value="{{$val->timely_offered_price}}" class="form-control offered-price" actual_price="{{$val->actual_price}}">
                                    </div>
                                 </div>
                              </div>
                              @endforeach

                            @endif


                           </div>
                           <!-- <a href="javascript:void(0)" class="txt-add-more" id="add-more">Add More</a> -->
                           <div class="next-btn">
                              <button type="button" class="primary_btn green-fill outline-btn back2">Back</button>
                              <button type="button" class="primary_btn green-fill nextbtn-2" id="show_preview_data">Next</button>
                           </div>
                        </div>
                </div>
</form>
            