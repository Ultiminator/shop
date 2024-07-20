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
    <title>Orders</title>
    <script src="./script.js"></script>
</head>
<body>
    <label for="orderId">orderId</label>
    <input type="text" id="orderId" name="orderId">
    <label for="phone">phone</label>
    <input type="text" id="phone" name="phone">
    <label for="status">Status: </label>
    <select name="status" id="status">
        <option value="">All</option>
        <option value="0">Pending</option>
        <option value="1">Confirmed</option>
        <option value="2">Ready</option>
        <option value="3">Delivering</option>
        <option value="4">Delivered</option>
        <option value="5">Cancelled</option>
    </select>
    <label for="sort">Sort by: </label>
    <select name="sort" id="sort">
        <option value="id">Order ID</option>
        <option value="price">Price</option>
        <option value="stat">Status</option>
        <option value="joindate">Date</option>
    </select>
    <select name="orderBy" id="orderBy">
        <option value="asc">Ascending</option>
        <option value="desc">Descening</option>
    </select>

    <button onclick="loadOrders()">Load orders</button>

    <table id="result"></table>
    
</body>
</html>