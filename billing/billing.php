<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nicee Shoes Store</title>
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/billing.css">
    <link rel="stylesheet" href="../styles/common.css">
</head>

<body>
    <?php
    session_start();
    include ("../includes/header.php");
    ?>

    <div class="path">
        <a href="http://localhost/Nicee/index.php" class="navigation">Home</a> / <a
            href="http://localhost/Nicee/cart.php" class="navigation">Cart</a> / <a
            href="http://localhost/Nicee/billing/billing.php" class="navigation2">Checkout</a>
    </div>
    <div class="billing">
        <?php include ("billingform.php"); ?>

        <?php include ("paymentdetails.php"); ?>
    </div>
    <?php include ("../includes/footer.php"); ?>

    <script src="script.js"></script>
</body>

</html>