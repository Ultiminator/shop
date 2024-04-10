<?php
//first get the data
$name = $_POST['name'];
$desc = $_POST['describtion'];
$price = $_POST['price'];
$disc = $_POST['discount'];
$amount = $_POST['amount'];
$brand = $_POST['brand'];
$cat = $_POST['category'];
$images = $_FILES['images'];

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
$query = "select * from items where name = '$name'";
$result = mysqli_query($dbConn, $query);
if (!$result){
  die("error while checking the name in database");
}
if (mysqli_num_rows($result) != 0){
  die("item already exist with the same name");
}
//if passed the above conditions, insert new item in data base
$query = "insert into items (name, brand, tag, price, discount, amount)";
$query .= "values('$name', '$brand', '$cat', '$price', '$disc', '$amount')";
if(!mysqli_query($dbConn, $query)){
  die('error while adding the item to database');
}
//if inserted successfully, creat a new directory for the item
$lastItemId = mysqli_insert_id($dbConn);
$dir = "../../items/" . $lastItemId;
if(!mkdir($dir)){
  die("failed to create the directory");
}
//then try to create describtion file
$file = $dir . "/describe.txt";
$fileHandle = fopen($file, "w");
if(!$fileHandle){
  die("failed to open the description file to write in");
}
fwrite($fileHandle, $desc);
fclose($fileHandle);

//now let's add the images
foreach ($images['name'] as $key => $value){
  //for each uploaded image, insert a new entry to the database
  $extention = pathinfo($images['name'][$key], PATHINFO_EXTENSION);
  $query = "insert into images(itemId, extension) ";
  $query .="values('$lastItemId', '$extention')";
  if(!mysqli_query($dbConn, $query)){
    die("error while adding the images to database");
  }
  //if inserted, get the id to use it as a name for the image and save it
  $lastImageId = mysqli_insert_id($dbConn);
  $imageName = $dir . "/$lastImageId." . $extention;
  move_uploaded_file($images['tmp_name'][$key], $imageName);
}
echo "Item $name added successfuly";

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);

//this function is used to validate the data
function invalidData(){
  //todo validate the data on server side
}
?>