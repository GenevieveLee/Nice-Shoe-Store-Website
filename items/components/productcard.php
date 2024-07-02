<div class="product-card">
    <div class="product-image">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($productImage); ?>" alt="Product Image">
    </div>
    <div class="product-info">
        <div class="product-title"><?php echo $productName; ?></div>
        <div class="product-price">$<?php echo number_format($productPrice, 2); ?></div>
        <a href=<?php echo " http://localhost/Nicee/productdetail/productDetail.php?productID='$productID'" ?>
            class="product-btn">View</a>
    </div>
</div>