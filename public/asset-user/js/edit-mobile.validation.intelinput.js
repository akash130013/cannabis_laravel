
    var input = document.querySelector("#phone-edit"),
    errorMsg = document.querySelector("#error-msg-edit"),
    validMsg = document.querySelector("#valid-msg-edit");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Please enter valid mobile number", "Invalid country code", "Mobile number length is too short", "Mobile number length is too long", "Please enter valid mobile number"];

// initialise plugin
var iti = window.intlTelInput(input, {
    hiddenInput: "contact_number_edit",
    utilsScript: "{{asset('asset-store/js/intl-tel-input-master/src/js/utils.js')}}",
    onlyCountries : ["us"],
    preferredCountries : ["us"],
    allowDropdown : false,
});

var reset = function() {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
    reset();
    if (input.value.trim()) {
        if (iti.isValidNumber()) {
            validMsg.classList.remove("hide");
            
        } else {
            input.classList.add("error");
            // validMsg.css('display','block');
            // $('#error-msg-edit').css('display','block');
            var errorCode = iti.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
        }
    }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);


