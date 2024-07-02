<!DOCTYPE html>
<html>

<head>
    <title>Nicee Shoes Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/items.css">
    <link rel="stylesheet" href="../styles/common.css">
</head>

<body>
    <?php
    include ("../includes/header.php");

    include ("../includes/config.php");

    $searchTerm = "";
    $selectedCategory = "";
    $sql = "SELECT * FROM Products";

    if (isset($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
        $sql .= " WHERE Name LIKE '%$searchTerm%'";

        // If a category is also selected, add an AND condition
        if (isset($_GET['category'])) {
            // Sanitize the selected category to prevent SQL injection
            $selectedCategory = mysqli_real_escape_string($conn, $_GET['category']);
            $sql .= " AND Category = '$selectedCategory'";
        }
    } else {
        // If no search term is provided, only apply the category filter if available
        if (isset($_GET['category'])) {
            // Sanitize the selected category to prevent SQL injection
            $selectedCategory = mysqli_real_escape_string($conn, $_GET['category']);
            $sql .= " WHERE Category = '$selectedCategory'";
        }
    }
    $result = mysqli_query($conn, $sql);

    ?>

    <div class="container">
        <div class="content">
            <?php include ("components/categoriesbar.php"); ?>

            <div class="product-list-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    if (!empty($selectedCategory) && !empty($searchTerm))
                        echo "<h1 id='categorylabel' class='mainlabel'>Search results for '$searchTerm' in '$selectedCategory' category:</h1>";
                    else if (!empty($selectedCategory) && empty($searchTerm))
                        echo "<h1 id='categorylabel' class='mainlabel'>Items in '$selectedCategory' category:</h1>";
                    else if (empty($selectedCategory) && !empty($searchTerm))
                        echo "<h1 id='categorylabel' class='mainlabel'>Search results for '$searchTerm':</h1>";
                    else
                        echo "<h1 id='categorylabel' class='mainlabel'>All items:</h1>";

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
                } else {
                    echo "<h1 id='categorylabel' class='mainlabel'>No results found.</h1>";
                }
                ?>
            </div>
        </div>
    </div>


    <?php
    include ("../includes/footer.php");
    ?>
</body>

</html>