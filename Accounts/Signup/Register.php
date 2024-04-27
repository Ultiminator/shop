<?php
//retreive data
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$email = $_POST["email"];
//validation time
//first password
if ($password != $repassword){
    die("passwords don't match");
}
$email = handle_data($email);
//$password = handle_data($password); removed this because it trims spaces without warning
//had to use this because can't use the whole handle_data function
$password = htmlspecialchars($password);
//but remember the above function will store password as html special chars
//so do not forget to use it in login too
if (invalidData($email, $password)){
    die(invalidData($email,$password));
}

//connect to the database
require "../../variables.php";
$db_connection = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to database " . mysqli_connect_error());
}
//check if email is already present
$query = "select * from accounts where email = '$email'";
$result = mysqli_query($db_connection, $query);
if (!$result){
    die("error while checking the email");
}
if (mysqli_num_rows($result) > 0){
    die("this email is already registered");
}
//inserting the new record if it passed all of the above
//constructing query
$query = "insert into accounts (email, pass) values ('$email', '$password');";
//check if successiful
if (mysqli_query($db_connection, $query)){
    echo "registered successifully";
}else {
    echo mysqli_error($db_connection);
}
//free the memory
mysqli_free_result($result);
//close the connection
mysqli_close($db_connection);

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
        return "wow! what is this email?";
    }
    if (strlen($password) < 8 || strlen($password) > 30){
        return "password should be 8 to 30 characters!";
    }
    if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)){
        return "wrong email!";
    }
}
?>