<?php
//starting session to store login
session_start();
//retrive data
$email = $_POST["email"];
$password = $_POST["password"];
//creating an oject to store the response
$responseObj = new stdClass();

//validation time
$email = handle_data($email);
//$password = handle_data($password); removed this because it trims spaces without warning
//had to use this because can't use the whole handle_data function
$password = htmlspecialchars($password);
//but remember the above function will store password as html special chars
//so do not forget to use it in sign up page too
if (invalidData($email, $password)){
    $responseObj->message = invalidData($email, $password);
    die(json_encode($responseObj));
}

//connect to database
//first get the DB info
require "../../variables.php";
//initiate connection
$dbConnection = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    $responseObj->message = "can't connect to the database";
    die(json_encode($responseObj));
}
//checking the account name in database
$query = "select * from accounts where email = '$email'";
$result = mysqli_query($dbConnection, $query);
if (!$result){
    $responseObj->message = "error while checking the email";
    die(json_encode($responseObj));
}
if(mysqli_num_rows($result) ==0){
    $responseObj->message = "there is no such email";
    die(json_encode($responseObj));
}
/*this will check if mysql returned more than one row (which shoudn't happen
because the feild "email" is unique), just in case..*/
if (mysqli_num_rows($result) > 1){
    $responseObj->message = "something fancy happened";
    die(json_encode($responseObj));
}

//if passed all of the above, get the data from the $result
$row = mysqli_fetch_assoc($result); // first row of the returned table
//check if the password is correct
if($password != $row['pass']){
    $responseObj->message = "email or password is not correct";
    die(json_encode($responseObj));
}else{
    $responseObj->message = 'success';
    $responseObj->id = $row['id'];
    $responseObj->email = $row['email'];
    $responseObj->redirect = '../';
    echo json_encode($responseObj);
    //store logged in session
    $_SESSION['loggedin'] = true;
    $_SESSION['userId'] = $row['id'];
    $_SESSION['userEmail'] = $row['email'];
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

//end of the file
?>