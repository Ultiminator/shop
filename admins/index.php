<?php
//starting session to check if logged in
session_start();
if(!isset($_SESSION['loggedin'])){
    header('location: login');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo $_SESSION['adminName'];
        ?>
    </title>
</head>
<body>
    <table>
        <tr>
            <td>
                <a href="Items">items Panel</a>
            </td>
            <td>
                <a href="">Orders</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">create order</a>
            </td>
            <td>
                <a href="">Returns</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">Customer service</a>
            </td>
            <td>
                <a href="">change Password</a>
            </td>
        </tr>
    </table>
</body>
</html>