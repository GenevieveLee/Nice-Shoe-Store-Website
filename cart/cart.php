<html>

<head>
    <title>Cart</title>
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/cart.css">
</head>

<body>
    <?php
    session_start();
    include ("../includes/config.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_SESSION['userID'])) {
        echo '<script>alert("Please log in to access this page."); window.location.href = "http://localhost/Nicee/login/login.php";</script>';
        exit();
    }

    include ('../includes/header.php');
    if (isset($_SESSION['userID']) && isset($_SESSION['email']) && isset($_SESSION['firstName']) && isset($_SESSION['address'])) {
        $userID = $_SESSION['userID'];
        $firstName = $_SESSION['firstName'];
        $email = $_SESSION['email'];
        $address = $_SESSION['address'];
    }
    ?>

    <div class="path">
        <a href="../index.php" class="navigation">Home</a> / <a href="cart.php" class="navigation2">Cart</a>
    </div>

    <div id="cartItems"></div>

    <div id="cartButton">
        <input type="submit" name="return_to_shop" value="Return To Shop" id="returnShop">
    </div>


    <div class="overlay" id="overlay"></div>
    <div id="couponPopUp">
        <h2>Coupon Has Applied Successfully!</h2>
        <button id="closeButton" onclick="closePopUp()">Close</button>
    </div>
    <div class="billing">
        <table id="billingTable">
            <tr>
                <th style="text-align:left">Cart Total</th>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>Subtotal:</td>
                <td id='subtotal'></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Shipping:</td>
                <td id='shipFee'></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Total:</td>
                <td id='total'></td>
            </tr>
            <tr>
                <td><button name="checkout" id="checkoutButton" onclick="checkout()">Proceed to Checkout</button></td>
            </tr>
        </table>
    </div>


    <script src="cart.js"></script>
    <?php
    include ('../includes/footer.php');
    ?>
</body>

</html>