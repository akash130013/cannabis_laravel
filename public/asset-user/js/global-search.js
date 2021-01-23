
/**
 * @desc used for the global search
 */
//for the product =>1,
//for the store =>2,
//for the category =>3,

function global_search(search, page, status) {
    // console.log(search,page,status);
    var search_type = $("input[name=search_type]").val();
    if ('' == search) {
        $('#suggest_label').html('Suggested');
    }
    else {
        $('#suggest_label').html('');
    }



    var lat = $("#global_search_lat").val();
    var lng = $("#global_search_lng").val();


    $.ajax({
        type: "get",
        url: $("#global_search").val(),
        data: {
            "search_type": search_type,
            "search": search,
            "lat": lat,
            "lng": lng,
            "page": page,
        },
        cache: false,
        beforeSend: function () {
            $("#default_global_search").hide();
            $("#search_spinner").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
        },
        dataType: 'json',
        success: function (response) {
            if (parseInt(response.code) == 200) {
                //  console.log(status);

                if (status == 0) {
                    $("#suggestion_list").html("");
                }

                $("#suggest_product").removeClass('active');
                $("#suggest_store").removeClass('active');
                $("#suggest_category").removeClass('active');
                //    console.log(response.data);
                //FOR THE PRODUCT
                if (search_type == 1) {
                    $("#suggest_product").addClass('active');
                    if ((response.data.data).length > 0) {

                        response.data.data.forEach(element => {


                            $("#suggestion_list").append(`
                              <li>
                              <a class="goToDetail" data-type-id="`+ element.product_id + `" data-type="1" data-href="/user/product/detail/` + element.encrypted_product_id + `" target="_blank">
                                 <figure class="global_srch_psc">
                                     <img src="`+ element.product_image + `" onerror="imgProductError(this);">
                                 </figure>
                             
                                 <div class="details">`+ element.product_name + `
                                     <span>`+ element.category_name + `</span>
                                 </div>
                             </a>    
                              </li>`
                            );
                        });

                        /**pagination for product */
                        $('.show-more-button').data('page', response.data.nextPage);
                        $('.show-more-button').data('text', search);
                        if (response.data.nextPage == '') {
                            $('.show-more-button').hide();
                        } else {
                            $('.show-more-button').show();
                        }
                        /**end product pagination */

                    } else {
                        $("#suggestion_list").append(`
                         <li>
                         <figure class="not_found "><img src="/asset-user-web/images/homeproduct_ph.svg" alt="category">
                              <div class="text-center">
                                  Product not found
                             </div>
                         </figure>
                         
                         </li>
                         `)

                        $('.show-more-button').hide();
                    }
                }

                //FOR THE STRORE
                if (search_type == 2) {
                    $("#suggest_store").addClass('active');

                    if ((response.data.data).length > 0) {




                        response.data.data.forEach(element => {
                            $("#suggestion_list").append(`
                       <li>
                       <a class="goToDetail" data-type-id="`+ element.store_id + `" data-type="2" data-href="/user/store/detail/` + element.encrypted_store_id + `" target="_blank">
                              <figure class="global_srch_psc">
                                   <img src="`+ element.store_images[0] + `" onerror="imgStoreError(this);">
                              </figure>
                      
                         <div class="details">`+ element.store_name + `
                          <span>`+ element.address + `</span>
                          </div>
                       </a>
                       </li>`
                            );

                        });

                        /**pagination for store */
                        $('.show-more-button').data('page', response.data.nextPage);
                        $('.show-more-button').data('text', search);
                        if (response.data.nextPage == '') {
                            $('.show-more-button').hide();
                        } else {
                            $('.show-more-button').show();
                        }
                        /**end pagination */


                    } else {
                        $('.show-more-button').hide();

                        $("#suggestion_list").append(`
                  <li>
                  <figure class="not_found "><img src="/asset-user-web/images/homeshop_ph.svg" alt="category">
                         <div class="text-center">
                            Store not found
                        </div>
                  </figure>
                  </li>
                  `)
                    }
                }
                //FOR THE CATEGORY
                if (search_type == 3) {
                    $("#suggest_category").addClass('active');
                    if ((response.data.data).length > 0) {
                        response.data.data.forEach(element => {


                            $("#suggestion_list").append(`
             <li>
             <a class="goToDetail" data-type-id="`+ element.id + `" data-type="1" data-href="/user/category/product/` + element.encrypted_id + `">   
             <figure class="global_srch_psc">
                       <img src="`+ element.thumb_url + `" alt="category" onerror="imgProductError(this);">
                   </figure>
             
          
                    <div class="details">`+ element.category_name + `
                    <span>`+ element.product_count + ` Products</span>
                    </div>
            </a>
             </li>`

                            );
                        });

                        /**pagination for the category */
                        $('.show-more-button').data('page', response.data.nextPage);
                        $('.show-more-button').data('text', search);
                        if (response.data.nextPage == '') {
                            $('.show-more-button').hide();
                        } else {
                            $('.show-more-button').show();
                        }
                        /**end pagination */


                    } else {
                        $("#suggestion_list").append(`
             <li>
             <figure class="not_found "><img src="/asset-user-web/images/homeproduct_ph.svg" alt="category">
                      <div class="text-center">
                            Category not found
                        </div>
             </figure>
             </li>
             `)

                        $('.show-more-button').hide();
                    }

                }


            } else {
                $("#error-msg").text(response.messages);
            }
        },
        error: function () {
            alert('Something went wrong.. Please try again');
        },
        complete: function () {

            $("#search_spinner").html('');
            $("#default_global_search").show();
        }
    });

}

$(document).on('click', '.show-more-button', function () {
    var search = $(this).data('text');
    var page = $(this).data('page');
    global_search(search, page, 1);
})






$("body").on('click', '#suggest_product', function () {
    $("input[name=search_type]").val("1");

    global_search($("#global_search_input").val(), 1, 0);
})

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("body").on('click', '.goToDetail', function () {
    re_route_url = $(this).attr('data-href');
    lat = $("#global_search_lat").val();
    lng = $("#global_search_lng").val();
    search = $("#global_search_input").val();
    $this = $(this);


    data = {
        "term": search,
        "searched_type": $(this).attr('data-type'),
        "searched_id": $(this).attr('data-type-id'),
        "longitude": lng,
        "latitude": lat
    }
    $.ajax({
        type: "post",

        url: "/user/save-recent-search",

        data: data,

        beforeSend: function () {
            $("#default_global_search").hide();
            $("#search_spinner").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
        },

        success: function (response) {
        },
        error: function () {

            alert("Something went wrong. Please try again");
        }

    });
    window.location.href = re_route_url;

    // }
    // else{
    //     window.location.href = re_route_url;    
    // }


})




$("body").on('click', '#suggest_store', function () {
    $("input[name=search_type]").val("2");
    global_search($("#global_search_input").val(), 1, 0);


})

$("body").on('click', '#suggest_category', function () {
    $("input[name=search_type]").val("3");
    global_search($("#global_search_input").val(), 1, 0);
})


// <figure class="not_found"><img src="`+element.thumb_url+`" alt="category"></figure>
// <figure class="not_found"><img src="/asset-user-web/images/leaf.png" alt="category"></figure>
// <img src="/asset-store/images/product-box.png">






