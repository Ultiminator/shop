<?php
//get variables
$orderId = $_POST['orderId'];
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
$query = "select * from orders where stat like '%$status' ";
if (!empty($orderId)){
    $query .= "and id = '$orderId' ";
}
if (!empty($phone)){
    $query .= "and phone = '$phone' ";
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
echo "<td>Name</td>";
echo "<td>Phone</td>";
echo "<td>Adress</td>";
echo "<td>Total</td>";
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
    echo "<td>" . $row['userName'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['adress'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['joindate'] . "<br>" . $row['jointime'] . "</td>";
    switch ($row['stat']) {
        case 0 :
            echo "<td>Pending</td>";
            break;
        case 1 :
            echo "<td>Confirmed</td>";
            break;
        case 2 :
            echo "<td>Ready</td>";
            break;
        case 3 :
            echo "<td>Out for delivery</td>";
            break;
        case 4 :
            echo "<td>Delivered</td>";
            break;
        case 5 :
            echo "<td>Cancelled</td>";
            break;
        
    }
    echo "<td><a href='order.php?id=" . $row['id'] . "'>edit</a></td>";
    echo "</tr>";
    $count++;
}

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);
?>