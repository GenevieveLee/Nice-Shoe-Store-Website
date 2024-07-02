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

//originalPrice
const originalPrice = parseFloat(total.innerHTML.slice(3));

// apply coupon
function applyCoupon() {
  const couponCode = document.getElementById("couponCode").value;
  const data = "couponCode=" + couponCode;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "applyCoupon.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          alert("Coupon is applied successfully.");
          const total = document.getElementById("total");
          const discountPercentage = parseFloat(response.message);
          const newTotal = (1 - discountPercentage / 100) * originalPrice; // Adjust the total with discount
          total.innerHTML = "RM " + newTotal.toFixed(2);
        } else {
          alert("Failed to apply coupon. " + response.message); // Display the error message
        }
      } else {
        alert("Error: " + xhr.status); // Handle non-200 status
      }
    }
  };
  xhr.send(data);
}
const couponButton = document.getElementById("couponButton");
couponButton.addEventListener("click", applyCoupon);

function removeCoupon() {
  const data = "couponCode=removeCoupon";
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "removeCoupon.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          const total = document.getElementById("total");
          total.innerHTML = "RM " + originalPrice.toFixed(2);
          alert("Coupon is remove successfully.");
        } else {
          alert("Failed to apply coupon. " + response.message); // Display the error message
        }
      } else {
        alert("Error: " + xhr.status); // Handle non-200 status
      }
    }
  };
  xhr.send(data);
}
const removeCouponButton = document.getElementById("removeCouponButton");
removeCouponButton.addEventListener("click", removeCoupon);

function placeOrder() {
  const paymentMethodRadios = document.getElementsByName("paymentMethod");
  var paymentMethod;
  var selected = false;
  for (let i = 0; i < paymentMethodRadios.length; i++) {
    if (paymentMethodRadios[i].checked) {
      paymentMethod = paymentMethodRadios[i].id;
      selected = true;
      break;
    }
  }

  if (selected) {
    const name = document.getElementById("name");
    const companyname = document.getElementById("companyname");
    const streetaddress = document.getElementById("streetaddress");
    const apartmentunit = document.getElementById("apartmentunit");
    const towncity = document.getElementById("towncity");
    const phonenumber = document.getElementById("phonenumber");
    const email = document.getElementById("email");
    const total = document.getElementById("total");
    const inputs = [
      name,
      companyname,
      streetaddress,
      apartmentunit,
      towncity,
      phonenumber,
      email,
      total,
    ];

    var data = "paymentmethod=" + paymentMethod;
    inputs.forEach((element) => {
      if (element.id == "total") total.value = total.innerHTML.slice(3);
      if (element.value != "") data += "&" + element.id + "=" + element.value;
    });

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "placeOrder.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert("The order is place successfully.");
            window.location.href = "http://localhost/Nicee/index.php";
          }
        }
      }
    };
    xhr.send(data);
  } else {
    alert("Please select a payment method before placing order.");
  }
}

const placeOrderButton = document.getElementById("paymentButton");
placeOrderButton.addEventListener("click", placeOrder);
