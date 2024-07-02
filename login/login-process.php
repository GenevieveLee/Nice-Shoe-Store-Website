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
    $sql = "SELECT * FROM Users WHERE Email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["Password"])) {
            $_SESSION['userID'] = $row['UserID'];
            $_SESSION['firstName'] = $row['FirstName'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['address'] = $row['Address'];

            $sql = "SELECT CartID FROM carts WHERE UserID =" . $row['UserID'];
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $firstRow = mysqli_fetch_assoc($result);
                $_SESSION['cartID'] = $firstRow['CartID'];
            } else {
                // Handle the case where the query fails
                echo "Error: " . mysqli_error($conn);
            }

            header("Location: http://localhost:/Nicee");
            exit();

        } else {
            header("Location: login.php?error=Password incorrect");
            exit();
        }
    } else {
        header("Location: login.php?error=invalid email");
    }
}
$conn->close();
?>