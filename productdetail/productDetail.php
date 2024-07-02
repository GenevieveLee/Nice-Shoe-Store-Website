<?php
// Start or resume the session
session_start();

include "../includes/config.php";

if (isset($_POST["quantity"]) && isset($_POST["productID"])) {
  if($_POST['size'] == "0")
    echo '<script>alert("Please select your size.");</script>';
  else {
    $productID = $_POST["productID"];
    $size = $_POST["size"];
    $size = "UK " . $size;
    $quantity = $_POST["quantity"];

    $sqlSize = "SELECT SizeID from sizes WHERE Size = '$size'";
    if ($resultSize = mysqli_query($conn, $sqlSize)) {
        $row = mysqli_fetch_assoc($resultSize);
        $sizeID = $row['SizeID'];
        $sqlVariant = "SELECT VariantID
    FROM productvariants
    WHERE ProductID = '$productID' AND SizeID = '$sizeID'";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    if ($resultVariant = mysqli_query($conn, $sqlVariant)) {
        $row = mysqli_fetch_assoc($resultVariant);
        $variantID = $row['VariantID'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    $sqlInsert = "INSERT INTO cartitems (CartID, VariantID, Quantity) VALUES (" . $_SESSION['cartID'] . ", $variantID, $quantity)";
    if (mysqli_query($conn, $sqlInsert)) {
        echo '<script>alert("Add to cart successfully.");</script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  }
}
?>

<html>

<head>
    <title>Product Detail</title>
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/productDetail.css">
</head>

<body>

    <?php
    include ("../includes/config.php");
    include ('../includes/header.php');
    ?>
    <br>
    <div class="path">
        <a href="http://localhost/Nicee/" class="navigation">Home</a> / <a href="http://localhost/Nicee/"
            class="navigation">Shop</a> / <a href="productDetail.php" class="navigation2">Product Detail</a>
    </div>

    <div class="up">

        <?php
        // Check if the product ID is set in the URL
        if (isset($_GET['productID'])) {
            $productID = $_GET['productID'];
            $productID = trim($productID, "'");


            // Retrieve product images based on the product ID
            $sqlImage = "SELECT * FROM productimage WHERE productID = '$productID'";
            $resultImage = mysqli_query($conn, $sqlImage);

            // Check if there are any images available for the product
            if (mysqli_num_rows($resultImage) > 0) {
                // Display images in the left column
                echo '<div class="left-column">';
                echo '<table>';
                while ($image = mysqli_fetch_assoc($resultImage)) {
                    echo '<tr>';
                    echo '<td><img class="product-img" src="data:image/jpeg;base64,' . base64_encode($image['image']) . '" alt="Product Image" onclick="showBigImage(\'data:image/jpeg;base64,' . base64_encode($image['image']) . '\')"></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';

                // Show the first image in the center column
                $resultImage = mysqli_query($conn, $sqlImage);
                $firstImage = mysqli_fetch_assoc($resultImage);
                echo '<div class="center-column" id="bigImageDisplay">';
                echo '<img class="bigImage" id="bigImage" src="data:image/jpeg;base64,' . base64_encode($firstImage['image']) . '" alt="Product Image">';
                echo '</div>';
            } else {
                // If no images found, display a message
                echo '<div>No images available for this product</div>';
            }
        } else {
            // If product ID is not set in the URL, display an error message
            echo '<div>Error: Product ID not provided</div>';
        }
        ?>

        <div class="right-column">
            <table>
                <tr>
                    <?php
                    $sqlProduct = "SELECT * FROM Products WHERE ProductID = '$productID'";
                    $resultProduct = mysqli_query($conn, $sqlProduct);
                    if (mysqli_num_rows($resultProduct) > 0) {
                        $product = mysqli_fetch_assoc($resultProduct);
                        echo "<td colspan='2' style='font-weight:bold; font-size:30px;'>" . $product['Name'] . "</td>";
                    } else {
                        // If no images found, display a message
                        echo '<div>No product found</div>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <?php
                        // Assume $rating is the rating value fetched from the database
                        $rating = $product['Rating']; // Example rating value
                        
                        // Pass the rating value to JavaScript
                        echo "<script>const rating = $rating;</script>";
                        ?>

                        <input type="radio" class="star_radio" id="1star_radio" name="1star" value="star">
                        <label for="1star_radio">★</label>

                        <input type="radio" class="star_radio" id="2star_radio" name="2star" value="star">
                        <label for="2star_radio">★</label>

                        <input type="radio" class="star_radio" id="3star_radio" name="3star" value="star">
                        <label for="3star_radio">★</label>

                        <input type="radio" class="star_radio" id="4star_radio" name="4star" value="star">
                        <label for="4star_radio">★</label>

                        <input type="radio" class="star_radio" id="5star_radio" name="5star" value="star">
                        <label for="5star_radio">★</label>

                    </td>
                </tr>
                <tr>
                    <td id="price">
                        <?php
                        if (!empty($product['Price'])) {
                            $price = number_format($product['Price'], 2);
                            echo "$ " . $price;
                        } else
                            echo "Price not available";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if (!empty($product['Description']))
                            echo $product['Description'];
                        else
                            echo "Niceee Shoe Description.....";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
            </table>
            <form method="post" action=<?php "productDetail?productID=" . $productID . ".php" ?>>
                <input type="hidden" id="productID" name="productID" value="<?php echo $productID; ?>">
                <input type="hidden" id="selectedSize" name="size" value="0">
                <input type="hidden" id="userID" name="userID"
                    value="<?php echo isset($_SESSION['userID']) ? $_SESSION['userID'] : "" ?>">
                <table>
                    <td style="font-weight:bold; font-size:18px;">
                        Size:

                        <?php
                        // Assuming $productID is already set
                        $sqlSizes = "SELECT pv.StockQuantity AS Quantity, s.Size AS Size
            FROM productvariants pv
            JOIN sizes s ON pv.SizeID = s.SizeID
            WHERE pv.ProductID = '$productID'";
                        $resultSizes = mysqli_query($conn, $sqlSizes);
                        $sizes = array();

                        // Initialize all sizes' quantities to 0
                        $allSizes = array("UK 7", "UK 8", "UK 9", "UK 10", "UK 11", "UK 12");
                        foreach ($allSizes as $size) {
                            $sizes[$size] = 0;
                        }
                        while ($row = mysqli_fetch_assoc($resultSizes)) {
                            $sizes[$row['Size']] = $row['Quantity'];
                        }
                        ?>
                    </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" id="7" class="size_select" value="UK 7" onclick="selected('7')" <?php if (!isset($sizes['UK 7']) || $sizes['UK 7'] == 0)
                                echo 'disabled'; ?>>
                            <input type="button" id="8" class="size_select" value="UK 8" onclick="selected('8')" <?php if (!isset($sizes['UK 8']) || $sizes['UK 8'] == 0)
                                echo 'disabled'; ?>>
                            <input type="button" id="9" class="size_select" value="UK 9" onclick="selected('9')" <?php if (!isset($sizes['UK 9']) || $sizes['UK 9'] == 0)
                                echo 'disabled'; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" id="10" class="size_select" value="UK 10" onclick="selected('10')"
                                <?php if (!isset($sizes['UK 10']) || $sizes['UK 10'] == 0)
                                    echo 'disabled'; ?>>
                            <input type="button" id="11" class="size_select" value="UK 11" onclick="selected('11')"
                                <?php if (!isset($sizes['UK 11']) || $sizes['UK 11'] == 0)
                                    echo 'disabled'; ?>>
                            <input type="button" id="12" class="size_select" value="UK 12" onclick="selected('12')"
                                <?php if (!isset($sizes['UK 12']) || $sizes['UK 12'] == 0)
                                    echo 'disabled'; ?>>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <span class="quantity-selector">
                                <input type="button" class="minus-button" value="-" onclick="decrement()">
                                <input type="number" id="quantity" name="quantity" class="quantity-input" min="1"
                                    max="99" value="1">
                                <input type="button" class="plus-button" value="+" onclick="increment()">
                            </span>
                            <input type="submit" id="buy_submit" value="Add to Cart" onclick="loginChecking()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                    </tr>
                </table>
            </form>

            <table id="deliveryOption">
                <tr class="deliveryOptionRow">
                    <td class="logo">
                        <div class="deliveryContainer">
                            <div>
                                <span>
                                    <img width="60px" ; height="60px" ; src="resources/fastDeliveryIcon.jpg"
                                        alt="Free Delivery Icon">
                                </span>
                                <span class="deliverylogo">
                                    Free Delivery
                                </span>
                            </div>
                            <div>
                                <a id="logoLink">Check Delivery Availability</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <div class="overlay"></div>
                <div id="postalPopUp">
                    <h2>Delivery Availability</h2>
                    <div>
                        <ol>
                            <li>Postal Code:43000
                                <ul>
                                    <li>Free delivery and delivery on the same day if ordered before 7:00 a.m.</li>
                                    <li>No delivery on weekend or public holiday.</li>
                                </ul>
                            </li>
                            <li>Postal Code:43100
                                <ul>
                                    <li>Free delivery and delivery on the same day if ordered before 7:00 a.m.</li>
                                    <li>No delivery on Tuesday.</li>
                                </ul>
                            </li>
                            <li>Postal Code:75450
                                <ul>
                                    <li>Free delivery and delivery on the same day if ordered before 8:00 a.m.</li>
                                </ul>
                            </li>
                            <li>Postal Code:50250</li>
                            <ul>
                                <li>Free delivery and delivery on the same day if ordered before 2:00 p.m.</li>
                                <li>No delivery on Tuesday.</li>
                            </ul>
                            </li>
                            <li>Postal Code:81200
                                <ul>
                                    <li>Delivery on the same day if ordered before 2:00 p.m.</li>
                                    <li>No delivery on Tuesday.</li>
                                    <li>No free delivery.</li>
                                </ul>
                            </li>

                        </ol>
                    </div>
                    <button id="closeButton" onclick="closePopUp()">Close</button>
                </div>
        </div>

    </div>


    <tr class="deliveryOptionRow" id="returnDev">
        <td class="logo" id="line">
            <div class="deliveryContainer">
                <div>
                    <span>
                        <img width=60px height=55px src="resources/returnDeliveryIcon.jpg"
                            alt="Return Delivery Icon"></span>
                    <span class="deliverylogo"> Return Delivery</span>
                </div>
                <div id="returnDesc">Free 30 Days Delivery Returns</div>
            </div>
        </td>
    </tr>

    <div class="overlay"></div>
    <div id="returnPopUp">
        <h2>Details</h2>
        <div>Customers can return products if:
            <ol>
                <li>Did not receive the order</li>
                <li>Received the wrong product(s) (e.g. wrong size/colour, different product)</li>
                <li>Damaged item</li>
                <ul>

                    <li>Broken products</li>

                    <li>Outer packaging damaged</li>

                    <li>Slight scratches</li>

                    <li>Others</li>
                </ul>

                <li>Empty Parcel</li>

            </ol>
        </div>
        <button id="closeButton" onclick="closePopUp()">Close</button>
    </div>



    </table>
    <br>
    </div>
    </div>
    <br>

    <div id="bottom">
        <h2 class="color4" style="padding-top:10px;"> █ Related item</h2>
        <table>
            <tr>
                <td>
                    <?php
                    include ("../includes/config.php");
                    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";

                    // Execute the SQL query
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $productID = $row['ProductID'];
                        $productName = $row['Name'];
                        $productPrice = $row['Price'];

                        $sqlImage = "SELECT * FROM productImage WHERE productID = '$productID'";
                        $images = mysqli_query($conn, $sqlImage);
                        $image = mysqli_fetch_assoc($images);
                        $productImage = $image['image'];
                        echo "<td>";
                        include ("../home/components/productcard.php");
                        echo "</td>";
                    }
                    ?>
                </td>
            </tr>
        </table>

    </div>

    <?php
    include ('../includes/footer.php');
    ?>
    <script src="script.js"></script>

</body>

</html>