<?php   

    if($_SERVER['REQUEST_METHOD']==='POST') {
        include ("../includes/config.php");
        if($conn->connect_error)
        die("Connection failed: ".$conn->connect_error);
        
        if (isset($_POST['cartItemID'])) {
            $CartItemID = $_POST['cartItemID'];
            $sql = "DELETE FROM cartitems WHERE CartItemID = '$CartItemID'";
            if ($conn->query($sql) === TRUE) {
                $response = array('status' => 'success', );
                echo json_encode($response);
            } else {
                $response = array('status' => 'fail', 'message' => $conn->error);
                echo json_encode($response);
            }
        }
    } else {
        $response = array('status' => 'fail', 'message' => 'Product ID not provided');
        echo json_encode($response);
    }
    $conn->close();
?>  
