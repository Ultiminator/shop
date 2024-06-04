<?php
//starting session to check if logged in
session_start();
if(!isset($_SESSION['adminId'])){
    header('location: ../login');
}

//connect to the database to get some info
include "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if(mysqli_connect_errno()){
    die("can't connect to the database");
}
//get categories
$query = "select tag from items group by tag";
$result = mysqli_query($dbConn, $query);
for ($i=0; $i < mysqli_num_rows($result); $i++) {
    $cats[$i] = mysqli_fetch_assoc($result)['tag'];
}
//get brands
$query = "select brand from items group by brand";
$result = mysqli_query($dbConn, $query);
for ($i=0; $i < mysqli_num_rows($result); $i++) {
    $brands[$i] = mysqli_fetch_assoc($result)['brand'];
}
//get min and max price
$query = "select MIN(price) as min, Max(price) as max from items";
$result = mysqli_query($dbConn, $query);
$row = mysqli_fetch_assoc($result);
$minPrice = $row['min'];
$maxPrice = $row['max'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Panel</title>
    <script src="Script.js"></script>
</head>
<body>
    <label for="name">Item name: </label>
    <input type="text" name="name" id="name">
    <label for="cat">Category: </label>
    <select id="cat" name="cat">
        <option value="">All</option>
        <?php
        foreach ($cats as $cat){
            echo "<option value='$cat'>$cat</option>";
        }
        ?>
    </select>
    <label for="brand">Brand: </label>
    <select name="brand" id="brand">
        <option value="">All</option>
        <?php
        foreach ($brands as $brand){
            echo "<option value='$brand'>$brand</option>";
        }
        ?>
    </select>
    <label for="minPrice">Min price: </label>
    <input type="number" name="minPrice" id="minPrice"
        <?php
        echo "value='$minPrice' min='$minPrice' max='$maxPrice'"
        ?>
    />
    <label for="maxPrice">Max price: </label>
    <input type="number" name="maxPrice" id="maxPrice"
        <?php
        echo "value='$maxPrice' min='$minPrice' max='$maxPrice'"
        ?>
    />
    <input type="checkbox" name="discount" id="discount">
    <label for="discount">discount </label>
    <input type="checkbox" name="stock" id="stock">
    <label for="stock">in stock </label>

    <label for="sort">sort by: </label>
    <select id="sort" name="sort">
        <option value="name">Name</option>
        <option value="price asc">Price low to high</option>
        <option value="price desc">Price high to low</option>
        <option value="rating">Lowest rate</option>
        <option value="rating desc">Highest rate</option>
        <option value="joindate desc, jointime desc">Newst</option>
        <option value="joindate asc, jointime asc">oldest</option>
        <option value="id">ID</option>
    </select>
    <button onclick="loadItems()">load</button>

    <a href="../AddNewItem/">Add New Item</a>

    <table id="result"></table>

</body>
</html>

<?php
//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);
?>

