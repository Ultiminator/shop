<?php
//redirect to home page if no itemId is sent
if (!isset($_GET['id'])){
    header("location: ../");
}
$itemId = $_GET['id'];
//time to validate the ata
$itemId = handle_data($itemId);
$invalidId = invalidData($itemId);
if ($invalidId){
    die($invalidId);
}

//connect to database
require "./variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("error while connecting to database <a href='../'>home</a>");
}
$query = "select * from items where id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database <a href='../'>home</a>");
}
if (mysqli_num_rows($result) == 0){
    die("Item Not Found <a href='../'>home</a>");
}
$item = mysqli_fetch_assoc($result); 

//read describtion file
$dir = "./items/" . $itemId;
//this will create the directory if not present for some reason
if(!is_dir($dir)){
    if(!mkdir($dir)){
        die("couldn't find the directory and failed to create it");
      }
}
$fileName = $dir . "/describe.txt";
if (file_exists($fileName)){
    $fileHandle = fopen($fileName,'r');
    if($fileHandle){
        /* added 1 to file size because if the file is empty for some reason,
        it will return an error as fread function can't take 0 as 2nd parameter*/
        $description = fread($fileHandle, filesize($fileName) + 1);
        fclose($fileHandle);
    }else {
        $description = "couldn't open file";
    }
}else {
    $description = "couldn't find description";
}

echo $itemId . $item['id'] . $description;


function handle_data($data) {
    //this converts it to html special characters to prevent html or js injection
    //also i think sql injection is prevented automatically by using a variale in sql query
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function invalidData($itemId){
    if (empty($itemId)){
        return "no provided item data! <a href='../'>home</a>";
    }
    if (preg_match("/^ +/", $itemId)){
        return "remove spaces! <a href='../'>home</a>";
    }
    if (!preg_match("/^[0-9]*$/", $itemId)){
        return "wrong characters! <a href='../'>home</a>";
    }
}
?>