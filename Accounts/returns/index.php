<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $ms = "orders and returns are stored for registered users only. ";
    $link = "<a href='../login'>login</a>";
    die($ms . $link);
}
$returns = [];
$userId = $_SESSION['userId'];
//load returns from db 
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
//ok.. we forgot to store user id in the returns database
//and i am lazy to fix it 
//so i am going to load orers of the user and from there load the returns
$query = "select id from orders where userid = '$userId'";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking oredrs in database");
}
if (mysqli_num_rows($result) == 0){
    $ms = "you didn't make any orders yet. ";
    $link = "<a href='../../'>start shopping</a>";
    die($ms . $link);
}
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row['id'];
}
//loaded orders. now to load all items
foreach ($orders as $orderId) {
    /*here i used multi layer inner join to get all datat I need from multiple 
      table in one query. I didnet select * because of confliction between columns names
      in different table. */
    $query = "select returned.id, returned.stat, returned.cause, returned.joindate as returnDate, ";
    $query .= "orderedItems.price, orderedItems.quantity, items.name, returned.orderId, ";
    $query .= "orders.joindate as orderDate, orders.userName, orders.adress, orders.phone ";
    $query .= "from (((returned inner join orders on orders.id = returned.orderId) ";
    $query .= "inner join orderedItems on returned.orderedItemId = orderedItems.id) ";
    $query .= "inner join items on orderedItems.itemId = items.id) ";
    $query .= "where returned.orderId = '$orderId'";
    $result = mysqli_query($dbConn, $query);
    if (!$result){
        die("error while checking oredered items in database");
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $returns[] = $row;
    }
}
if (empty($returns)){
    $ms = "you didn't make any return requests. ";
    $link = "<a href='../Orders'>return to orders</a>";
    die($ms . $link);
}
//now we have an array of each returned item with the info we need
unset ($orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns</title>
    <script src="./script.js"></script>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>The cause</th>
            <th>Request date</th>
            <th>Status</th>
            <th>order ID</th>
            <th>Price</th>
            <th>Adress</th>
            <th>Order date</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($returns as $return){
            echo "<tr>";
            echo "<td>" . $return['id'] . "</td>";
            echo "<td>" . $return['name'] . "</td>";
            echo "<td>" . $return['cause'] . "</td>";
            echo "<td>" . $return['returnDate'] . "</td>";
            switch ($return['stat']) {
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
                    echo "<td>refunded</td>";
                    break;
                case 5 :
                    echo "<td>Rejected</td>";
                    break;
                
            }
            echo "<td>" . $return['orderId'] . "</td>";
            echo "<td>";
            echo $return['price'] . " x " . $return['quantity'];
            echo "</td>";
            echo "<td>";
            echo $return['userName'] . "<br>";
            echo $return['adress'] . "<br>";
            echo $return['phone'];
            echo "</td>";
            echo "<td>" . $return['orderDate'] . "</td>";
            switch ($return['stat']) {
                case 0 :
                    echo "<td>";
                    echo "<button onclick='cancelReturn(" . $return['id'];
                    echo ")'>Cancel</button><br><span id='" . $return['id'];
                    echo "'></span></td>";
                    break;
                case 1 :
                    echo "<td>";
                    echo "<button onclick='cancelReturn(" . $return['id'];
                    echo ")'>Cancel</button><br><span id='" . $return['id'];
                    echo "'>waiting for the item</span></td>";
                    break;
                case 2 :
                    echo "<td>the item is being examined</td>";
                    break;
                case 3 :
                    echo "<td>Wait for a refund</td>";
                    break;
                case 4 :
                    echo "<td>Enjoy</td>";
                    break;
                case 5 :
                    echo "<td>wait  for your item<br>or pick it up</td>";
                    break;
                
            }
            echo "</tr>";
        }
        ?>
    </table>
    <a href="../Orders/">Orders</a>
</body>
</html>