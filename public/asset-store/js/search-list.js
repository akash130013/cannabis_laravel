$('.ui.search')
  .search({
    apiSettings: {
      url: $("input[name=searchUrl]").val()+'?q={query}&type='+$("input[name=type]").val(),
    },
    fields: {
      results : 'items',
      title   : 'name',
    },
    minCharacters : 1,
    onSelect: function(result, response) {
       
        $("#searchElementProduct").val(result.name);
        $("#list-form").submit();
    }
  }) 
;

$('#resetButton').on('click',function()
{
  var orderType = $('#orderType').val();
  $('#status').val('');
  $('.startDate').val('');
  $('.endDate').val('');
  $("#filtered-order-list").submit();
  
})
