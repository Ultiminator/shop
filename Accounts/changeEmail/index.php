<?php
//starting session to check if logged in
session_start();
if (!isset($_SESSION['loggedin'])){
    header('location: ../login');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Change Email</title>
        <link href="../Styles/Forms.css" rel="stylesheet">
        <script src="scripts.js"></script>
    </head>
    <body>
        <h1>change your Email adress (<?php echo $_SESSION['userEmail'] ?>)</h1>
        <table>
            <tr class="submit">
                <td colspan="2">
                    <span>You must enter the current password first</span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">current password:</label>
                </td>
                <td>
                    <input type="password" name="password" id="password">
                    <button class="show" 
                            onclick="showPassword('password',this)">show
                    </button>
                </td>
            </tr>
            <tr class="submit">
                <td colspan="2">
                    <span>
                        you must provide a valid and working email adress.
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="newemail">new email:</label>
                </td>
                <td>
                    <input type="email" name="newemail" id="newemail">
                </td>
            </tr>
            <tr class="submit">
                <td colspan="2">
                    <button onclick="changeEmail()">change email</button>
                </td>
            </tr>
            <tr class="submit">
                <td colspan="2">
                    <span id="submitResult"></span>
                </td>
            </tr>
        </table>
    </body>
</html>