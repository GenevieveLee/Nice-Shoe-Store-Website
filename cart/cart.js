document.getElementById("returnShop").addEventListener("click", function () {
  window.location.href = "http://localhost/Nicee/items";
});

function decrement(variantID) {
  const quantity = document.getElementById("variant" + variantID);
  const currentValue = parseInt(quantity.value);
  if (currentValue > 0) {
    quantity.value = currentValue - 1;
  }
}

function updateCartItemQuantity(CartItemID, newQuantity) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "updateItem.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          getItems();
          updateSubtotal();
        } else {
          alert("Failed");
        }
      }
    }
  };
  xhr.send("CartItemID=" + CartItemID + "&newQuantity=" + newQuantity);
}

function getItems() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("cartItems").innerHTML = this.responseText;
      const checkboxes = Array.from(
        document.getElementsByClassName("selectedCheckBox")
      );
      checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
          updateSubtotal();
        });
      });
    }
  };
  xmlhttp.open("GET", "getItems.php", true);
  xmlhttp.send();
}

// Load images when the page is loaded
window.onload = function () {
  getItems();
};

function increment(CartItemID, price) {
  var quantity = document.getElementById("CartItem" + CartItemID);
  var subtotal = document.getElementById("subtotal" + CartItemID);
  var currentValue = parseInt(quantity.value);
  if (currentValue < parseInt(quantity.max)) {
    quantity.value = currentValue + 1;
    var subtotalValue = (parseFloat(price) * quantity.value).toFixed(2);
    subtotal.innerHTML = "RM " + subtotalValue;
    updateCartItemQuantity(CartItemID, currentValue + 1);
  }
}

function decrement(CartItemID, price) {
  var quantity = document.getElementById("CartItem" + CartItemID);
  var subtotal = document.getElementById("subtotal" + CartItemID);
  var currentValue = parseInt(quantity.value);
  if (currentValue > 1) {
    quantity.value = currentValue - 1;
    var subtotalValue = (parseFloat(price) * quantity.value).toFixed(2);
    subtotal.innerHTML = "RM " + subtotalValue;
    updateCartItemQuantity(CartItemID, currentValue - 1);
  }
}

function deleteItem(cartItemID) {
  var deletedRow = document.getElementById("cartItem_" + cartItemID);
  if (deletedRow) {
    deletedRow.parentNode.removeChild(deletedRow);
  }
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "deleteItem.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        getItems();
        updateSubtotal();
      }
    }
  };
  xhr.send("cartItemID=" + cartItemID); // Send the cartItemID parameter
}
function applyCoupon() {
  document.getElementById("couponPopUp").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function closePopUp() {
  document.getElementById("couponPopUp").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function updateSubtotal() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  var ttlSubtotal = 0;
  var anyChecked = false;
  checkboxes.forEach(function (checkbox) {
    if (checkbox.checked) {
      anyChecked = true;
      var row = checkbox.closest("tr");
      var subtotal = parseFloat(row.cells[6].innerText.replace("RM", ""));

      ttlSubtotal += subtotal;
    }
  });
  var shipFee = anyChecked && ttlSubtotal < 100 ? 5 : 0;
  document.getElementById("subtotal").innerText = "RM" + ttlSubtotal.toFixed(2);
  document.getElementById("shipFee").innerText = "RM" + shipFee.toFixed(2);

  var total = ttlSubtotal + shipFee;
  document.getElementById("total").innerText = "RM" + total.toFixed(2);
}
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
checkboxes.forEach(function (checkbox) {
  checkbox.addEventListener("change", updateSubtotal);
});

var quantityInputs = document.querySelectorAll(".quantity-input");
quantityInputs.forEach(function (input) {
  input.addEventListener("change", updateSubtotal);
});
updateSubtotal();

function checkout() {
  const cartItems = document.querySelectorAll(".cartItemID");
  const cartItemsID = [];

  cartItems.forEach(function (cartItem) {
    const row = cartItem.closest("tr");
    const checkbox = row.querySelector(".selectedCheckBox");
    if (checkbox.checked) cartItemsID.push(cartItem.value);
  });

  if (cartItemsID.length != 0) {
    var data = "cartItemsID=";
    for (var i = 0; i < cartItemsID.length; i++) {
      data += cartItemsID[i] + ",";
    }
    data = data.slice(0, -1);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkout.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          alert("Proceeding to billing...");
          window.location.href = "http://localhost/Nicee/billing/billing.php";
        }
      }
    };
    xhr.send(data);
  } else {
    alert("Please select the item(s) to be checked out.");
  }
}
