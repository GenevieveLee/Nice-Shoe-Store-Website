<?php
// Start or resume the session
session_start();

if (isset($_POST['cartItemsID']) && $_POST['cartItemsID'] != "") {
    $list = $_POST['cartItemsID'];
    $_SESSION['cartItemsID'] = $list;
    $response = array('status' => 'success');
    echo json_encode($response);
}
?>