<?php
//start session to get the stored data
session_start();
if (!isset($_SESSION['loggedin'])) {
    die("please login first");
}
//get the password and email
$password = $_POST['password'];
$newemail = $_POST['newemail'];

//time to validate
$newemail = handle_data($newemail);
//$password = handle_data($password); removed this because it trims spaces without warning
//had to use this because can't use the whole handle_data function
$password = htmlspecialchars($password);
//but remember the above function will store password as html special chars
//so do not forget to use it in login too
if (invalidData($newemail, $password)){
    die(invalidData($newemail, $password));
}


//time to connect to the database
require "../../variables.php";
$dbConnection = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
//construct the query
$query = "select * from accounts where id = " . $_SESSION['userId'];
$result = mysqli_query($dbConnection, $query);
if (!$result){
    die ('error checking the user data');
}
if (mysqli_num_rows($result) == 0){
    die ("something is wrong, please login again");
}
/*this will check if mysql returned more than one row (which shoudn't happen
because the feild "id" is unique), just in case..*/
if (mysqli_num_rows($result) > 1){
    die("something fancy happened");
}
//getting the result
$row = mysqli_fetch_assoc($result);
//test password against the database
if($password != $row['pass']){
    die ("password is incorrect");
}
if ($newemail == $row['email']){
    die ("why did you enter the same email address?");
}
//at this moment every thing seems ok
//time to update the email
$query = "update accounts set email = '$newemail' where id = " . $_SESSION['userId'];
if (mysqli_query($dbConnection, $query)) {
    echo "email updated successfully";
}else {
    echo "error:" . mysqli_error($dbConnection);
}
//free the memory
mysqli_free_result($result);
//close the connection
mysqli_close($dbConnection);

function handle_data($data) {
    //this converts it to html special characters to prevent html or js injection
    //also i think sql injection is prevented automatically by using a variale in sql query
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function invalidData($email, $password){
    if (empty($email) || empty($password)){
        return "required!";
    }
    if (preg_match("/^ +/", $email) || preg_match("/^ +/", $password)){
        return "remove spaces!";
    }
    if (strlen($email) < 7 || strlen($email) > 255){
        return "7 to 255 characters!";
    }
    if (strlen($password) < 8 || strlen($password) > 30){
        return "password should be 8 to 30 characters!";
    }
    if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)){
        return "wrong email0!";
    }
}
?>