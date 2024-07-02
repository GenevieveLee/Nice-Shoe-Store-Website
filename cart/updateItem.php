<?php
include ("../includes/config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CartItemID']) && isset($_POST['newQuantity'])) {
    $CartItemID = $_POST['CartItemID'];
    $Quantity = $_POST['newQuantity'];

    $sql = "UPDATE cartitems SET Quantity = '$Quantity' WHERE CartItemID = '$CartItemID'";
    $result = $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        $response = array('status' => 'fail', 'message' => $conn->error);
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'fail', 'message' => 'Invalid Request Method');
    echo json_encode($response);
}

$conn->close();
?>