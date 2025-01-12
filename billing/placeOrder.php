<?php
session_start();
include_once ('../includes/config.php');

$response = array();
$response['status'] = 'success';

if (isset($_POST['name']) && isset($_POST['streetaddress']) && isset($_POST['towncity']) && isset($_POST['phonenumber']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $streetaddress = $_POST['streetaddress'];
    $towncity = $_POST['towncity'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $date = date('Y-m-d H:i:s');
    $userID = $_SESSION["userID"];
    $total = $_POST['total'];
    $paymentmethod = $_POST['paymentmethod'];

    $column = "FullName, Total, PaymentMethod, UserID, Datetime, StreetAddress, TownCity, PhoneNumber, Email";
    $value = "'$name', '$total', '$paymentmethod', '$userID', '$date', '$streetaddress', '$towncity', '$phonenumber', '$email'";
    if (isset($_SESSION['CouponID']) && $_SESSION['CouponID'] != "") {
        $couponID = $_SESSION['CouponID'];
        $column .= ", CouponID";
        $value .= ", '$couponID'";
    }
    if (isset($_POST['apartmentunit'])) {
        $apartmentunit = $_POST['apartmentunit'];
        $column .= ", ApartmentUnit";
        $value .= ", '$apartmentunit'";
    }
    if (isset($_POST['companyname'])) {
        $companyname = $_POST['companyname'];
        $column .= ", CompanyName";
        $value .= ", '$companyname'";
    }

    $sql = "INSERT INTO orders ($column) VALUES ($value)";
    if (mysqli_query($conn, $sql)) {
        $sqlOrder = "SELECT OrderID FROM orders WHERE FullName = '$name' AND Datetime = '$date' AND Email = '$email'";
        $resultOrder = mysqli_query($conn, $sqlOrder);
        if ($resultOrder) {
            $rowOrder = mysqli_fetch_assoc($resultOrder);
            $orderID = $rowOrder['OrderID'];
        } else {
            $response['status'] = 'fail';
        }
        $CheckoutItems = $_SESSION['cartItemsID'];
        $CheckoutItems = explode(',', $CheckoutItems);
        foreach ($CheckoutItems as $CheckoutItem) {
            $sqlCartItem = "SELECT * FROM cartitems WHERE CartItemID = '$CheckoutItem'";
            $resultCartItem = mysqli_query($conn, $sqlCartItem);
            if ($resultCartItem) {
                while ($rowCartItem = mysqli_fetch_assoc($resultCartItem)) {
                    $VariantID = $rowCartItem['VariantID'];
                    $Quantity = $rowCartItem["Quantity"];

                    $sqlOrderItem = "INSERT INTO orderitem (VariantID, Quantity, OrderID) VALUES ('$VariantID', '$Quantity', '$orderID')";
                    mysqli_query($conn, $sqlOrderItem);

                    $sqlRemoveCartItem = "DELETE FROM cartitems WHERE CartItemID = '$CheckoutItem'";
                    mysqli_query($conn, $sqlRemoveCartItem);
                }
            }
        }
        $response['status'] = 'success';
    }
} else {
    $response['status'] = 'fail';
}
echo json_encode($response);
?>