<?php
include ("../includes/config.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate form data
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['signupPassword']) && isset($_POST['email'])) {
    // Validate form data
    $firstName = validate($_POST["name"]);
    $email = validate($_POST["email"]);
    $password = validate($_POST["signupPassword"]);

    $hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Insert user into database
    $sql = "INSERT INTO users (FirstName, Email, Password) VALUES ('$firstName', '$email', '$hash')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT UserID FROM users WHERE FirstName = '$firstName'AND Email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userID = $row['UserID'];
            $sql = "INSERT INTO carts (UserID) VALUES ('$userID')";
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
            } else {
                header("Location: signup.php");
            }
        }
    } else {
        header("Location: signup.php");
    }
}

$conn->close();
?>