<?php
//starting session to check if logged in
session_start();
if(!isset($_SESSION['loggedin'])){
    header('location: login');
}
$email = $_SESSION['userEmail'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="../Styles/Main.css">
    <link rel="stylesheet" href="../Styles/tables.css">
    <link rel="stylesheet" href="../Styles/headTail.css">
    <script src="../Scripts.js"></script>
</head>
<body>
    <!-- menu bar here -->
    <?php
    $location = "../";
    include "$location/head.php";
    ?>
    <h1>Welcome</h1>
    <h2><?php echo $email; ?></h2>
    <table class="alternate">
        <tr>
            <td>
                <a href="chart">Chart</a>
            </td>
            <td>
                <a href="Orders">Orders</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="Adresses">Adresses</a>
            </td>
            <td>
                <a href="returns">Resturns</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="changeEmail">Change Email</a>
            </td>
            <td>
                <a href="changePass">Change Password</a>
            </td>
        </tr>
    </table>
</body>
</html>