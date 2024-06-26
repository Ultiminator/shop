<?php
$orderId = $_POST['orderId'];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
//change the order status to cancelled
$query = "update orders set stat = 5 where id = '$orderId'";
if (!mysqli_query($dbConn, $query)) {
    die("couldn't cancel order");
}
//now lets try to return the items to the stock 
//first lets get items info and its quantity
$items = [];
$query = "select itemId, quantity from orderedItems where orderId = '$orderId'";
$result = mysqli_query($dbConn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}
//well we have the items and the ordered quantity of each item
//now let's add this amount to the stock of each item
foreach ($items as $item) {
    $query = "select amount from items where id = " . $item['itemId'];
    $result = mysqli_query($dbConn, $query);
    $row = mysqli_fetch_assoc($result);
    $newAmount = $row['amount'] + $item['quantity'];
    $query = "update items set amount = '$newAmount' where id = " . $item['itemId'];
    mysqli_query($dbConn, $query);
}
echo "success";
?>