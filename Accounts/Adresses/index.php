<?php
//starting session to check if logged in
session_start();
if (!isset($_SESSION['loggedin'])){
    header('location: ../login');
}
$userId = $_SESSION['userId'];
//connect to db to load adresses
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die ("error while connecting to the database");
}
$query = "select * from adresses where userId = $userId order by id";
$result = mysqli_query($dbConn, $query);
if (!$result){
    die("error while checking adresses in database");
}
if (mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $adresses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adresses</title>
    <link rel="stylesheet" href="../../Styles/Main.css">
    <link rel="stylesheet" href="../../Styles/tables.css">
    <link rel="stylesheet" href="../../Styles/headTail.css">
    <link rel="stylesheet" href="../../Styles/Structures.css">
    <link rel="stylesheet" href="../../Styles/fullscrenBox.css">
    <script src="../../Scripts.js"></script>
    <script src="script.js"></script>
</head>
<body>
    <!-- menu bar here -->
    <?php
    $location = "../../";
    include "$location/head.php";
    ?>
    <h1><?php echo "Adresses of (" . $_SESSION['userEmail'] . ")"?></h1>
    <div class="centering">
        <button onclick="editAdress('000','','','')">Add Adress</button>
    </div>
    <div id="adressesContainer">
        <?php
        if (isset($adresses)){
            foreach ($adresses as $adress){
                echo "<table class='adress'>";
                echo "<tr><td colspan='2'>";
                echo $adress['name'];
                echo "</td></tr>";
                echo "<tr><td>Phone: </td>";
                echo "<td>" . $adress['phone'] . "</td></tr>";
                echo "<tr><td>Adress: </td>";
                echo "<td>" . $adress['adress'] . "</td></tr>";
                echo "<tr><td>";
                echo "<button onclick='editAdress(";
                echo $adress['id'] . ", \"" . $adress['name'] . "\", \"";
                echo $adress['phone'] . "\", \"" . $adress['adress'] . "\"";
                echo ")'>edit</button>";
                echo "</td>";
                echo "<td>";
                echo "<button onclick='removeAdress(";
                echo $adress['id'];
                echo ")'>remove</button>";
                echo "</td></tr>";
                echo "</table>";
            }
        }else{
            echo "<p>No adresses added</p>";
        }
        ?>
    </div>
    <div class="fullscren" id="editAdress" hidden>
        <table>
            <tr>
                <td>Name: </td>
                <td>
                    <input type="text" id="adressName">
                </td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td>
                    <input type="text" id="phone">
                </td>
            </tr>
            <tr>
                <td>Adress: </td>
                <td>
                    <textarea id="adress" cols="40" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="saveAdress()">Save</button>
                </td>
                <td>
                    <button onclick="cancelEdit()">Cancel</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span id="result"></span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>