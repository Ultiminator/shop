<?php
$itemId = $_POST['itemId'];
$cause = $_POST['cause'];
//todo validate data

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
//get order id from ordered item id
$query = "select orderId from orderedItems where id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking oredrs in database");
}
$row = mysqli_fetch_assoc($result);
$orderId = $row['orderId'];

//insert into returns
$query = "insert into returned (orderId, orderedItemId, cause) ";
$query .= "values($orderId, $itemId, '$cause')";
if(!mysqli_query($dbConn, $query)){
    die("error while creating return request in the database");
}
echo "success";
?>