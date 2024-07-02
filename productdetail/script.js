function updateStock() {
  var size = document.getElementById("selectedSize").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "getQuantity.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var stockQuantity = xhr.responseText;
      document.getElementById("inStock").innerText =
        "| In Stock (" + stockQuantity + ")";
    }
  };
  xhr.send(
    "size=UK " +
      size +
      "&productID=" +
      document.getElementById("productID").value
  );
}

function showBigImage(imageURL) {
  const bigImage = document.getElementById("bigImage");
  bigImage.src = imageURL;
}

function decrement() {
  const quantity = document.getElementById("quantity");
  const currentValue = parseInt(quantity.value);
  if (currentValue > 0) {
    quantity.value = currentValue - 1;
  }
}

function increment() {
  const quantity = document.getElementById("quantity");
  const currentValue = parseInt(quantity.value);
  if (currentValue < parseInt(quantity.max)) {
    quantity.value = currentValue + 1;
  }
} // Function to set the color of the stars based on the rating
function setRatingStars(rating) {
  for (let i = 1; i <= 5; i++) {
    const star = document.getElementById(i + "star_radio");
    const label = document.querySelector(`label[for="${i}star_radio" ]`);
    if (i <= rating) {
      star.style.color = "orange";
      label.style.color = "orange";
    } else {
      star.style.color = "lightgrey";
      label.style.color = "lightgrey";
    }
  }
} // Call the function to set the stars based on the fetched rating
setRatingStars(rating);

function loginChecking() {
  var userID = document.getElementById("userID").value;

  if (userID == "") {
    alert("Please log in to access this page.");
    window.location.href = "http://localhost/Nicee/login/login.php";
  }
}

function selected(buttonID) {
  const button = document.getElementById(buttonID);
  button.style.backgroundColor = "#e07575";
  document.getElementById("selectedSize").value = buttonID;
  for (let i = 7; i <= 12; i += 1) {
    if (i != buttonID) {
      const otherButton = document.getElementById(i);
      var isDisabled = otherButton.disabled;
      if (isDisabled) {
        otherButton.style.backgroundColor = "#ddd";
      } else {
        otherButton.style.backgroundColor = "#db4444";
      }
    }
  }
  updateStock();
}
function showReturnPopUp() {
  document.getElementById("returnPopUp").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
function closePopUp() {
  document.getElementById("returnPopUp").style.display = "none";
  document.getElementById("postalPopUp").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}
function showPostalPopUp() {
  document.getElementById("postalPopUp").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
document.getElementById("returnDev").addEventListener("click", showReturnPopUp);
document.getElementById("logoLink").addEventListener("click", showPostalPopUp);
