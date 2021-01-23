@if(Auth::guard('store')->user()->admin_action == config('constants.STATUS.PENDING'))
<div class="alert text-center">
   <!-- <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>           -->
   <button type="button" onclick="this.parentElement.style.display='none';" class="close modal-close trash-ico">
        <img src="/asset-store/images/close.svg">
   </button>   
   <p> <strong>Pending Verification !!</strong> Your Store will be visible to the customers once your account is verified.     </p>
</div>
@endif
<style>
   .close{
   opacity: 1;
   }
   .alert{
   background-color: #f8985d;
   color: #fff;
   display: flex;
   align-items: center;
   justify-content: space-around;
   flex-direction: row-reverse;
   font-size: 14px;
   position: relative;
   }
   .alert p{
   margin: 0 !important;
   }
   .alert-success {
   color: #3c763d !important;
   background-color: #dff0d8 !important;
   border-color: #d6e9c6 !important;
   flex-flow: initial;
   }
   .alert-success strong{
   margin:0;
   }
   .requested_product .alert{
      width: 1260px;
       margin: 0 auto;
   }
</style>