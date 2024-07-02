<div>
    <?php
    include ("includes/config.php");
    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    include ("home/components/topcontent.php");
    ?>

    <div class="productlist">
        <h4 class="title">Recommended For You</h4>
        <div class="products">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $productID = $row['ProductID'];
                $productName = $row['Name'];
                $productPrice = $row['Price'];

                $sqlImage = "SELECT * FROM productImage WHERE productID = '$productID'";
                $images = mysqli_query($conn, $sqlImage);
                $image = mysqli_fetch_assoc($images);
                $productImage = $image['image'];
                include ("components/productcard.php");
            }
            ?>
        </div>
        <button class="viewmorebtn" onclick="window.location.href='http://localhost/Nicee/items/'">View more</button>
    </div>
</div>