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
</head>
<body>
    <h1>Add new Item</h1>
    <label for="itemName">Name:</label>
    <input type="text" name="itemName" id="itemName">
    <label for="describtion">Describtion</label>
    <textarea name="describtion" id="describtion" cols="30" rows="10"></textarea>
    <label for="price">Price</label>
    <input type="number" name="price" id="price" min="1">
    <label for="discount">Discount</label>
    <input type="number" name="discount" id="discount" max="99">
    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" min="0">
    <label for="brand">Brand:</label>
    <input type="text" name="brand" id="brand">
    <label for="category">Category:</label>
    <input type="text" name="category" id="category">
    <label for="files">images:</label>
    <input type="file" name="files[]" id="files" accept="image/*" multiple>
    <button id='submitbutton' onclick='sendTheData()'>Add</button>
    <span id="result">result here</span>
</body>
</html>