/*** User Profile Dropdown ***/
$('.user-profile-info').click(function (e) {
    e.stopPropagation();
    if ($(this).hasClass('active')) {
        $('.user-profile-info').next('.account-dropdown').slideUp('fast');
        $('.user-profile-info').removeClass('active');
    } else {
        $('.user-profile-info').removeClass('active');
        $('.user-profile-info').next('.account-dropdown').slideUp('fast');
        $(this).addClass('active');
        $(this).next('.account-dropdown').slideDown('fast');
        $('.notifications-dropdown').slideUp('fast');
        $('.notify-icon').removeClass('active');
    }
});

$('html').click(function () {
    $('.user-profile-info').removeClass('active');
    $('.account-dropdown').slideUp('fast');
});

/*** Toggle Menu ***/
$('.toggle-btn-wrap').click(function () {
    $('aside').toggleClass('left-panel-show');
    $('.responsive-overlay').toggleClass('active');
    $('body').toggleClass('body-sm');
});

/*** Filter Js ***/
// $(".filter-icon").click(function(e) {
//     $(".filter-form-section").slideToggle("slow");
// });
// $(".applybutton").click(function(e) {
//     $(".filter-form-section").slideToggle("slow");
// });


// $(".add-more").click(function() {
//     var html = $(".copy").html();
//     // $(".after-add-more").append(html);
//     $(".after-add-more").append(html);
// });


var i = 1;
$(".add-more").click(function () {
    // var html = $(".copy").html();
    $("#loop_val").val(i);

    var html = ` <div class="form-group control-group">

 <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-3 pd-r-0">
    <div class="form-group quantity">
         <select name="qty[unit][`+ i + `]" id="unit_` + i + `" class="unit selectpicker">
              <option value="grams">Grams</option>
              <option value="milligrams">MilliGrams</option>
          </select>
    </div>
     </div>
     <div class="col-md-9 col-sm-9 col-xs-9 pd-r-0">
     <div class="input-group control-group">
        <input type="number" max="1000" maxlength="4" name="qty[quant_units][`+ i + `]" id="size_` + i + `" class="form-control qtyValidate" placeholder="Size" onkeypress="return isNumber(event)">
        <div class="input-group-btn"> 
            <button class="btn btn-danger remove" type="button">
                <i class="glyphicon glyphicon-minus"></i>
            </button>
        </div>
     </div>
     </div>

 <span id="qty[quant_units][`+ i + `]-error" style="display: none;" class="error">dffdfdfd</span>
 

</div>`;

    $(".after-add-more").append(html);
    i++;

    $('.qtyValidate').each(function (key, value) {
        // debugger;
        $(this).rules('add', {
            required: true,
        });

    });

    $('.selectpicker').selectpicker('refresh');
});


//====================

$("body").on("click", ".remove", function () {
    $(this).parents(".control-group").remove();
    i = i - 1;
});

var j = Number($("#lastNum").val());
$("body").on("click", ".add-more_edit", function () {


    var html = ` <div class="form-group control-group">
     
 <div class="row">
 <div class="col-md-3 col-sm-3 col-xs-3 pd-r-0">
      <div class="form-group quantity">
        <select name="qty[unit][`+ j + `]" class="unit selectpicker">
            <option value="grams">Grams</option>
            <option value="milligrams">MilliGrams</option>
        </select>
        </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-9 pd-r-0">
        <div class="input-group control-group">
            <input type="number" max="1000" maxlength="4" name="qty[quant_units][`+ j + `]" class="form-control qtyValidate" placeholder="Size" onkeypress="return isNumber(event)" required>
            <div class="input-group-btn"> 
                <button class="btn btn-danger remove" type="button">
                    <i class="glyphicon glyphicon-minus"></i>
                </button>
            </div>
       </div>
       </div>
    </div>
   </div>`;
    j++;

    $(".after-add-more").append(html);
    $('.selectpicker').selectpicker('refresh');
});




/******************* Filter *********************/
$("#filter").click(function (e) {
    e.stopPropagation();
    $(".filter-form-section").addClass("active");
    $("body").css({ overflow: "hidden" });
});

$(".close_filter").click(function () {
    $(".filter-form-section").removeClass("active");
    $("body").css({ overflow: "auto" });
});


$("body").click(function (event) {
    if (!$(event.target).is(".filter-form-section , .filter-form-section *")) {
        $(".filter-form-section").removeClass("active");
        $("body").css({ overflow: "auto" });
    }
});
/******************* Filter *********************/



$(".menu-line").click(function () {
    $("body").toggleClass("sidebar");
});