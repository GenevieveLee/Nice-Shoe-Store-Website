<?php

session_start();

if (isset($_POST['couponCode']) && $_POST['couponCode'] != "removeCoupon") {
    $_SESSION['DiscountPercentage'] = 0;
    $_SESSION['CouponID'] = "";
    $response = array('status' => 'success');
    echo json_encode($response);
}
?>