<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/Main.css">
    <link rel="stylesheet" href="../Styles/headTail.css">
    <link rel="stylesheet" href="../Styles/Structures.css">
    <script src="../Scripts.js"></script>
</head>
<body>
    <?php
    $location = "../";
    include "$location/head.php";
    ?>
    <h1>Contact us</h1>
    <h2>
        <?php
        include "$location/variables.php";
        echo $shopName;
        ?>
    </h2>
    <div class="centering">
        <p>
            <?php
            echo "Adress: " . $shopAdress;
            ?>
        </p>
        <p>
            <?php
            echo "Email: " . $shopEmail;
            ?>
        </p>
        <p>
            <?php
            echo "Phone: " . $shopPhone;
            ?>
        </p>
    </div>
</body>
</html>