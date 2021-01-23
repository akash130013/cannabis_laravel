
            $(".activeInactiveBtn").click(function(){
                  var newText=$(this).text();
                  var id=$(this).data('id');
                  
                  $("#newStatus").val(newText);
                  $("#Id").val(id);
                  $("#type").val('product');

                  if(newText=='Active'){
                    $(".blockUnblockBtn").text("Block");
                    $("#paraText").text("Are you sure want to block this product ?")
                  }else{
                    $(".blockUnblockBtn").text("Activate");
                    $("#paraText").text("Are you sure want to Activate this product ?")

                  }
                  $('#activeInactiveModal').modal('show');
            })

            $(".blockUnblockBtn").click(function(){
                  var Status=$("#newStatus").val();
                  var id=$("#Id").val();
                  var type=$("#type").val();
                  var newStatus='';
                   if (Status=='Active') {
                       newStatus='blocked';
                   }else{
                      newStatus='active';
                   }
                    changeDataStatus(id,newStatus,type);
            })


     function changeDataStatus(id,newStatus,type) {
       
        var url=$("#url").val();
         var pageUrl=$("#pageUrl").val();
        var data = {
            "id": id,
            "toChange": newStatus,
            'type':type,
            'url':pageUrl,
        };

        $.ajax({
            method: "GET",
            url:  url,
            data: data,
            success: function (res) {
                if(res.CODE==200){
                    // window.location.href='product-listing';  
                    window.location.href=res.url;  

                }else{
                    alert("Someting went wrong.. Please try again");
                }
            }
        });
            }
