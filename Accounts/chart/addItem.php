<?php
session_start();
//get item data
$itemId = $_POST['itemId'];
$qnty = $_POST['qnty'];

//conect to the database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die ("error while connecting to the database");
}
$query = "select * from items where id = $itemId";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking item data in database");
}
if (mysqli_num_rows($result) == 0){
    die("no such item");
}
$item = mysqli_fetch_assoc($result);
if ($qnty > $item['amount']){
    die("the amount you want to add is not available");
}

//store in the chart
if (!isset($_SESSION['loggedin'])) {
    //store in session
    if(!isset($_SESSION['items'][$itemId])){
        $_SESSION['items'][$itemId] = $qnty;
    }else {
        $oldQnty = $_SESSION['items'][$itemId];
        $newQnty = $oldQnty + $qnty;
        if ($newQnty > $item['amount']){
            die("the amount you want is not available");
        }
        $_SESSION['items'][$itemId] = $newQnty;
    }
}else {
    //store in database
    $userId = $_SESSION['userId'];
    //check if the user added the item before
    $query = "select * from basket where itemId = '$itemId' and userId = '$userId'";
    $result = mysqli_query($dbConn, $query);
    if (!$result){
        die("error while checking chart data in database");
    }
    if (mysqli_num_rows($result) == 0){
        //add item
        $query = 'insert into basket (userId, itemId, quantity) ';
        $query .= "values ('$userId', '$itemId', '$qnty')";
        if (!mysqli_query($dbConn, $query)){
            die('failed to add the item to the database');
        }
    }else {
        //increase item amount
        $row = mysqli_fetch_assoc($result);
        $oldQnty = $row['quantity'];
        $newQnty = $oldQnty + $qnty;
        if ($newQnty > $item['amount']){
            die("the amount you want is not available");
        }
        $query = "update basket set quantity = $newQnty where id = " . $row['id'];
        if (!mysqli_query($dbConn, $query)){
            die('failed to add the item to the database');
        }
    }
}
echo "success";

mysqli_free_result($result);
mysqli_close($dbConn);
?>