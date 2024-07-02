<header>
    <div class="topbanner">
        <p>Summer Sale For All Sport Products - OFF 50%! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a
                href="http://localhost/Nicee/items/"><u>ShopNow</u></a></p>
    </div>
    <div class="topnav">
        <img class="logo" src="resources/Nicee_shoes_logo.png" alt="shop logo" width="50" height="50">
        <button class="menu-icon" onclick="toggleMenu()">&#9776;</button> <!-- Add a menu icon for mobile -->
        <div id="menuItems1" class="menuItems1">
            <a class="active" href="http://localhost/Nicee/index.php">Home</a>
            <a href="http://localhost/Nicee/about/about.php">About</a>
            <a href="http://localhost/Nicee/contact/contact.php">Contact</a>
            <a href="http://localhost/Nicee/login/signup.php">Sign Up</a>
        </div>

        <div id="menuItems2" class="menuItems2">
            <button id="account" class="account-icon"><img src="resources/user.png" width="15" height="15"></button>
            <button id="cart" class="cart-icon"><img src="resources/shopping-cart.png" width="15" height="15"></button>

            <div class="searchbar">
                <button id="searchButton" type="submit"><img src="resources/search.png" width="15" height="15"></button>
                <input type="text" placeholder="What are you looking for?" id="headerSearch">
            </div>
        </div>
    </div>
    <hr>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function handleSearch() {
            var searchTerm = document.getElementById("headerSearch").value.trim();
            var url = "http://localhost/Nicee/items/";

            if (window.location.search) {
                url += "?search=" + encodeURIComponent(searchTerm) + "&" + window.location.search.substring(1);
            } else {
                url += "?search=" + encodeURIComponent(searchTerm);
            }
            window.location.href = url;
        }

        document
            .getElementById("searchButton")
            .addEventListener("click", handleSearch);

        document
            .getElementById("headerSearch")
            .addEventListener("keypress", function (event) {
                // Check if the "Enter" key is pressed (keyCode 13) or (which 13)
                if (event.keyCode === 13 || event.which === 13) {
                    // Prevent the default action of the "Enter" key (form submission)
                    event.preventDefault();
                    handleSearch();
                }
            });
    });

    document.getElementById("account").addEventListener("click", function () {
        window.location.href = "http://localhost/Nicee/account/myaccount.php";
    });

    document.getElementById("cart").addEventListener("click", function () {
        window.location.href = "http://localhost/Nicee/cart/cart.php";
    });

    function toggleMenu() {
        var menuItems = document.getElementById("menuItems1");
        var menuItems2 = document.getElementById("menuItems2");

        if (menuItems.style.display === "block") {
            menuItems.style.display = "none";
            menuItems2.style.display = "block";
        } else {
            menuItems.style.display = "block";
            menuItems2.style.display = "none";
        }
    }

    window.addEventListener("resize", function () {
        var menuItems = document.getElementById("menuItems1");
        var menuItems2 = document.getElementById("menuItems2");

        if (window.innerWidth > 768) {
            menuItems.style.display = "block";
            menuItems2.style.display = "block";
        } else {
            menuItems.style.display = "block";
            menuItems2.style.display = "none";
        }
    });
</script>