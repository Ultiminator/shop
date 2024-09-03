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
    <h1>About us</h1>
    <h2>
        <?php
        include "$location/variables.php";
        echo $shopName;
        ?>
    </h2>
    <div class="centering">
        <?php
        $aboutText = "";
        $fileName = "./About.txt";
        if (file_exists($fileName)) {
            $fileHanle = fopen($fileName, "r");
            if ($fileHanle) {
                /* added 1 to file size because if the file is empty for some reason,
                   it will return an error as fread function can't take 0 as 2nd parameter*/
                $aboutText = fread($fileHanle, filesize($fileName) + 1);
                fclose($fileHanle);
            }else {
                $aboutText = "Error: Couldn't open About.txt file";
            }
        }else {
            $aboutText = "Error: Couldn't find About.txt file";
        }
        echo $aboutText;
        ?>
    </div>
</body>
</html>