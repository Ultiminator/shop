<?php
session_start();
if (!isset($_SESSION['orderId'])){
    $ms = "why are you here? ";
    $lnk = "<a href='../'>start shopping</a>";
    die($ms . $lnk);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete</title>
    <link rel="stylesheet" href="../../Styles/Main.css">
    <link rel="stylesheet" href="../../Styles/tables.css">
    <link rel="stylesheet" href="../../Styles/headTail.css">
    <link rel="stylesheet" href="../../Styles/Structures.css">
    <script src="../../Scripts.js"></script>
    <link rel="stylesheet" href="../Styles/Main.css">
</head>
<body>
    <!-- menu bar here -->
    <?php
    $location = "../";
    include "$location/head.php";
    ?>
    <p>
        <h1>congratulations!</h1>
        <div class="centering">
            Your order has been placed.<br>
            <h4>The order ID is <?php echo $_SESSION['orderId']; ?></h4>
            it is estimated to arrive in 5 work days;
            <h3>Thank you for your purchase</h3>
            return to: 
            <a href="../">Home Page</a> 
            or see your 
            <a href="../Accounts/Orders/">orders</a>
        </div>
        
    </p>
</body>
</html>