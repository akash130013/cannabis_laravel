<div id="review_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog">
      <!-- step 1 -->
      <form>
      <div class="modal-content step1">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img
                  src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="title-heading">Rate Your Experience</h4>
         </div>
         <div class="modal-body">
            <div class="progressCounter">
               <ul class="bullet">
                  <li class="active"></li>
                  <li></li>
                  <li></li>
                  <li></li>
               </ul>
               <div class="counter"><span>1</span>/4</div>
            </div>
            
          <div id="product_display">
             
          </div>

                 <div class="flex-row">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <a href="javascript:void(0)"><span class="custom-btn green-fill btn-effect" id="next_step2">Next</span></a>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" id="skip_product">Skip</a>
                     </div>
                 </div>
         
         </div>
      </div>
      <!-- step 1 -->
   </form>

   <form>
      <!-- step 2 -->
      <div class="modal-content step2">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img
                  src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="title-heading">Rate Your Experience</h4>
         </div>
         <div class="modal-body">
            <div class="progressCounter">
               <ul class="bullet">
                  <li></li>
                  <li class="active"></li>
                  <li></li>
                  <li></li>
               </ul>
               <div class="counter"><span>2</span>/4</div>
            </div>

            <div id="store_model_div">

            
            </div>

            <div class="flex-row">
               <div class="flex-col-sm-12 mt-50 mobile-space">
                     <a href="javascript:void(0)"><span type="button" class="custom-btn green-fill btn-effect" id="next_step3">Next</span></a>
                  <a class="ch-shd back line_effect" href="javascript:void(0)" id="skip_store">Skip</a>
               </div>
            </div>
         </div>
      </div>
      <!-- step 2 -->
   </form>


   <form>
      <!-- step 3 -->
      <div class="modal-content step3">
         <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal"><img
                  src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
            <h4 class="title-heading">Rate Your Experience</h4>
         </div>
         <div class="modal-body">
            <div class="progressCounter">
               <ul class="bullet">
                  <li></li>
                  <li></li>
                  <li class="active"></li>
                  <li></li>
               </ul>
               <div class="counter"><span>3</span>/4</div>
            </div>

            <div id="driver_model_div">
 
            </div>

            <div class="flex-row">
               <div class="flex-col-sm-12 mt-50 mobile-space">
                     <a href="javascript:void(0)"><span type="button" class="custom-btn green-fill btn-effect" id="next_step4">Submit</span></a>
                  <a class="ch-shd back line_effect" href="javascript:void(0)" id="skip_driver">Skip</a>
               </div>
            </div>
         </div>
      </div>
  
      <!-- step 3 -->
   </form>

      <!-- step 4 -->
      <form>
      <div class="modal-content step4">
         <div class="modal-header">
            <button type="button" class="modal-close" onclick="location.reload()">
               <img src="{{asset('asset-user-web/images/close-card.svg')}}">
            </button>
                  
            <h4 class="title-heading">Review Product</h4>
         </div>
         <div class="modal-body">
            <div class="progressCounter">
               <ul class="bullet">
                  <li></li>
                  <li></li>
                  <li></li>
                  <li class="active"></li>
               </ul>
               <div class="counter"><span>4</span>/4</div>
            </div>

            <div class="flex-row mtb20">
               <div class="flex-col-sm-12 text-center">
                  <figure>
                     <img src="{{asset('asset-user-web/images/leaf-response.png')}}" alt="leaf" />
                  </figure>
                  <p class="txt_response_msg">Your response has been successfully rolled and
                     saved with Us. Happy to service you</p>
               </div>
            </div>
         </div>
         <div class="review_modal_footer">
            <div class="flex-row">
               <div class="flex-col-sm-6">
                  <label>Review Your Purchases</label>
                  <label class="review_purchase" id="final_rating"></label>
               </div>
               <div class="flex-col-sm-6 mt-50 mobile-space text-right">
               <a href="{{route('users.dashboard')}}"><button type="button" class="custom-btn green-fill btn-effect btn-sm">Continue Shopping</button></a> 
               </div>
            </div>
         </div>
      </div>
   </form>
      <!-- step 4 -->
   </div>
</div>