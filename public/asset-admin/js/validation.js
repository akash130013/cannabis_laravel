function validateFields(elements, pattern) {
	var error = new Array(),
		value;
	for (index in elements) {
		//throw exception in case of undefined value
		if (typeof $("#" + elements[index]).val() === "undefined") {
			throw {
				message: "element with " + elements[index] + " does not exists",
				name: "undefined element Id"
			}
		}

		if (elements[index].match("password")) {
			value = $("#" + elements[index]).val()
		} else {
			value = $("#" + elements[index]).val().trim();
		}

		if (value.toString().match(pattern[index])) {
			error.push("true");
		} else {
			error.push("false");
		}
	}
	return error;
}

function getAge(dateString) {
	var today = new Date();
	var birthDate = new Date(dateString);
	var age = today.getFullYear() - birthDate.getFullYear();
	var month = today.getMonth() - birthDate.getMonth();
	var date = today.getDate() - birthDate.getDate();
	if (month < 0 || (month === 0 && date < 0)) {
		age--;
	}
	return age;
}
/* validation function begin */
function validateEmail(email) {

	if (email.toString().match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {

        return true;
	} else {
        
		return false;
	}
}

function validateName(name) {
	if (name.toString().match(/^[a-zA-Z\s]+[^<>()\[\]\\.,;:\s@"]+$/)) {
		return true;
	} else {
		return false;
	}
}

function validatePassword(password) {
	if (password.toString().match(/^[\w\W]{6,}$/)) {
		return true;
	} else {
		return false;
	}
}

function validateMobileNumber(mobile) {
	if (mobile.toString().match("^\\d{10}$")) {
		return true;
	} else {
		return false;
	}
}

function validateTelephoneNumber(telephone) {
	if (telephone.toString().match("^\\d{10}$")) {
		return true;
	} else {
		return false;
	}
}

function validatePincode(pincode) {
	if (pincode.toString().match("^\\d{5,10}$")) {
		return true;
	} else {
		return false;
	}
}

function validateAddress(address){
	if (address.length > 5) {
		return true;
	} else {
		return false;
	}
}

function onBlurChecks($element, valid /* true or false */ , $statusElement, errorMessage) {
	if (valid) {
		$element.css({
			border: "1px solid #d7f1f7"
		});
		$statusElement.html("success");
		$statusElement.css({
			color: "green"
		});
	} else {
		$element.css({
			border: "solid 2px indianred"
		});
		$statusElement.html(errorMessage);
		$statusElement.css({
			color: "indianred"
		});
	}
}


