<?php
$orderId = $_POST['orderId'];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
//check status of the order
$query = "update orders set stat = 5 where id = '$orderId'";
if (!mysqli_query($dbConn, $query)) {
    die("couldn't cancel order");
}
echo "success";
?>