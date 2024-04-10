<?php
//get data
$itemId = $_POST['itemId'];
$image = $_FILES['image'];

//validate data
$itemId = handle_data($itemId);
$invalidData = invalidData($itemId, $image);
if($invalidData){
    die($invalidData);
}

//prepare item directory and image name
$dir = "../../items/$itemId/";
$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
$imageName = "";
//create the directory if not exist for some reason
if(!is_dir($dir)){
    if(!mkdir($dir)){
        die("directory not found and failed to creat it");
      }
}

//connect to the database
require '../../variables.php';
//initiate connection
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the database");
}
//check if the item exist
$query = "select * from items where id = '$itemId'";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking the name in database");
}
if (mysqli_num_rows($result) == 0){
    die("item not found in database");
}
//check if there is 5 or more images for the same item in db
$query = "select * from images where itemId = '$itemId'";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking the images of the item in database");
}
if (mysqli_num_rows($result) >= 5){
    die("you can't add more than 5 images for the same item");
}

//if passed all of the above insert new record for the image in the database
$query = "insert into images(itemId, extension) ";
$query .="values('$itemId', '$extension')";
if(!mysqli_query($dbConn, $query)){
    die("error while adding the image to database");
}
//if inserted, get the id to use it as a name for the image and save it
$lastImageId = mysqli_insert_id($dbConn);
$imageName = $dir . "/$lastImageId." . $extension;
move_uploaded_file($image['tmp_name'], $imageName);

//send success to the front end
echo "success";

//free memory and close the connection
mysqli_free_result($result);
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
function invalidData($itemId, $image){
    if (empty($itemId)){
        return "required!";
    }
    if (preg_match("/^ +/", $itemId)){
        return "remove spaces!";
    }
    if (!preg_match("/^[0-9.]*$/", $itemId)){
        return "wrong characters!";
    }
    //this is to check if the user somehow sent more than 1 image 
    if (isset($image['size'][0])){
        return "please select only one image";
    }
    //check if the file is an image
    if (str_starts_with($image['type'], "Image/")){
        return "please select only images";
    }
    //and size
    if ($image['size'] > 1048576) {
        return "image is greater than 1 MB";
    }
}
?>