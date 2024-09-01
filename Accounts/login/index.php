<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>
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
    <table>
        <tr>
            <td>
                <label for="email">Email: </label>
            </td>
            <td>
                <input type="text" id="email" name="email">
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Password: </label>
            </td>
            <td>
                <input type="password" id="password" name="password">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button id="login" onclick="login()">log in</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span id="result"></span>
            </td>
        </tr>
    </table>
</body>
</html>