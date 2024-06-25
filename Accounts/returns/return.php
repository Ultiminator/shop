<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    $ms = "orders are stored for registered users only. ";
    $link = "<a href='../login'>login</a>";
    die($ms . $link);
}
$orders = [];
$items = [];
//load orders from db
$userId = $_SESSION['userId'];
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database");
}
$query = "select id from orders where userid = '$userId' ";
$query .= "and joindate <= current_date() and joindate >= current_date()-40 ";
$query .= "and stat = 4";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking oredrs in database");
}
if (mysqli_num_rows($result) == 0){
    $ms = "you can only return items from orders delivered in the last month ";
    $link = "<a href='../../'>start shopping</a>";
    die($ms . $link);
}
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row['id'];
}

foreach ($orders as $order) {
    $query = "select * from orderedItems where orderId = '$order' ";
    $query .= "and not exists (select * from returned where ";
    $query .= "returned.orderedItemId = orderedItems.id)";
    $result = mysqli_query($dbConn, $query);
    if (!$result){
        die("error while checking oredrs items in database");
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
if (empty($items)) {
    $ms = "it seems that you requested a return for all your recent items ";
    $link = "<a href='./index.php'>see returns</a>";
    die($ms . $link);
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
    if (mysqli_num_rows($result) == 0) {
        $items[$index]['name'] = "deleted item";
    }
    $row = mysqli_fetch_assoc($result);
    $items[$index]['name'] = $row['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return an item</title>
    <script src="./script.js"></script>
</head>
<body>
    <table>
        <tr>
            <td>
                <label for="item">Choose purchased item: </label>
            </td>
            <td>
            <select id="item" name="item">
                <?php
                foreach ($items as $item){
                    echo "<option value='" . $item['id'] . "'>";
                    echo $item['name'] . " : " . $item['price'];
                    echo "</option>";
                }
                ?>
            </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="cuase">The cause of return: </label>
            </td>
            <td>
                <textarea name="cause" id="cause"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button onclick="confirmReturn()">Confirm</button>
            </td>
        </tr>
        <tr>
            <td>
                <span id="result"></span>
            </td>
        </tr>
    </table>
    
</body>
</html>
