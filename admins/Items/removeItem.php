<?php
//get item id
$itemId = $_POST['itemId'];
//validate data
$itemId = handle_data($itemId);
if(invalidData($itemId)){
    die(invalidData($itemId));
}

//connect to the database
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if(mysqli_connect_errno()){
    die("can't connect to the database");
}
//first lets remove images entries from data base
$query = "delete from images where itemId = '$itemId'";
if(!mysqli_query($dbConn, $query)){
    die("error while deleting images from database");
}
//then let's remove the item entry from the database
$query = "delete from items where id = '$itemId'";
if(!mysqli_query($dbConn, $query)){
    die("error while deleting the item from database");
}
//now let's try to remove the directory from storage
$dir = "../../items/$itemId";
//check if the item exists or not
if(is_dir($dir)){
    //if exist, check its content into an array
    $objects = scandir($dir);
    //now try to delete each file in the directory
    foreach ($objects as $object){
        /* note that every director contains entries .. for parent dir
        and . for the dir itself so we will exclude them */
        if ($object !== "." && $object !== ".."){
            /* note that unlink function doesn't work with directories
            so if one of the contents is a dir, it will throw an error 
            so I will add a condition to stop if it is a dir and notify the user*/
            if(is_dir($dir . "/" . $object)){
                die("couldn't delete item dir as one of its contents is a dir");
            }else{
                //if it is a file, delete it
                unlink($dir . "/" . $object);
            }
        }
    }
    //after deleting all the contents now it should be empty and ready to be deleted
    if (!rmdir($dir)){
        echo "couldn't remove the directory for some reason";
    }
}
echo "success";

//free memory and close the connection
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