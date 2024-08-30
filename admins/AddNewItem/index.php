<?php
//starting session to check if logged in
session_start();
if(!isset($_SESSION['adminId'])){
    header('location: ../login');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new Item</title>
    <script src="Scripts.js"></script>
    <link rel="stylesheet" href="../../Styles/Main.css">
</head>
<body>
    <h1>Add new Item</h1>
    <table>
        <tr>
            <td>
                <label for="itemName">Name:</label>
            </td>
            <td>
                <input type="text" name="itemName" id="itemName">
            </td>
        </tr>
        <tr>
            <td>
                <label for="describtion">Describtion</label>
            </td>
            <td>
                <textarea name="describtion" id="describtion"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="price">Price</label>
            </td>
            <td>
                <input type="number" name="price" id="price" min="1"> 
            </td>
        </tr>
        <tr>
            <td>
            <label for="discount">Discount</label>
            </td>
            <td>
            <input type="number" name="discount" id="discount" max="99">
            </td>
        </tr>
        <tr>
            <td>
            <label for="amount">Amount</label>
            </td>
            <td>
            <input type="number" name="amount" id="amount" min="0">
            </td>
        </tr>
        <tr>
            <td>
            <label for="brand">Brand:</label>
            </td>
            <td>
            <input type="text" name="brand" id="brand">
            </td>
        </tr>
        <tr>
            <td>
            <label for="category">Category:</label>
            </td>
            <td>
            <input type="text" name="category" id="category">
            </td>
        </tr>
        <tr>
            <td>
            <label for="files">images:</label>
            </td>
            <td>
            <input type="file" name="files[]" id="files" accept="image/*" multiple>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button id='submitbutton' onclick='sendTheData()'>Add</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span id="result">result here</span>
            </td>
        </tr>
    </table>
    
</body>
</html>