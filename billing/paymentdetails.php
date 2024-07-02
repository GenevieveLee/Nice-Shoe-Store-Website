<div class="paymentDetails">
    <div class="itemColumns">
        <?php
        include ("../includes/config.php");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $CheckoutItems = $_SESSION['cartItemsID'];
        $CheckoutItems = explode(',', $CheckoutItems);

        $total = 0;
        $totalCartPrice = 0;
        $ShipFee = 0;
        foreach ($CheckoutItems as $CheckoutItem) {
            $sql = "SELECT pi.Image AS Image, 
        p.Name AS Name, 
        p.Price AS Price, 
        pv.variantID AS variantID, 
        ci.Quantity AS Quantity, 
        s.Size AS Size
        FROM cartitems c 
        JOIN cartitems ci ON c.cartID = ci.cartID 
        JOIN productvariants pv ON ci.variantID = pv.variantID 
        JOIN sizes s ON pv.SizeID = s.SizeID
        JOIN products p ON pv.ProductID = p.ProductID 
        JOIN productimage pi ON p.ProductID = pi.ProductID WHERE ci.CartItemID = '$CheckoutItem' LIMIT 1;";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $subtotal = $row["Price"] * $row["Quantity"];
                $totalCartPrice += $subtotal;
                echo "<table id='billTable'>";
                echo "<tr>";
                echo "<td>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row["Image"]) . "' alt='" . $row["Name"] . "' width='auto' height='100'><br>";
                echo "</td>";
                echo "<td>" . $row["Name"] . " " . $row['Size'] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td class='subtotalList' id='subtotal'> RM " . $subtotal . "</td>";
                echo "</tr>";
                echo "</table>";

            }

        }
        $shipFee = $totalCartPrice < 100 ? 5 : 0;

        $total = $totalCartPrice + $shipFee;

        echo "<hr>";
        echo "<div class='pricingColumn'>";
        echo "<p class='paymentLabel'>Shipping:</p>";
        echo "<p id='shipFee'> RM " . $shipFee . "</p>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='pricingColumn'>";
        echo "<p class='paymentLabel'>Total:</p>";
        echo "<p id='total'> RM " . $total . "</p>";
        echo "</div>";
        $conn->close();
        ?>

        <div class="paymentMethod">
            <input type="radio" id="bank" name="paymentMethod">
            <label for="bank">Bank</label>
            <div class="paymentMethodIcon">
                <img src="resources\visa.png" alt="visa">
                <img src="resources\mastercard.png" alt="mastercard">
                <img src="resources\paypal.png" alt="paypal">
                <img src="resources\westernunion.png" alt="westernunion">
            </div>
        </div>
        <div class="paymentMethod">
            <input type="radio" id="cashOn" name="paymentMethod">
            <label for="cashOn">Cash On Delivery</label>
        </div>
        <div class="couponColumn">
            <input type="text" id="couponCode" placeholder="Coupon Code">
            <button class="paymentButton" id="couponButton" style="margin-right: 8px;">Apply
                Coupon</button>
            <button class="paymentButton" id="removeCouponButton">Remove Coupon</button>
        </div>
        <button class="paymentButton" id="paymentButton">Place Order</button>
    </div>
</div>