<?php
//get item id
$imageId = $_POST['imageId'];
//validate data
$imageId = handle_data($imageId);
if(invalidData($imageId)){
    die(invalidData($imageId));
}

//connect to the database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if(mysqli_connect_errno()){
    die("can't connect to the database");
}
//get image from data base and prepare the directory
$query = "select * from images where id = '$imageId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
if(mysqli_num_rows($result) == 0) {
    die("image wasn't found in the database");
}
$row = mysqli_fetch_assoc($result);
$dir = "../../items/" . $row['itemId'] . "/";
$imageName =$dir . $row['id'] . "." . $row['extension'];

//delete the image record from database
$query = "delete from images where id = '$imageId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while deleting image from database");
}
//delete the image file from storage
if(file_exists($imageName)){
    unlink($imageName);
}
echo "success";

//free memory and close the connection
/*apparently the below comand doesn't work when the last
  query is deletion from database.*/
//mysqli_free_result($result);
mysqli_close($dbConn);

//function to sanitize data
function handle_data($data) {
    //this converts it to html special characters to prevent html or js injection
    //also i think sql injection is prevented automatically by using a variale in sql query
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
//function to validate data
function invalidData($itemId){
    if (empty($itemId)){
        return "required!";
    }
    if (preg_match("/^ +/", $itemId)){
        return "remove spaces!";
    }
    if (!preg_match("/^[0-9.]*$/", $itemId)){
        return "wrong characters!";
    }
}
?>