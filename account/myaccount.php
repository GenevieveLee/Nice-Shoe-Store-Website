<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account</title>
  <link rel="stylesheet" href="../styles/footer.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/common.css">
  <link rel="stylesheet" href="../styles/myaccount.css">
</head>

<body>

  <?php
  session_start();
  include ('../includes/header.php');
  ?>
  <?php

  // Check if the user is logged in
  if (!isset($_SESSION['userID'])) {
    echo '<script>alert("Please log in to access this page."); window.location.href = "http://localhost/Nicee/login/login.php";</script>';
    exit();
  }
  echo "<h4 style='text-align:right;'>Welcome, " . $_SESSION['firstName'] . "</h4>";

  include ("../includes/config.php");

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form']) && $_POST['submit_form'] == "Save Changes") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $currentPassword = $_POST['currentPass'];
    $new = $_POST['newPass'];
    $hash = password_hash(
      $new,
      PASSWORD_DEFAULT
    );

    $sql = "SELECT Password FROM users WHERE FirstName = '$firstName' AND LastName = '$lastName' AND Email = '$email'";
    if ($result = mysqli_query($conn, $sql)) {
      $row = mysqli_fetch_assoc($result);
      $password = $row['Password'];

      if (password_verify($currentPassword, $password)) {
        $firstName = mysqli_real_escape_string($conn, $firstName);
        $lastName = mysqli_real_escape_string($conn, $lastName);
        $email = mysqli_real_escape_string($conn, $email);
        $address = mysqli_real_escape_string($conn, $address);

        // Update the user's information in the database
        $sql = "UPDATE Users SET FirstName='$firstName', LastName='$lastName', Email='$email', Address='$address', Password='$hash' WHERE UserID={$_SESSION['userID']}";

        if (mysqli_query($conn, $sql)) {
          echo '<script>alert("Your information has been updated successfully.");</script>';

        } else {
          echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
        }
      } else {
        echo '<script>alert("Your current password is incorrect.");</script>';
      }
    } else {
      echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
    }
  }
  ?>

  <div class="path">
    <a href="../index.php" class="navigation">Home</a> / <a href="myaccount.php" class="navigation2">My Account</a>
  </div>

  <span class="left-column">
    <a href="myaccount.php" class="custom-link">Manage My Account</a>
    <h4 class="color5">My Profile</h4>
    <h4 class="color5" onclick="logout()" style="cursor: pointer;">Logout</h4>
  </span>

  <span class="right-column">
    <h3 class="color5">Edit Your Profile</h3>

    <form method="post">
      <table>
        <?php
        $sql = "SELECT * FROM Users WHERE UserID = '" . $_SESSION['userID'] . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $oriFirstName = $row['FirstName'];
          $oriLastName = $row['LastName'];
          $oriEmail = $row['Email'];
          $oriAddress = $row['Address'];
        }
        ?>
        <tr>
          <td class="text">First Name</td>

          <td colspan="2" class="text">Last Name</td>
        </tr>

        <tr>
          <td><input type="text" name="firstName" class="input" placeholder="Md" required="required"
              value="<?php echo $oriFirstName ?>"></td>

          <td colspan="2"><input type="text" name="lastName" class="input" placeholder="Rimel" required="required"
              value="<?php echo $oriLastName ?>"></td>
        </tr>

        <tr>
          <td class="text">Email</td>
          <td colspan="2" class="text">Address</td>
        </tr>

        <tr>
          <td><input type="email" id="email" name="email" class="input" placeholder="rimel1111@gmail.com"
              required="required" value="<?php echo $oriEmail ?>"></td>
          <td colspan="2"><input type="text" name="address" class="input" placeholder="Kingston, 5236, United State"
              required="required" value="<?php echo $oriAddress ?>"></td>
        </tr>
        <tr>
          <td id="errEmail"></td>
        </tr>
        <tr>
          <td colspan="3" class="text">Password Changes</td>
        </tr>

        <tr>
          <td colspan="3"><input type="password" id="current" name="currentPass" class="input"
              placeholder="Current Password" style="width:600px;" required="required">
            <div class="password" onclick="togglePasswordVisibility('current')">Show/Hide
              Password</div>
          </td>
        </tr>


        <tr>
          <td colspan="3"><input type="password" id="new" name="newPass" class="input" placeholder="New Password"
              style="width:600px;" required="required">
            <div id="newErr" style="color: red;font-weight:bold;"></div>
            <div class="password" onclick="togglePasswordVisibility('new')">Show/Hide
              Password</div>
          </td>
        </tr>
        <tr>
          <td colspan="3"><input type="password" id="confirm" name="confirmPass" class="input"
              placeholder="Confirm New Password" style="width:600px;" required="required">
            <div id="confirmErr" style="color: red;font-weight:bold;"></div>
            <div class="password" onclick="togglePasswordVisibility('confirm')">Show/Hide
              Password</div>
          </td>
        </tr>
      </table>
      <div id="error"></div>
      <table>
        <tr>
          <td>
            <input type="reset" name="reset_form" value="Cancel" id="cancelButton">
            <input type="submit" name="submit_form" value="Save Changes" id="submitButton"
              onclick=" return validateSame() && validatePass()">
          </td>
        </tr>
      </table>

    </form>
  </span>
  <script>
    function logout() {
      window.location.href = "logout.php";
    }

    function validateSame() {
      var newPass = document.getElementsByName("newPass")[0].value;
      var confirmPass = document.getElementsByName("confirmPass")[0].value;
      var err = document.getElementById("error");
      if (newPass !== confirmPass) {
        err.innerHTML = "Confirm password and New password do not match.";
        return false;
      }
      else {
        err.innerHTML = "";
        return true;
      }
    }

    document.getElementById("cancelButton").addEventListener("click", function () {
      window.location.href = "../index.php";
    });


    function validateEmail(inputText) {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (!inputText.value.match(mailformat)) {
        document.getElementById("errEmail").innerHTML = "Invalid email format!";
        document.getElementById("email").focus();
        return false;
      } else {
        document.getElementById("errEmail").innerHTML = ""; // Clear error message
        return true;
      }
    }

    function validatePass() {
      const newPass = document.getElementById("new").value;
      const confirmPass = document.getElementById("confirm").value;
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (newPass.length < 8) {
        newErr.innerHTML = "Password must be at least 8 characters long";
        document.getElementById("new").focus();
        return false;
      }

      else if (confirmPass.length < 8) {
        confirmErr.innerHTML = "Password must be at least 8 characters long";
        document.getElementById("confirm").focus();
        return false;
      }

      else if (!/\d/.test(newPass)) {
        newErr.innerHTML = "Password must contain at least one number";
        document.getElementById("new").focus();
        return false;
      }

      else if (!/\d/.test(confirmPass)) {
        confirmErr.innerHTML = "Password must contain at least one number";
        document.getElementById("confirm").focus();
        return false;
      }

      else if (!/[a-z]/.test(newPass) || !/[A-Z]/.test(newPass)) {
        newErr.innerHTML = "Password must contain at least one uppercase and one lowercase letter";
        document.getElementById("new").focus();
        return false;
      }
      else if (!/[a-z]/.test(confirmPass) || !/[A-Z]/.test(confirmPass)) {
        confirmErr.innerHTML = "Password must contain at least one uppercase and one lowercase letter";
        document.getElementById("confirm").focus();
        return false;
      }
      else if (!passwordPattern.test(newPass)) {
        newErr.innerHTML = "Password contains invalid characters";
        document.getElementById("new").focus();
        return false;
      }
      else if (!passwordPattern.test(confirmPass)) {
        confirmErr.innerHTML = "Password contains invalid characters";
        document.getElementById("confirm").focus();
        return false;
      }
      else {
        confirmErr.innerHTML = "";
        newErr.innerHTML = "";
      }

      return true;
    }

    function togglePasswordVisibility(password) {
      var passwordField = document.getElementById(password);
      if (passwordField.type === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    }
  </script>

  <?php
  include ('../includes/footer.php');
  ?>
</body>

</html>