function emailValidation(email) {
  var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return emailPattern.test(email);
}

document
  .getElementById("password")
  .addEventListener("keypress", function (event) {
    // Check if the "Enter" key is pressed (keyCode 13) or (which 13)
    if (event.keyCode === 13 || event.which === 13) {
      // Prevent the default action of the "Enter" key (form submission)
      event.preventDefault();
      if (ValidateLoginForm()) document.getElementById("loginForm").submit();
    }
  });

document
  .getElementById("signupPassword")
  .addEventListener("keypress", function (event) {
    // Check if the "Enter" key is pressed (keyCode 13) or (which 13)
    if (event.keyCode === 13 || event.which === 13) {
      // Prevent the default action of the "Enter" key (form submission)
      event.preventDefault();
      if (ValidateSignupForm()) document.getElementById("signupForm").submit();
    }
  });

function ValidateSignupForm() {
  const username = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("signupPassword").value;

  var emailError = document.getElementById("emailError");
  var nameError = document.getElementById("nameError");
  var passwordError = document.getElementById("passwordError");

  emailError.innerHTML = "";
  nameError.innerHTML = "";
  passwordError.innerHTML = "";

  if (username.trim() === "") {
    nameError.innerHTML = "Name is required";
    document.getElementById("name").focus();
    return false;
  }

  if (!emailValidation(email)) {
    emailError.innerHTML = "Invalid email format";
    document.getElementById("email").focus();
    return false;
  }

  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required";
    document.getElementById("signupPassword").focus();
    return false;
  } else if (password.length < 8) {
    passwordError.innerHTML = "Password must be at least 8 characters long";
    document.getElementById("signupPassword").focus();
    return false;
  } else if (!/\d/.test(password)) {
    passwordError.innerHTML = "Password must contain at least one number";
    document.getElementById("signupPassword").focus();
    return false;
  } else if (!/[a-z]/.test(password) || !/[A-Z]/.test(password)) {
    passwordError.innerHTML =
      "Password must contain at least one uppercase and one lowercase letter";
    document.getElementById("signupPassword").focus();
    return false;
  } else if (!passwordPattern.test(password)) {
    passwordError.innerHTML = "Password contains invalid characters";
    document.getElementById("signupPassword").focus();
    return false;
  }

  return true;
}

function ValidateLoginForm() {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  var emailError = document.getElementById("emailError");
  var passwordError = document.getElementById("passwordError");

  emailError.innerHTML = "";
  passwordError.innerHTML = "";

  if (!emailValidation(email)) {
    emailError.innerHTML = "Invalid email format";
    document.getElementById("email").focus();
    return false;
  }

  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required";
    document.getElementById("password").focus();
    return false;
  }
  return true;
}

function togglePasswordVisibility() {
  var passwordField = document.getElementById("password");
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
}

function signupTogglePasswordVisibility() {
  var passwordField = document.getElementById("signupPassword");
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
}
