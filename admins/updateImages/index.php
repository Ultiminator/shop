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
    <link rel="stylesheet" href="../../Styles/Main.css">
    <link rel="stylesheet" href="../../Styles/fullscreenImg.css">
</head>
<body onload="loadImages('<?php echo $itemId; ?>')">

    <table>
        <tr>
            <td>
                <label for="id">Item Id: </label>
            </td>
            <td>
                <input type="text" disabled name="id" id="id"
                <?php echo "value='$itemId'"; ?>
                />
            </td>
        </tr>
        <tr>
            <td>
                <label for="name">Item Name: </label>
            </td>
            <td>
                <input type="text" disabled name="name" id="name"
                <?php echo "value='$itemName'"; ?>
                />
            </td>
        </tr>
    </table>

    <table id="imagesTable">
    </table>
    <div id="displayImg" style="display: none;" onclick="hideImg()">
        <button onclick="hideImg()">Close</button>
        <img src='' id="imgDisplay">
    </div>

</body>
</html>