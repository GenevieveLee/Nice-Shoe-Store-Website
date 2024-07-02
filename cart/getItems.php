<?php
session_start();
include_once ("../includes/config.php");

$cartID = $_SESSION['cartID'];

$sqlImages = "SELECT 
    pi.Image AS Image
    FROM 
        carts c
    JOIN 
        cartitems ci ON c.cartID = ci.cartID
    JOIN 
        productvariants pv ON ci.variantID = pv.variantID
    JOIN 
        products p ON pv.ProductID = p.ProductID
    JOIN 
        productimage pi ON p.ProductID = pi.ProductID
    WHERE 
        c.cartID = '$cartID';
    ";
$resultImage = $conn->query($sqlImages);

$userID = $_SESSION['userID'];
$sql = "SELECT 
    p.Name AS Name,
    p.Price AS Price,
    s.Size AS Size,
    ci.CartItemID AS CartItemID,
    ci.Quantity AS Quantity,
    pv.variantID AS variantID
    FROM 
        users u
    JOIN 
        carts c ON u.userID = c.userID
    JOIN 
        cartitems ci ON c.cartID = ci.cartID
    JOIN 
        productvariants pv ON ci.variantID = pv.variantID
    JOIN 
        sizes s ON pv.SizeID = s.SizeID
    JOIN 
        products p ON pv.ProductID = p.ProductID
    WHERE 
        u.userID = '$userID';
    ";
$result = $conn->query($sql);
echo "<table id='cartTable'>";
echo "<tr><th>Select</th><th>Product</th><th>Name</th><th>Price</th><th>Quantity</th><th>Remove</th><th>Subtotal</th></tr>";
$totalCartPrice = 0;
$ShipFee = 0;
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $subtotal = $row["Price"] * $row["Quantity"];
        $totalCartPrice += $subtotal;
        $variantID = $row['variantID'];
        $CartItemID = $row['CartItemID'];
        for ($imageNum = 0; $imageNum < 4; $imageNum++) {
            if ($imageNum % 4 == 0)
                $image = $resultImage->fetch_assoc();
            else
                $resultImage->fetch_assoc();
        }

        echo "<tr>";
        echo "<input type='hidden' name='cartItemID' value='" . $CartItemID . "' class='cartItemID'>";
        echo "<td>";
        echo "<input type='checkbox' name='selected_items[]' value='item_id' class='selectedCheckBox'>";
        echo "</td>";
        echo "<td>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($image["Image"]) . "' alt='" . $row["Name"] . "'width=auto height='100'><br>";
        echo "</td>";
        echo "<td>" . $row["Name"] . " " . $row["Size"] . "</td>";
        echo "<td>RM " . $row["Price"] . "</td>";
        echo "<td>
                    <div class='quantity-selector'>
                        <input type='button' class='minus-button' value='-' onclick='decrement(" . $CartItemID . ", " . $row["Price"] . ")'>
                        <input type='number' id='CartItem" . $CartItemID . "' class='quantity-input' min='1' max='99' value='" . $row["Quantity"] . "'>
                        <input type='button' class='plus-button' value='+' onclick='increment(" . $CartItemID . ", " . $row["Price"] . ")'>
                    </div>  
                  </td>";


        echo "<td>";
        echo "<button type='button' class='delete-button' onclick='deleteItem(" . $CartItemID . ")'> 
                    <img src='../cart/resources/delete_icon.png' alt='Delete' width=auto height='50'></button>";
        echo "</td>";
        echo "<td class='subtotalList' id='subtotal" . $CartItemID . "'> RM " . $subtotal . "</td>";
        echo "</tr>";
    }
} else {
    echo "No items in the cart.";
}
echo "</table>";
?>