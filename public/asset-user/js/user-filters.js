//*form filter data
$("body").on("click",'.all_filter',function(){
    var cid=$(this).data('cid');

    if(cid!='' && cid!=null && cid!=undefined){
      $('.category_id_'+cid).prop('checked', false); // Unchecks it
    }
  $("#filterFormId").submit();

});

  //*filter sort by
     $("body").on("click",'.all_filter_sort',function(){
      var num=$(this).data('num');
      $('.check_'+num).prop('checked',true);    
       $("#filterFormId").submit(); 
   });


//*form filter data for store
$("body").on("click",'.all_filter_store',function(){
    var sid=$(this).data('sid');
         
    if(sid!='' && sid!=null && sid!=undefined){
      $('.store_id_'+sid).prop('checked', false); // Unchecks it
    }

    // console.log(sid);
    

  $("#filterFormId").submit();

});



$(document).ready(function(){
  
  $("#list_navigation_full_filter").listnav({
      includeNums: false,
  });

  $("#list_navigation_full_filter_store").listnav({
      includeNums: false,
  });

});

///for category
$('body').on('keyup','#full_filter_search',function(){

var searchString = $(this).val();
var eleID = $(this).attr('data-id');

$("#"+ eleID + " li").each(function(index, value) {
 currentName = $(value).text()
 if( currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
    $(value).show();
 } else {
     $(value).hide();
 }
 
});


});

//for the store
$('body').on('keyup','#full_filter_search_store',function(){

var searchString = $(this).val();
var eleID = $(this).attr('data-id');

$("#"+ eleID + " li").each(function(index, value) {
 currentName = $(value).text()
 if( currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
    $(value).show();
 } else {
     $(value).hide();
 }
 
});


});


$('body').on('keyup','.product-search',function(){
var searchString = $(this).val();
var eleID = $(this).attr('data-id');

$("#"+ eleID + " li").each(function(index, value) {
    currentName = $(value).text()
    if( currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
       $(value).show();
    } else {
        $(value).hide();
    }
});
});

