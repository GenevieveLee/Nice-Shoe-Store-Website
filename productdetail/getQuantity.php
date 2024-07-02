<?php
include "../includes/config.php";

// Check if the size and productID are set and not empty
if (isset($_POST['size']) && isset($_POST['productID']) && !empty($_POST['size']) && !empty($_POST['productID'])) {
    // Sanitize inputs
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);

    // Fetch SizeID
    $sqlSizeID = "SELECT SizeID FROM sizes WHERE Size = '$size'";
    $resultSizeID = mysqli_query($conn, $sqlSizeID);

    if ($resultSizeID && mysqli_num_rows($resultSizeID) > 0) {
        $rowSizeID = mysqli_fetch_assoc($resultSizeID);
        $sizeID = $rowSizeID['SizeID'];

        // Fetch StockQuantity
        $sqlStockQuantity = "SELECT pv.StockQuantity
                            FROM productvariants pv
                            WHERE pv.ProductID = '$productID' AND pv.SizeID = '$sizeID'";
        $resultStockQuantity = mysqli_query($conn, $sqlStockQuantity);

        if ($resultStockQuantity && mysqli_num_rows($resultStockQuantity) > 0) {
            $rowStockQuantity = mysqli_fetch_assoc($resultStockQuantity);
            $stockQuantity = $rowStockQuantity['StockQuantity'];

            echo $stockQuantity;
        } else {
            echo "Error: No stock quantity found";
        }
    } else {
        echo "Error: Size not found";
    }
} else {
    echo "Error: Size or product ID not provided";
}
?>