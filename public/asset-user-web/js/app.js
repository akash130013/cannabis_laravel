$('#banner-owl').owlCarousel({
    items: 1,
    loop: false,
    autoplay: false,
    dots:true,
    nav: true,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"]
});




$('#store-detail-owl').owlCarousel({
    items: 1,
    loop: false,
    autoplay: false,
    dots:true,
    nav: false,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"]
});


var showNav = $('#product-category-owl').find('.item').length > 5 ? true : false;

$('#product-category-owl').owlCarousel({
    items: 6,
    loop: false,
    autoplay: false,
    dots:true,
    nav: showNav,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/arrow-right-s-line.svg'"],
    responsive: {        
        0: {            
            items: 2,       
         },        
        600: {            
            items: 3,        
        },        
        1000: {
        items: 5,        
       }
    }
});



var showNavts = $('#trending-slider-owl').find('.item').length > 3 ? true : false;
$('#trending-slider-owl').owlCarousel({
    items: 3,
    loop: false,
    autoplay: false,
    dots:true,
    nav: showNavts,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"],
    responsive: {        
        0: {            
            items: 1,       
        }, 
        375: {
            items: 1, 
        },       
        600: {            
            items: 2,        
        },        
        1000: {
        items: 3,        
       }
    }
});



$('#nearby-slider-owl').owlCarousel({
    items: 2,
    loop: false,
    autoplay: false,
    dots:true,
    nav: true,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"],
    responsive: {        
        0: {            
            items: 1,       
         },        
        600: {            
            items: 1,        
        },        
        1024: {
        items: 1,        
       },
       1050: {
        items: 2,        
       }
    }
});



$('#trending-bycategory-owl').owlCarousel({
    items: 3,
    loop: false,
    autoplay: false,
    dots:true,
    nav: true,
    navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"],
    responsive: {        
        0: {            
            items: 2,       
        }, 
        375: {
            items: 1, 
        },         
        600: {            
            items: 2,        
        },        
        1000: {
        items: 3,        
       }
    }
});