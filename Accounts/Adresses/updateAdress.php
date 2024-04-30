<?php
//lets get data
session_start();
$userId = handleData($_SESSION['userId']);
$adressId = handleData($_POST['adressId']);
$name = handleData($_POST['name']);
$phone = handleData($_POST['phone']);
$adress = handleData($_POST['adress']);
//lets validate
$invalid = invalidData($adressId, $name, $phone, $adress);
if($invalid){
    die($invalid);
}

//conncet to db
require "../../variables.php";
//initiate connection
$dbconn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to the database");
}

//checking the number of adresses associated to the user
$query = "select * from adresses where userId = '$userId'";
$result = mysqli_query($dbconn, $query);
if (!$result){
    die("error while checking adresses in database");
}
$adressesNum = mysqli_num_rows($result);

//check if we are adding or editing adress;
if ($adressId === "000") {
    //this means we are adding a new adress
    if($adressesNum >= 5){
        die("you can't add more than 5 adress for the same user");
    }
    $query = "insert into adresses (userId, name, phone, adress) ";
    $query .= "values ('$userId', '$name', '$phone', '$adress')";
}else{
    //this means we are editing an existing adress
    $query = "update adresses set name = '$name', phone = '$phone', ";
    $query .= "adress = '$adress' where id = '$adressId' ";
    /*this addition checks if the adress belongs to the user in case of
    something fancy happend */
    $query .= "and userId = '$userId'";
}
//performing the query
if(!mysqli_query($dbconn, $query)){
    die("error while adding or saving the item");
}
echo "success";

//free memory
mysqli_free_result($result);
//close the connection
mysqli_close($dbconn);


function handleData($data) {
    //this converts it to html special characters to prevent html or js injection
    //also i think sql injection is prevented automatically by using a variale in sql query
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function invalidData($id, $name, $phone, $adress){
    if (empty($id) || empty($name) || empty($phone) || empty($adress)){
        return "all fields required";
    }
    /*I think there is no need to check for spaces now as handleData functon
    removes them.. but just in case */
    if (preg_match("/^ +/", $id) || preg_match("/^ +/", $name)){
        return "remove spaces!";
    }
    if (strlen($name) < 5 || strlen($name) > 100){
        return "name is short or long";
    }
    if (strlen($phone) < 4 || strlen($phone) > 30){
        return "phone is short or long";
    }
    if (strlen($adress) < 10 || strlen($adress) > 255){
        return "adress is short or long";
    }
    if (!preg_match("/^[0-9.]*$/", $id) || !preg_match("/^[0-9.]*$/", $phone)){
        return "wrong phone";
    }
}
?>