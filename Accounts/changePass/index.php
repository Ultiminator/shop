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
        <title>Change Password</title>
        <link href="../Styles/Forms.css" rel="stylesheet">
        <script src="scripts.js"></script>
    </head>
    <body>
        <h1>change your password for (<?php echo $_SESSION['userEmail'] ?>)</h1>
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
                        Password must be 8 to 30 characters. choose a strong password.
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="newpassword">new password:</label>
                </td>
                <td>
                    <input type="password" name="newpassword" id="newpassword">
                    <button class="show" 
                            onclick="showPassword('newpassword',this)">(o)
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="repassword">repeat password:</label>
                </td>
                <td>
                    <input type="password" name="repassword" id="repassword">
                    <button class="show" 
                            onclick="showPassword('repassword',this)">(o)
                    </button>
                </td>
            </tr>
            <tr class="submit">
                <td colspan="2">
                    <button onclick="changePassword()">change password</button>
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