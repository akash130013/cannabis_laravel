<!-- Product Search -->
<div class="main_wrapper">
   <div class="product-search">
      <div class="search-box">
         <!--search-->
         <div class="text-field-wrapper pro-srchbox">
            <input type="text" placeholder="Search Products, Stores & Category" onkeyup="global_search($(this).val(),1,0)" id="global_search_input">
            <span class="detect-icon" id="default_global_search"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>
            <span id="search_spinner" class="detect-icon"></span>
         </div>
         <!--search close-->
         <div>
            <figure>
               <img src="{{asset('asset-user-web/images/close-card.svg')}}" class="close-icon" />
            </figure>
            <label class="txt-close">CLOSE</label>
         </div>
      </div>
      <div class="head-nav tab_wrapper">
         <ul>
            <li><a href="javascript:void(0)" id="suggest_product">Products</a></li>
            <li><a href="javascript:void(0)" id="suggest_store">Stores</a></li>
            <li><a href="javascript:void(0)" id="suggest_category">Category</a></li>
         </ul>
      </div>
      <div class="suggestions-wrapper">
         <label id="suggest_label"></label>
         <ul class="suggestions-list" id="suggestion_list">
         </ul>
         <div class="text-center">  
            <button class="show-more-button btn-effect green-fill btn-sm" type="button" data-text="" data-page="1" style="display:none">Show More</button>
         </div>
      </div>
   </div>
</div>
<!-- Product Search -->