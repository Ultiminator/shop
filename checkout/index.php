<?php
//start session to get the stored data
session_start();
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
if (empty($chart)){
    die("your chart is empty!");
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
        $item['name'] = $row['name'];
        $discount = ($row['discount'] / 100) * $row['price'];
        $item['price'] = $row['price'] - $discount;
    }
    $items[$itemId] = $item;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>
    <script src="./script.js"></script>
</head>
<body>

    <h1>Order Items</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php
        foreach ($items as $itemId => $item){
            echo "<tr>";
            echo "<td><a id='$itemId' href='../../item.php?id=$itemId'>";
            echo $item['name'];
            echo "</a></td>";
            echo "<td>" . $item['price'] . "</td>";
            echo "<td>x" . $item['qnty'] . "</td>";
            $subtotal = $item['price'] * $item['qnty'];
            echo "<td>" . $subtotal . "</td>";
            $total += $subtotal;
        }
        ?>
        <tr>
            <td colspan="3">Total</td>
            <td><?php echo $total; ?></td>
        </tr>
    </table>

    <h1>shiping adress</h1>
    <table>
        <tr>
            <td>
                <label for="name">Your Name:</label>
            </td>
            <td>
                <input type="text" name="name" id="name">
            </td>
        </tr>
        <tr>
            <td>
                <label for="adress">Adress:</label>
            </td>
            <td>
                <textarea name="adress" id="adress"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="phone">Phone:</label>
            </td>
            <td>
                <input type="text" name="phone" id="phone">
            </td>
        </tr>
    </table>

    <h1>Billing: </h1>
    <p>currently we accept "pay on delivery" only.</p>

    <h1>Cost:</h1>
    <table>
        <tr>
            <td>subtotal: </td>
            <td><?php echo $total; ?></td>
        </tr>
        <tr>
            <td>shiping: </td>
            <td><?php echo $shiping; ?></td>
        </tr>
        <tr>
            <td>Total: </td>
            <td><?php echo $total + $shiping; ?></td>
        </tr>
    </table>

    <button onclick="confirmOrder()">Confirm Order</button>
    <span id="result"></span>
    
</body>
</html>

<?php
if (isset($result)){
    mysqli_free_result($result);
}
mysqli_close($dbConn);
?>