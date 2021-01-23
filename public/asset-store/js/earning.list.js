
/**
 * @search 
 */
$(document).ready(function(){
   
   
  $('.ui.search')
   .search({
   apiSettings: {
   url: 'earning-search?q={query}',
  },
  fields: {
   results : 'items',
   title   : 'title',
  },
  onSelect: function(result, response) {
       $("#searchElementProduct").val(result.title);
       $("#formFilterId").submit();
   }
  });
  
  
  });