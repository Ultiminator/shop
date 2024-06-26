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
</head>
<body>
    <p>
        <h1>congratulations!</h1>
        Your order has been placed.<br>
        <h4>The order ID is <?php echo $_SESSION['orderId']; ?></h4>
        it is estimated to arrive in 5 work days;
        <h3>Thank you for your purchase</h3>
        return to: 
        <a href="../">Home Page</a> 
        or see your 
        <a href="../Accounts/Orders/">orders</a>
    </p>
</body>
</html>