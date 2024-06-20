<?php
//start session to get the stored data
session_start();
//get sent parameters
$name = $_POST['name'];
$adress = $_POST['adress'];
$phone = $_POST['phone'];
//todo validate data

//prepare important variables
$userId = 0;
$chart = [];
$items = [];
$total = 0;
$shiping = 50;
//connect to db
require "../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die ("error while connecting to the database");
}

//load items in the chart
if (!isset($_SESSION['loggedin'])) {
    //get data from session
    if (isset($_SESSION['items'])){
        $chart = $_SESSION['items'];
    }
}else {
    //get data from database
    $userId = $_SESSION['userId'];
    $query = "select * from basket where userId = '$userId'";
    $result = mysqli_query($dbConn,$query);
    if (!$result){
        die("error while checking data in basket table");
    }
    while ($row = mysqli_fetch_assoc($result)){
        $chart[$row['itemId']] = $row['quantity'];
    }
}

//get items info
foreach ($chart as $itemId => $qnty){
    $item['qnty'] = $qnty;
    $query = "select * from items where id = '$itemId'";
    $result = mysqli_query($dbConn, $query);
    if (!$result){
        die("error while checking data in items table");
    }
    if (mysqli_num_rows($result) == 0){
        die("some of your items arn't available at the moment. return to chart");
    }else {
        $row = mysqli_fetch_assoc($result);
        $item['available'] = $row['amount'];
        if ($qnty > $item['available']){
            die("some of your items arn't available at the moment. return to chart");
        }
        //$item['name'] = $row['name']; don't need it in this page
        $discount = ($row['discount'] / 100) * $row['price'];
        $item['price'] = $row['price'] - $discount;
        $total += $item['price'] * $qnty;
    }
    $items[$itemId] = $item;
}

//try to create new order in database
$query = "insert into orders(userId, userName, adress, phone, price) ";
$query .= "values($userId, '$name', '$adress', '$phone', " . ($total + $shiping) . ")";
if (mysqli_query($dbConn, $query)){
    //if succeeded, get the last order id added
    $orderId = mysqli_insert_id($dbConn);
}else {
    die("error while adding the order to database");
}

//clear chart 
/*I tried clearing it after adding the items to ordered items table below 
but some strange error happened becuase mysqli_multi_query
obviously it is still excuting when I call this query
so I called it before the multi query. otherwise, loop through
queries and don't use multi query*/
unset($_SESSION['items']);
$query = "delete from basket where userId = $userId;";
if(!mysqli_query($dbConn, $query)){
    die(mysqli_error($dbConn));
}

//add the items to ordered items table and refer to the last added order
$query = "";
foreach ($items as $itemId => $item){
    $query .= "insert into orderedItems(orderId, itemId, quantity, price) ";
    $query .= "values($orderId, $itemId, " . $item['qnty'];
    $query .= ", " . $item['price'] . "); ";
    //this to subtract the quantity of the items from the store
    $newAmount = $item['available'] - $item['qnty'];
    $query .= "update items set amount = '$newAmount' where id = '$itemId'; ";
}
if(!mysqli_multi_query($dbConn, $query)){
    die("error while ading the items to ordered items in database");
}
echo "success";

//close connection with db
mysqli_close($dbConn);
?>