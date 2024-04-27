<?php
//start session to get the stored data
session_start();
if (!isset($_SESSION['loggedin'])) {
    die("please login first");
}
//get the passwords
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];
$repassword = $_POST['repassword'];

//time to validate
//$password = handle_data($password); removed this because it trims spaces without warning
//had to use this because can't use the whole handle_data function
$password = htmlspecialchars($password);
$newpassword = htmlspecialchars($newpassword);
$repassword = htmlspecialchars($repassword);
//but remember the above function will store password as html special chars
//so do not forget to use it in login too
if (invalidData($password)){
    die(invalidData($password));
}
if (invalidData($newpassword)){
    die(invalidData($newpassword));
}

//test the passwords
//first check if the new passwords are matching
if ($newpassword != $repassword){
    die("passwords don't match");
}
//also check the new password is different from the currunt one
if ($newpassword == $password) {
    die("the new password must be different");
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
//test password again ut this time against the database
if($password != $row['pass']){
    die ("password is incorrect");
}
//at this moment every thing seems ok
//time to update the password
$query = "update accounts set pass = '$newpassword' where id = " . $_SESSION['userId'];
if (mysqli_query($dbConnection, $query)) {
    echo "password updated successfully";
}else {
    echo "error:" . mysqli_error($dbConnection);
}
//free the memory
mysqli_free_result($result);
//close the connection
mysqli_close($dbConnection);

function invalidData($password){
    if (empty($password)){
        return "required!";
    }
    if (preg_match("/^ +/", $password)){
        return "remove spaces!";
    }
    if (strlen($password) < 8 || strlen($password) > 30){
        return "password should be 8 to 30 characters!";
    }
}
?>