<?php
//starting session to store login
session_start();
//retrive data
$name = $_POST["name"];
$password = $_POST["password"];
//creating an oject to store the response
$responseObj = new stdClass();

//validation time
$name = handle_data($name);
//$password = handle_data($password); removed this because it trims spaces without warning
//had to use this because can't use the whole handle_data function
$password = htmlspecialchars($password);
//but remember the above function will store password as html special chars
//so do not forget to use it in sign up page too
if (invalidData($name, $password)){
    $responseObj->message = invalidData($name, $password);
    die(json_encode($responseObj));
}

//connect to database
//first get the DB info
require "../../variables.php";
//initiate connection
$dbConnection = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    $responseObj->message = "can/t connect to the database";
    die(json_encode($responseObj));
}
//checking the account name in database
$query = "select * from Admins where name = binary '$name'";
$result = mysqli_query($dbConnection, $query);
if (!$result){
    $responseObj->message = "error while checking the name";
    die(json_encode($responseObj));
}
if(mysqli_num_rows($result) ==0){
    $responseObj->message = "there is no such name";
    die(json_encode($responseObj));
}
/*this will check if mysql returned more than one row (which shoudn't happen
because the feild "name" is unique), just in case..*/
if (mysqli_num_rows($result) > 1){
    $responseObj->message = "something fancy happened";
    die(json_encode($responseObj));
}

//if passed all of the above, get the data from the $result
$row = mysqli_fetch_assoc($result); // first row of the returned table
//check if the password is correct
if($password != $row['pass']){
    $responseObj->message = "Account name or password is not correct";
    die(json_encode($responseObj));
}else{
    $responseObj->message = 'success';
    $responseObj->id = $row['id'];
    $responseObj->name = $row['name'];
    $responseObj->email = $row['email'];
    $responseObj->redirect = '../';
    echo json_encode($responseObj);
    //stor logged in session
    $_SESSION['loggedin'] = true;
    $_SESSION['adminId'] = $row['id'];
    $_SESSION['adminName'] = $row['name'];
    $_SESSION['adminEmail'] = $row['email'];
}
//free memory
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

function invalidData($name, $password){
    if (empty($name) || empty($password)){
        return "required!";
    }
    if (preg_match("/^ +/", $name) || preg_match("/^ +/", $password)){
        return "remove spaces!";
    }
    if (strlen($name) < 4 || strlen($name) > 30){
        return "4 to 30 characters!";
    }
    if (strlen($password) < 8 || strlen($password) > 30){
        return "password should be 8 to 30 characters!";
    }
    //added space to the regex to allow spaces
    if (!preg_match("/^[a-zA-Z0-9- _@.]*$/", $name)){
        return "wrong characters!";
    }
}

//end of the file
?>