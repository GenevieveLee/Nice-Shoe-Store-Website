<?php

session_start();

if (isset($_POST['couponCode']) && $_POST['couponCode'] != "") {
    include_once ('../includes/config.php');
    $couponCode = $_POST['couponCode'];
    $sql = "SELECT * FROM coupons WHERE CouponCode = '$couponCode'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['DiscountPercentage'] = $row['DiscountPercentage'];
            $_SESSION['CouponID'] = $row['CouponID'];
            $response = array('status' => 'success', 'message' => $row['DiscountPercentage']);
            echo json_encode($response);
        } else {
            $response = array('status' => 'fail', 'message' => 'Coupon not found');
            echo json_encode($response);
        }
    } else {
        $response = array('status' => 'fail', 'message' => 'Database error: ' . mysqli_error($conn));
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'fail', 'message' => 'Coupon code not provided');
    echo json_encode($response);
}

?>