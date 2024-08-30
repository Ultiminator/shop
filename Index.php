<?php
//get shop name n db parameters
require "./variables.php";
// connect to db
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
//get available data to filter items
// get ctegories
$cats = [];
$query = "select tag from items group by tag";
$result = mysqli_query($dbConn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)){
        $cats[] = $row['tag'];
    }
}
// get brands
$brands = [];
$query = "select brand from items group by brand";
$result = mysqli_query($dbConn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)){
        $brands[] = $row['brand'];
    }
}
// get max and min price
$max = 100000;
$min = 0;
$query = "select max(price) as max, min(price) as min from items";
$result = mysqli_query($dbConn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $max = $row['max'];
    $min = $row['min'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo $shopName;
        ?>
    </title>
    <script src="./Scripts.js"></script>
    <link rel="stylesheet" href="./Styles/Main.css">
    <link rel="stylesheet" href="./Styles/Structures.css">
    <link rel="stylesheet" href="./Styles/Cards.css">
</head>
<body onload="loadItems()">
    <!-- menu bar here -->

    <!-- sidde navigtion for filters -->
    <div id="sidebar">
        <p>Filters</p>
        <!-- options for view -->
        <fieldset>
            <legend>View: </legend>
            <!-- sort -->
            <label for="sort">Sort by: </label><br>
            <select name="sort" id="sort">
                <option value="id">Default</option>
                <option value="name">Alphabetical</option>
                <option value="price asc">Lowest Price</option>
                <option value="price desc">Highest Price</option>
                <option value="rating">Highest Rating</option>
                <option value="joindate desc">Newest</option>
                <option value="joindate asc">Oldest</option>
            </select><br>
            <!-- exclusive view -->
            <input type="checkbox" name="stock" id="stock">
            <label for="stock">In stock Only</label><br>
            <input type="checkbox" name="offer" id="offer">
            <label for="offer">Offers Only</label>
        </fieldset>
         
        <!-- filter by category -->
        <fieldset>
            <legend>Category: </legend>
            <?php
            foreach ($cats as $cat) {
                echo "<input type='checkbox' name='cat' id='$cat' value='$cat'>";
                echo "<label for='$cat'>$cat</label><br>";
            }
            ?>
        </fieldset>
        <!-- filter by brand -->
        <fieldset>
            <legend>brand: </legend>
            <?php
            foreach ($brands as $brand) {
                echo "<input type='checkbox' name='brand' id='$brand' value='$brand'>";
                echo "<label for='$brand'>$brand</label><br>";
            }
            ?>
        </fieldset>
        <!-- filter by rating -->
        <fieldset>
            <legend>Rating: </legend>
            <input type="radio" name="rating" id="0star" value="0" checked>
            <label for="0star">All</label><br>
            <input type="radio" name="rating" id="5star" value="5">
            <label for="5star">5 stars</label><br>
            <input type="radio" name="rating" id="4star" value="4">
            <label for="4star">4 or more</label><br>
            <input type="radio" name="rating" id="3star" value="3">
            <label for="3star">3 or more</label><br>
            <input type="radio" name="rating" id="2star" value="2">
            <label for="2star">2 or more</label><br>
            <input type="radio" name="rating" id="1star" value="1">
            <label for="1star">1 or more</label>
        </fieldset>
        <!-- filter by price -->
        <fieldset>
            <legend>Price: </legend>
            <?php
            echo "<label for='min'>Min: </label>";
            echo "<input type='number' name='min' id='min' min='$min' max='$max' value='$min'>";
            echo "<br>";
            echo "<label for='max'>Max: </label>";
            echo "<input type='number' name='max' id='max' min='$min' max='$max' value='$max'>";
            ?>
        </fieldset>
        <!-- finally a button to apply the filters -->
        <button onclick="loadItems()">Apply filters</button>
    </div>

    <!-- main section, a contianer for items -->
    <div id="itemsContianer">

    </div>
</body>
</html>