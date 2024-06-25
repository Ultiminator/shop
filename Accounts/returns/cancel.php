<?php
$returnId = $_POST['returnId'];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
//check status of the order
$query = "delete from returned where id = '$returnId'";
if (!mysqli_query($dbConn, $query)) {
    die("couldn't cancel return");
}
echo "success";
?>