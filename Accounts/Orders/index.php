<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $ms = "orders are stored for registered users only. ";
    $link = "<a href='../login'>login</a>";
    die($ms . $link);
}
$orders = [];
$orderedItems = [];
//load orders from db
$userId = $_SESSION['userId'];
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
$query = "select * from orders where userid = '$userId'";
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
    $orders[] = $row;
}
//load items of each order
foreach ($orders as $key => $order){
    $items = [];
    $query = "select itemId, quantity from orderedItems where orderId = " . $order['id'];
    $result = mysqli_query($dbConn, $query);
    if (!$result){
        die("error while checking oredrs items in database");
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    foreach ($items as $index => $item) {
        $query = "select name from items where id = " . $item['itemId'];
        $result = mysqli_query($dbConn, $query);
        if (!$result){
            die("error while checking oredrs items in database");
        }
        if (mysqli_num_rows($result) > 1) {
            die("somthing fancy happened");
        }
        $row = mysqli_fetch_assoc($result);
        $items[$index]['name'] = $row['name'];
    }
    $orders[$key]['items'] = $items;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <script src="./script.js"></script>
</head>
<body>
    <table>
        <tr>
            <th>order Id</th>
            <th>Items</th>
            <th>Adress</th>
            <th>Total</th>
            <th>created</th>
            <th>status</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($orders as $order){
            echo "<tr>";
            echo "<td>" . $order['id'] . "</td>";
            echo "<td>";
            foreach ($order['items'] as $item) {
                echo $item['quantity'] . " x " . $item['name'] . "<br>";
            }
            echo "</td>";
            echo "<td>";
            echo $order['userName'] . "<br>";
            echo $order['adress'] . "<br>";
            echo $order['phone'];
            echo "</td>";
            echo "<td>" . $order['price'] . "</td>";
            echo "<td>";
            echo $order['joindate'] . "<br>";
            echo $order['jointime'];
            echo "</td>";
            switch ($order['stat']) {
                case 0 :
                    echo "<td>Pending</td>";
                    echo "<td>";
                    echo "<button onclick='cancelOrder(" . $order['id'];
                    echo ")'>Cancel</button><br><span id='" . $order['id'];
                    echo "'></span></td>";
                    break;
                case 1 :
                    echo "<td>Confirmed</td>";
                    echo "<td>";
                    echo "<button onclick='cancelOrder(" . $order['id'];
                    echo ")'>Cancel</button><br><span id='" . $order['id'];
                    echo "'></span></td>";
                    break;
                case 2 :
                    echo "<td>Ready</td>";
                    echo "<td>";
                    echo "<button onclick='cancelOrder(" . $order['id'];
                    echo ")'>Cancel</button><br><span id='" . $order['id'];
                    echo "'></span></td>";
                    break;
                case 3 :
                    echo "<td>Out for delivery</td>";
                    echo "<td>Complete the order first</td>";
                    break;
                case 4 :
                    echo "<td>Delivered</td>";
                    echo "<td>Enjoy</td>";
                    break;
                case 5 :
                    echo "<td>Cancelled</td>";
                    echo "<td>Sorry for that</td>";
                    break;
                
            }
            echo "</tr>";
        }
        ?>
    </table>
    <a href="../returns/return.php">request a return</a>
    <a href="../returns/"> Manage returns</a>
</body>
</html>