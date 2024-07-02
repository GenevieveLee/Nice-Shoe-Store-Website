<?php
session_start();

include ("../includes/config.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password matches, set session variables
            $_SESSION['UserID'] = $row['userID'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['email'] = $row['email'];

            // Redirect to the desired page
            header("Location: myaccount.php");
            exit();
        } else {
            // Password doesn't match, redirect with error message
            header("Location: login.php?error=Invalid password");
            exit();
        }
    } else {
        // Email not found, redirect with error message
        header("Location: login.php?error=Invalid email");
        exit();
    }
}

// Close the database connection
$conn->close();
?>