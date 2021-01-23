$('.productDetailWrapper').slideUp();
$('.editproductdetailwrapper').slideUp();

$('.cross').hide();
$('.searchproduct').on('focus', function() {
    $('.cross').show();
})
$('.searchproduct').on('focusout', function() {
    $('.cross').hide();
})
$('.cross').on('click', function() {
    $('.searchproduct').text();
})
$('.filter-directory').hide();
$('.see-more').on('click', function() {
    $('.filter-directory').show();
})

// category-filter
$('.category-filter-more').hide();
$('.see-more').on('click', function() {
    // console.log($(this).text());
    if($(this).text()=='Show More'){
       
    $('.category-filter-more').wrapAll('<div class="loadmoredata">');
    $('.loadmoredata').show();
    $('.category-filter-more').show();
    $('.see-more').text('Show Less'); 
    $("#status").val("2");
    }else{
       
        $('.category-filter-more').unwrap('<div class="loadmoredata">').hide();
         $('.category-filter-more').hide();
        $('.see-more').text('Show More');
        $("#status").val("1");
    }
   
})

$('.FileDirectory-close').on('click', function() {
    $('.filter-directory').hide();
});

$('.searchMenu').on('click', function() {
    $(this).addClass('active');
    $(this).siblings('h6').addClass('active');
    $('.search').addClass('active');
    setFocusToTextBox();
    // $(".form-group.search ").focus();
});
function setFocusToTextBox(){
    document.forms['filterName'].elements['product-search'].focus();
}
$('.availability .form-group.search img').on('click', function() {
    $(this).parent().siblings('h6').removeClass('active');
    $('.search,.searchMenu').removeClass('active');
    $(this).siblings('input').val('');
})
$('.FilterDirectory-indices li a').on('click', function(e) {
    if ($(this).parent().hasClass('FilterDirectory-disabled')) {
        e.preventDefault();
    } else {
        let item = $(this).attr('href');
        // console.log($('.FilterDirectory-list').scrollLeft() + $(item).offset().left);
        let value = $('.FilterDirectory-list').scrollLeft() + $(item).offset().left;
        let totaloffset = value - 55;
        $('.FilterDirectory-list').animate({
            scrollLeft: totaloffset
        }, 2000);
    }
})
$(document).mouseup(function(e) {
    var popup = $(".filter-directory");
    if (!$('.see-more').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
        popup.hide();
    }
});
$('.productListBodyWrapper table td img').on('click', function() {
    $('.infoData').removeClass('active');
    let $attr = $(this).attr('data-target').split('#')[1];
    let dynamic_id=$(this).data('dy_id');
    let data_id = $('.infoWrapper_'+dynamic_id).attr('id')
    if ($attr) {
        // console.log($attr,data_id,dynamic_id);
        
        if ($attr === data_id) {
            $('#' + data_id).addClass('active');
        }
    }
})
$(document).mouseup(function(e) {
    var popup = $(".infoData");
    if (!$('.productListBodyWrapper table td img').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
        popup.removeClass('active');
    }
});
$('.remindlater').on('click',function(){
    $(this).parent().slideUp();
})
$('.closeProductMenu').on('click',function(){
    $(this).siblings('input').val('');

    $("input[name=search]").val('');
    $("#formFilterId").submit();
})
// $('.closeProductMenu').hide();
$(document).ready(function(){
    var closevalue = $('.productListHdr .form-group input').val();
    if($('.productListHdr .form-group input').val() == '' ){
        $('.closeProductMenu').hide();
    }
else{
    $('.closeProductMenu').show();
    }
})


$('.productListHdr .form-group input').on('focus',function(){
    $(this).siblings('.closeProductMenu').show();
})
$('.productListHdr .form-group input').on('focus',function(){
    $(this).siblings('.closeProductMenu').show();
})

$(document).mouseup(function(e) {
    var popup = $(".closeProductMenu");
    if (!$('.productListHdr .form-group input').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
        popup.hide('');
    }
});

$(document).mouseup(function(e) {
    var popup = $(".form-group.search");
    if (!$('.productListHdr .form-group input').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
        popup.removeClass('active'); 
        $(this).find('.searchMenu').removeClass('active');
        $(this).find('h6').removeClass('active');
        popup.hide('');
    }
});
$(".checkFilter").on('change',function(){
    $("#formFilterId").submit();
})

$(".catDiv").click(function(){

    var text=$(this).text();
    var totalCat=$("#totalCat").val();

if (text=='Show Less') {
    for (let index = 6; index <= totalCat; index++) {
        $(`#catDiv_`+index+``).hide();
        $(this).text('Show More'); 
    }
    $("#status").val("1");
} else {
    for (let index = 1; index <= totalCat; index++) {
        $(`#catDiv_`+index+``).show();
        $(this).text('Show Less');
    }
    $("#status").val("2");
}

  
})

initializeListSearch({
itemSelector: '.collection-item',
cssActiveClass: 'active',
openLinkWithEnterKey: false,
searchTextBoxSelector: '#search-box',
noItemsFoundSelector: '.no-apps-found',
});

