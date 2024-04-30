<?php
//start session to get the user Id
session_start();
$userId = handleData($_SESSION['userId']);
$adressId = handleData($_POST['adressId']);
//time to validate on the server
$invalid = invalidData($adressId, $userId);
if($invalid){
    die($invalid);
}

//connect to the database
require "../../variables.php";
//initiate connection
$dbconn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to the database");
}

//now try to delete the adress
$query = "delete from adresses where id = $adressId and userid = $userId";
if (!mysqli_query($dbconn, $query)) {
    die ("error while trying to delete the adress");
}

echo "success";


function handleData($data) {
    //this converts it to html special characters to prevent html or js injection
    //also i think sql injection is prevented automatically by using a variale in sql query
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function invalidData($adressId, $userId){
    if (empty($adressId) || empty($userId)){
        return "Ids required";
    }
    /*I think there is no need to check for spaces now as handleData functon
    removes them.. but just in case */
    if (preg_match("/^ +/", $adressId) || preg_match("/^ +/", $userId)){
        return "remove spaces!";
    }
    if (!preg_match("/^[0-9.]*$/", $adressId) || !preg_match("/^[0-9.]*$/", $userId)){
        return "wrong id";
    }
}
?>