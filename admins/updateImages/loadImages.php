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
//get images ids
$query = "select * from images where itemId = '$itemId' order by id";
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
while ($row = mysqli_fetch_assoc($result)){
    $images[] = $row['id'] . "." . $row['extension'];
}
$dir = "../../items/$itemId/";

for ($i=0; $i < 5; $i++) { 
    echo "<tr>";
    echo "<td>image " . $i+1 . "</td>";
    if (isset($images[$i])){
        echo "<td>";
        echo "<img src='$dir$images[$i]' style='width: 100px;' ";
        echo "onclick='displayImg(\"$dir$images[$i]\")'>";
        echo "</td>";
        echo "<td>";
        echo "<button ";
        echo "onclick='removeImg(\"$itemId\", \"$images[$i]\", $i)'>";
        echo "Remove</button>";
        echo "</td>";
    }else {
        echo "<td>Not present</td>";
        echo "<td>";
        echo "<label for='image$i'>Add: </label>";
        echo "<input type='file' name='image$i' ";
        echo "id='image$i' accept='image/*' ";
        echo "onchange='addImg(this, \"$itemId\", $i)'>";
        echo "</td>";
    }
    echo "<td id='result$i'></td>";
    echo "</tr>";
}

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