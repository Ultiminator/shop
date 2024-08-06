<?php
//get variables
$returnId = $_POST['returnId'];
$phone = $_POST['phone'];
$status = $_POST['status'];
$sort = $_POST['sort'];
$orderBy = $_POST['orderBy'];

//connect to db
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
//construct query
$query = "select * from returned where stat like '%$status' ";
if (!empty($returnId)){
    $query .= "and id = '$returnId' ";
}
if (!empty($phone)){
    $query .= "and orderId in (select id from orders where phone = '$phone') ";
}
$query .= "order by $sort $orderBy";
//excute query
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
if(mysqli_num_rows($result) == 0) {
    die("nothing found");
}
//prepare the table to display data if present
echo "<tr>";
echo "<td>N</td>";
echo "<td>id</td>";
echo "<td>Created</td>";
echo "<td>Status</td>";
echo "<td>Edit</td>";
echo "</tr>";
//print the data
$count = 1;
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>$count</td>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['joindate'] . "<br>" . $row['jointime'] . "</td>";
    switch ($row['stat']) {
        case 0 :
            echo "<td>Pending</td>";
            break;
        case 1 :
            echo "<td>Confirmed</td>";
            break;
        case 2 :
            echo "<td>Checking</td>";
            break;
        case 3 :
            echo "<td>Accepted</td>";
            break;
        case 4 :
            echo "<td>Refunded</td>";
            break;
        case 5 :
            echo "<td>Rejected</td>";
            break;
        
    }
    echo "<td><a href='return.php?id=" . $row['id'] . "'>edit</a></td>";
    echo "</tr>";
    $count++;
}

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);
?>