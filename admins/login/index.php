<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <script src="script.js"></script>
</head>
<body>
    <table>
        <tr>
            <td>
                <label for="name">Account Name: </label>
            </td>
            <td>
                <input type="text" id="name" name="name">
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