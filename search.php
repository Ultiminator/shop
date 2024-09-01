<?php
$input = $_POST['input'];
$location = $_POST['location'];
$items = [];
require "./variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
$query = "select id, name, price from items where name like '%$input%'";
$result = mysqli_query($dbConn, $query);
if (!$result) {
    die("error while getting the items from database");
}
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}
if (empty($items)) {
    die("nothing found");
}
foreach ($items as $item) {
    echo "<a href='" . $location . "item.php?id=" . $item['id'] . "'>";
    echo "<span class='left'>" . $item['name'] . "</span>";
    echo "<span class='right'>" . $item['price'] . "$</span>";
    echo "</a>";
}
?>