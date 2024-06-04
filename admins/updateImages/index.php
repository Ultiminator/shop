<?php
//check if logged in
session_start();
if (!isset($_SESSION['adminId'])){
    header('location: ../login');
}
//check if there is item 
if (!isset($_GET['id'])){
    header("location: ../items");
}
$itemId = $_GET['id'];
//connect to the database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if(mysqli_connect_errno()){
    die("can't connect to the database");
}
//get the item name to ouble check the admin is editing the right item
$query = "select name from items where id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
$itemName = mysqli_fetch_assoc($result)['name'];

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo "Update Images: " . $itemName;
        ?>
    </title>
    <script src="./Script.js"></script>
</head>
<body onload="loadImages('<?php echo $itemId; ?>')">
    
<label for="id">Item Id: </label>
    <input type="text" disabled name="id" id="id"
    <?php echo "value='$itemId'"; ?>
    />

    <label for="name">Item Name: </label>
    <input type="text" disabled name="name" id="name"
    <?php echo "value='$itemName'"; ?>
    />

    <table id="imagesTable">
    </table>
    <div id="displayImg" style="display: none;">
        <button onclick="hideImg()">x</button>
        <img src='' id="imgDisplay">
    </div>
    
</body>
</html>