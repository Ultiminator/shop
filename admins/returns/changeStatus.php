<?php
//get parameters
$returnId = $_POST['returnId'];
$newStat = $_POST["newStat"];

//connect to database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
//get some info about the return and its item
$query = "select returned.stat, returned.quantity, items.id, items.amount from ";
$query .= "(returned inner join orderedItems on returned.orderedItemId = ";
$query .= "orderedItems.id) inner join items on orderedItems.itemId = ";
$query .= "items.id where returned.id = '$returnId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while loading the order from database");
}
if(mysqli_num_rows($result) == 0) {
    die("No such return request");
}
$row = mysqli_fetch_assoc($result);
//get current status 
$oldStat = $row['stat'];
//get current item amount in stock
$oldAmount = $row['amount'];
//get return quantity
$quantity = $row['quantity'];
//get item Id 
$itemId = $row['id'];

//update order in database
$query = "update returned set stat = '$newStat' where id = '$returnId'";
if (!mysqli_query($dbConn, $query)){
    die("error while upating return Status");
}

//increase stock amount if the item is accepted or refunded
if ($newStat == 3 || $newStat == 4) {
    //but only change it if it wasn't already accepted or refunded
    if ($oldStat != 3 && $oldStat != 4) {
        $newAmount = $oldAmount + $quantity;
        $query = "update items set amount = '$newAmount' where id = '$itemId'";
        if (!mysqli_query($dbConn, $query)){
            die("updated return status but failed to add to the stock");
        }
    }//else if it was already 3 or 4 do nothing
}else {//if the new status is not accepted or refunded, decrease the stock
    //but only if the old stt was accepte or refunded
    if ($oldStat == 3 || $oldStat == 4) {
        $newAmount = $oldAmount - $quantity;
        $query = "update items set amount = '$newAmount' where id = '$itemId'";
        if (!mysqli_query($dbConn, $query)){
            die("updated return status but failed to subtract from the stock");
        }
    }
}
echo "success";
?>