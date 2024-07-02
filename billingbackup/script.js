function emailValidation(email) {
  var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return emailPattern.test(email);
}

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("paymentButton")
    .addEventListener("click", function (event) {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Call the form validation function
      if (ValidateBillingForm()) {
        // If validation succeeds, submit the form
        document.getElementById("billingForm").submit();
      }
    });
});

function ValidateBillingForm() {
  var name = document.getElementById("name").value;
  var streetaddress = document.getElementById("streetaddress").value;
  var towncity = document.getElementById("towncity").value;
  var phonenumber = document.getElementById("phonenumber").value;
  var email = document.getElementById("email").value;

  var nameError = document.getElementById("nameError");
  var streetaddressError = document.getElementById("streetaddressError");
  var towncityError = document.getElementById("towncityError");
  var phonenumberError = document.getElementById("phonenumberError");
  var emailError = document.getElementById("emailError");

  nameError.innerHTML = "";
  streetaddressError.innerHTML = "";
  towncityError.innerHTML = "";
  phonenumberError.innerHTML = "";
  emailError.innerHTML = "";

  if (name.trim() === "") {
    nameError.innerHTML = "Full Name is required";
    document.getElementById("name").focus();
    return false;
  }

  if (streetaddress.trim() === "") {
    streetaddressError.innerHTML = "Street Address is required";
    document.getElementById("streetaddress").focus();
    return false;
  }

  if (towncity.trim() === "") {
    towncityError.innerHTML = "Town/City is required";
    document.getElementById("towncity").focus();
    return false;
  }

  if (phonenumber.trim() === "") {
    phonenumberError.innerHTML = "Phone Number is required";
    document.getElementById("phonenumber").focus();
    return false;
  } else if (!/^\d{10,11}$/.test(phonenumber.trim())) {
    phonenumberError.innerHTML = "Phone Number must be 10 or 11 digits";
    document.getElementById("phonenumber").focus();
    return false;
  }

  if (email.trim() === "") {
    emailError.innerHTML = "Email is required";
    document.getElementById("email").focus();
    return false;
  } else if (!emailValidation(email)) {
    emailError.innerHTML = "Invalid email format";
    document.getElementById("email").focus();
    return false;
  }

  return true;
}
