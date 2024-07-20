<?php
//check if admin logged
session_start();
if(!isset($_SESSION['adminId'])){
    header('location: ../login');
}

//check if there is order id parameter
if (!isset($_GET['id'])){
    $ms = "you didn't provide any order id. ";
    $link = "<a href='./index.php'>Return to orders</a>";
    die($ms . $link);
}

//prepare variables
$orderId = $_GET['id'];
$order = [];
$items = [];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}

//load order details
$query = "select * from orders where id = '$orderId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while loading the order from database");
}
if(mysqli_num_rows($result) == 0) {
    die("No such order");
}
$order = mysqli_fetch_assoc($result);

//load order items
$query = "select items.id, items.name, items.amount, orderedItems.quantity, ";
$query .= "orderedItems.price, returned.id as returned from ((items ";
$query .= "inner join orderedItems on items.id = orderedItems.itemId) ";
$query .= "left join returned on returned.orderedItemId = orderedItems.id) ";
$query .= "where orderedItems.orderId = '$orderId'";
//$query = "select itemId, quantity, price from orderedItems where orderId = '$orderId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while loading the ordered items from database");
}
while ($row = mysqli_fetch_assoc($result)){
    $items[] = $row;
}

//load items details
//nevermind I loaded it in the previous query with inner join

//check if any items were returned
//nevermin again I added another layer of left join to the previous query haha

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <script src="./script.js"></script>
</head>
<body>
    <!-- table to show order info -->
     <table>
        <tr>
            <td>Order ID</td>
            <td>
                <?php
                echo $order['id'];
                ?>
            </td>
        </tr>
        <tr>
            <td>User ID</td>
            <td>
                <?php
                echo $order['userId'];
                ?>
            </td>
        </tr>
        <tr>
            <td>User Name</td>
            <td>
                <?php
                echo $order['userName'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>
                <?php
                echo $order['phone'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Adress</td>
            <td>
                <?php
                echo $order['adress'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Total</td>
            <td>
                <?php
                echo $order['price'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Created</td>
            <td>
                <?php
                //proper formate of ate and time
                $dt = strtotime($order['joindate'] . " " . $order['jointime']);
                echo date("D, d-m-Y", $dt) . "<br>" . date("h:i:s A", $dt);
                ?>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <?php
                switch ($order['stat']) {
                    case 0 :
                        echo "Pending";
                        break;
                    case 1 :
                        echo "Confirmed";
                        break;
                    case 2 :
                        echo "Ready";
                        break;
                    case 3 :
                        echo "Out for delivery";
                        break;
                    case 4 :
                        echo "Delivered";
                        break;
                    case 5 :
                        echo "Cancelled";
                        break;
                }
                ?>
            </td>
        </tr>
     </table>

    <!-- table to show ordered items info  -->
     <table>
        <tr>
            <td>No.</td>
            <td>Item ID</td>
            <td>Item Name</td>
            <td>Availbale</td>
            <td>Ordered Quantity</td>
            <td>Price</td>
            <td>Return request?</td>
        </tr>
        <!-- iterating thru items -->
        <?php
        $count = 1;
        foreach ($items as $item) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            $count++;
            //item id is a link refering to its page in admins edit
            echo "<td><a href='../editItem/?id=" . $item['id'] . "' ";
            echo "target='_blank'>" . $item['id'] . "</a></td>";
            //end of item name, resume the remaining columns
            //item name is a link refering to its page in main website
            echo "<td><a href='../../item.php?id=" . $item['id'] . "' ";
            echo "target='_blank'>" . $item['name'] . "</a></td>";
            //end of item name, resume the remaining columns
            echo "<td>" . $item['amount'] + $item['quantity'] . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>" . $item['price'] . "</td>";
            if (isset($item['returned'])) {
                //return id is a link refering to its page in admins retuns
                echo "<td><a href='../returns/?id=" . $item['returned'] . "' ";
                echo "target='_blank'>Request ID: " . $item['returned'] . "</a></td>";
                //TODO link refering to the return page
            }else {
                echo "<td>No</td>";
            }
        }
        ?>
    </table>

    <!-- select input and button to change the orer status -->
    <label for="status">Change order status: </label>
    <select name="status" id="status">
        <?php
        //this to not allow admins to change cancelled orders to void dilemmas with stock
        if ($order['stat'] == 5) {
            die();
        }
        $tempArr = ["Pending", "Confirmed", "Ready", "Delivering", "Delivered"];
        foreach ($tempArr as $key => $value) {
            if ($order['stat'] == $key) {
                continue;
            }
            echo "<option value='$key'>$value</option>";
        }
        ?>
    </select>
    <button onclick="changeStatus(<?php echo $orderId; ?>)">Confirm</button>
    <span id="statusResult"></span>

</body>
</html>