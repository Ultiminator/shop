<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Create a New Account</title>
        <link href="../Styles/Forms.css" rel="stylesheet">
        <script src="Scripts.js"></script>
    </head>
    <body>
        <h1>create a new account</h1>
        <table>
            <tr>
                <td><label for="email">Email adress:</label></td>
                <td><input type="text" name="email" id="email"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <span>
                        you should provide a valid and working email adress
                        as it will be used in security measures.
                    </span>
                </td>
            </tr>
            <tr>
                <td><label for="accName">Choose a password:</label></td>
                <td><input type="password" name="password" id="password"></td>
                <td><button onclick="show_password(this)">show password</button></td>
            </tr>
            <tr>
                <td><label for="accName">Repeat password:</label></td>
                <td><input type="password" name="repassword" id="repassword"></td>
                <td><span id="password_result"></span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <span>
                        choose a strong pasword which should contain 
                        a compination of capital and samll letters,
                        numbers and special charcters.
                    </span>
                </td>
            </tr>
            <tr class="submit">
                <td colspan="3">
                    <button onclick="sendData()">Register</button>
                </td>
            </tr>
            <tr class="submit">
                <td colspan="3">
                    <span id="submit_result"></span>
                </td>
            </tr>
        </table>
    </body>
</html>