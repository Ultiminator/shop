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
$returnId = $_GET['id'];
$return = [];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}

//load order details
$query = "select returned.id, returned.orderId, returned.quantity as rAmount, ";
$query .= "returned.stat, returned.joindate, returned.jointime, items.name, ";
$query .= "orderedItems.price, orderedItems.quantity as oAmount, ";
$query .= "orderedItems.itemId, orders.userName, orders.adress, orders.phone, ";
$query .= "orders.joindate as oDate, orders.jointime as otime ";
$query .= "from ((returned inner join orderedItems on orderedItems.id ";
$query .= "= returned.orderedItemId) inner join orders on orders.id = ";
$query .= "returned.orderId) inner join items on orderedItems.itemId = ";
$query .= "items.id where returned.id = '$returnId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while loading the order from database");
}
if(mysqli_num_rows($result) == 0) {
    die("No such return request");
}
$return = mysqli_fetch_assoc($result);

//load items details
//nevermind I loaded it in the previous query with inner join

//load order details
//nevermin again I added another layer of left join to the previous query haha

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Return</title>
    <script src="./script.js"></script>
</head>
<body>
    <!-- table to show order info -->
     <table>
        <tr>
            <td>Return ID</td>
            <td>
                <?php
                echo $return['id'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Order ID</td>
            <td>
                <?php
                echo "<a href='../orders/order.php?id=";
                echo $return['orderId'];
                echo "'>" . $return['orderId'] . "</a>";
                ?>
            </td>
        </tr>
        <tr>
            <td>User Name</td>
            <td>
                <?php
                echo $return['userName'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>
                <?php
                echo $return['phone'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Adress</td>
            <td>
                <?php
                echo $return['adress'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Item</td>
            <td>
                <?php
                echo "<a href='../../Item.php?id=";
                echo $return['itemId'];
                echo "'>" . $return['name'] . "</a>";
                ?>
            </td>
        </tr>
        <tr>
            <td>Price (at time of order)</td>
            <td>
                <?php
                echo $return['price'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Ordered Quantity</td>
            <td>
                <?php
                echo $return['oAmount'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Returning</td>
            <td>
                <?php
                echo $return['rAmount'];
                ?>
            </td>
        </tr>
        <tr>
            <td>Order created on</td>
            <td>
                <?php
                //proper formate of ate and time
                $dt = strtotime($return['oDate'] . " " . $return['otime']);
                echo date("D, d-m-Y", $dt) . "<br>" . date("h:i:s A", $dt);
                ?>
            </td>
        </tr>
        <tr>
            <td>Return requested on</td>
            <td>
                <?php
                //proper formate of ate and time
                $dt = strtotime($return['joindate'] . " " . $return['jointime']);
                echo date("D, d-m-Y", $dt) . "<br>" . date("h:i:s A", $dt);
                ?>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <?php
                switch ($return['stat']) {
                    case 0 :
                        echo "Pending";
                        break;
                    case 1 :
                        echo "Confirmed";
                        break;
                    case 2 :
                        echo "Checking";
                        break;
                    case 3 :
                        echo "Accepted";
                        break;
                    case 4 :
                        echo "Refunded";
                        break;
                    case 5 :
                        echo "Rejected";
                        break;
                }
                ?>
            </td>
        </tr>
     </table>


    <!-- select input and button to change the return status -->
    <label for="status">Change return status: </label>
    <select name="status" id="status">
        <?php
        //this to not allow admins to change cancelled orders to void dilemmas with stock
        $tempArr = ["Pending", "Confirmed", "Checking", "Accepted", "Refunded", "Rejected"];
        foreach ($tempArr as $key => $value) {
            if ($return['stat'] == $key) {
                continue;
            }
            echo "<option value='$key'>$value</option>";
        }
        ?>
    </select>
    <button onclick="changeStatus(<?php echo $returnId; ?>)">Confirm</button>
    <span id="statusResult"></span>

</body>
</html>