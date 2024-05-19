<?php
//start session to get the stored data
session_start();
$chart = [];
$items = [];
$total = 0;
$available = true;
//connect to db
require "../../variables.php";
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
        $item['name'] = "deleted item";
        $item['price'] = 0;
        $item['aavilable'] = 0;
        $available = false;
    }else {
        $row = mysqli_fetch_assoc($result);
        $item['name'] = $row['name'];
        $discount = ($row['discount'] / 100) * $row['price'];
        $item['price'] = $row['price'] - $discount;
        $item['available'] = $row['amount'];
        if ($qnty > $item['available']){
            $available = false;
        }
    }
    $items[$itemId] = $item;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart</title>
    <script src="./script.js"></script>
</head>
<body>
    <span id="result"></span>
    <table>
        <tr>
            <th>X</th>
            <th>Name</th>
            <th>Price</th>
            <th>Available</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php
        foreach ($items as $itemId => $item){
            echo "<tr>";
            echo "<td>";
            echo "<button onclick='removeItem($itemId)'>X</button>";
            echo "</td>";
            echo "<td><a id='$itemId' href='../../item.php?id=$itemId'>";
            echo $item['name'];
            echo "</a></td>";
            echo "<td>" . $item['price'] . "</td>";
            echo "<td>" . $item['available'] . "</td>";
            echo "<td>x" . $item['qnty'] . "</td>";
            $subtotal = $item['price'] * $item['qnty'];
            echo "<td>" . $subtotal . "</td>";
            $total += $subtotal;
        }
        ?>
        <tr>
            <td>
                <button onclick="removeItem(0)">X</button>
            </td>
            <td colspan="4">Total</td>
            <td><?php echo $total; ?></td>
        </tr>
    </table>
    <?php
    echo "<button onclick='checkout()' id='checkout'";
    if (!$available){
        echo " disabled>chekout</button>";
        echo "<p>some of your items are not available in the amount you want</p>";
    }else {
        echo ">checkout</button>";
    }
    ?>
</body>
</html>

<?php
if (isset($result)){
    mysqli_free_result($result);
}
mysqli_close($dbConn);
?>