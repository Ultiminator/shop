<?php
//get parameters
$orderId = $_POST['orderId'];
$newStat = $_POST["newStat"];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
//update order in database
$query = "update orders set stat = '$newStat' where id = '$orderId'";
if (!mysqli_query($dbConn, $query)){
    die("error while upating order Status");
}
echo "success";
?>