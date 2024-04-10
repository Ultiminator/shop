<?php
//first get the data
$itemId = $_POST['id'];
$name = $_POST['name'];
$desc = $_POST['describtion'];
$price = $_POST['price'];
$disc = $_POST['discount'];
$amount = $_POST['amount'];
$brand = $_POST['brand'];
$cat = $_POST['cat'];

//TODO validate the data

//connect to the database
//get the DB info from variables file
require '../../variables.php';
//initiate connection
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
  die("can't connect to the database");
}
//check if the item already exist
$query = "select * from items where name = '$name' ";
//added id condition to prevent mistaking the old name as repetition
$query .= "and not id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if (!$result){
  die("error while checking the name in database");
}
if (mysqli_num_rows($result) != 0){
  die("item already exist with the same name");
}
//if passed the above conditions, upate item in data base
$query = "update items set name = '$name', brand = '$brand', tag = '$cat', ";
$query .= "price = '$price', discount = '$disc', amount = '$amount', ";
$query .= "joindate = current_date(), jointime = current_time() ";
$query .= "where id = '$itemId'";
if(!mysqli_query($dbConn, $query)){
    die('error while updating the item in database');
}
//if updated successfuly, try to update the description file
$dir = "../../items/" . $itemId;
//this will create the directory if not present for some reason
if(!is_dir($dir)){
    if(!mkdir($dir)){
        die("couldn't find the directory and failed to create it");
      }
}
$file = $dir . "/describe.txt";
$fileHandle = fopen($file, "w");
if(!$fileHandle){
  die("failed to open the description file to write in");
}
fwrite($fileHandle, $desc);
fclose($fileHandle);

echo "Item $name upated successfuly";

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);

//this function is used to validate the data
function invalidData(){
  //todo validate the data on server side
}
?>