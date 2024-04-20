<?php
//check if logged in
session_start();
if (!isset($_SESSION['loggedin'])){
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
$query = "select * from items where id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
$item = mysqli_fetch_assoc($result);

//read describtion file
$dir = "../../items/" . $itemId;
//this will create the directory if not present for some reason
if(!is_dir($dir)){
    if(!mkdir($dir)){
        die("couldn't find the directory and failed to create it");
      }
}
$fileName = $dir . "/describe.txt";
if (file_exists($fileName)){
    $fileHandle = fopen($fileName,'r');
    if($fileHandle){
        /* added 1 to file size because if the file is empty for some reason,
        it will return an error as fread function can't take 0 as 2nd parameter*/
        $describtion = fread($fileHandle, filesize($fileName) + 1);
        fclose($fileHandle);
    }else {
        $describtion = "couldn't open file";
    }
}else {
    $describtion = "couldn't find description file";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo "edit: " . $item['name'];
        ?>
    </title>
    <script src="Script.js"></script>
</head>
<body>

    <label for="id">Item Id: </label>
    <input type="text" disabled name="id" id="id"
    <?php echo "value='$itemId'"; ?>
    />

    <label for="name">Item Name: </label>
    <input type="text" name="name" id="name"
    <?php echo "value='" . $item['name'] ."'"; ?>
    />

    <label for="describtion">Description: </label>
    <textarea name="describtion" id="description"><?php echo $describtion; ?></textarea>

    <label for="price">price: </label>
    <input type="number" name="price" min="1" id="price"
    <?php echo "value='" . $item['price'] ."'"; ?>
    />

    <label for="discount">discount: </label>
    <input type="number" name="discount" min="0" max="99" id="discount"
    <?php echo "value='" . $item['discount'] ."'"; ?>
    />

    <label for="stock">Stock: </label>
    <input type="number" name="stock" min="0" id="stock"
    <?php echo "value='" . $item['amount'] ."'"; ?>
    />

    <label for="brand">Brand: </label>
    <input type="text" name="brand" id="brand"
    <?php echo "value='" . $item['brand'] ."'"; ?>
    />

    <label for="cat">Category: </label>
    <input type="text" name="cat" id="cat"
    <?php echo "value='" . $item['tag'] ."'"; ?>
    />

    <button onclick="editItem()">Save</button>
    <span id="result"></span>

</body>
</html>