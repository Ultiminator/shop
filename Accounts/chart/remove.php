<?php
//start session to check for login and get data
session_start();
$itemId = $_POST['itemId'];
if (!isset($_SESSION['loggedin'])){
    //get data from session
    if ($itemId == 0){
        unset($_SESSION['items']);
    }else {
        if(isset($_SESSION['items'][$itemId])){
            unset($_SESSION['items'][$itemId]);
        }
    }
}else{
    //get data from the db
    $userId = $_SESSION['userId'];
    require "../../variables.php";
    $dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
    if (mysqli_connect_errno()){
        die ("error while connecting to the database");
    }
    $query = "delete from basket where userId = '$userId'";
    if (!$itemId == 0){
        $query .= " and itemId = '$itemId'";
    }
    if (!mysqli_query($dbConn, $query)){
        die("error while deleting from database");
    }

}
echo "success";
?>