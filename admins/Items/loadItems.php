<?php
//get the data 
$name = $_POST['name'];
$cat = $_POST['cat'];
$brand = $_POST['brand'];
$minPrice = $_POST['minPrice'];
$maxPrice = $_POST['maxPrice'];
$discount = $_POST['discount'];
$inStock = $_POST['inStock'];
$sort = $_POST['sort'];

//connect to db
require "../../variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
//construct query
$query = "select id, name, rating, brand, tag, price, discount, amount ";
$query .= "from items where name like '%$name%' ";
$query .= "and tag like '%$cat%' and brand like '%$brand%' ";
$query .= "and price between $minPrice and $maxPrice ";
if($discount == "true"){
    $query .= "and discount > 0 ";
}
if($inStock == "true"){
    $query .= "and amount > 0 ";
}
$query .= "order by $sort";

//perform the query
$result = mysqli_query($dbConn, $query);
if(!$result){
    die("error while checking database");
}
if(mysqli_num_rows($result) == 0) {
    die("nothing found");
}
//prepare the table to display data if present
echo "<tr>";
echo "<th>N</th>";
echo "<th>id</th>";
echo "<th>name</th>";
echo "<th>rating</th>";
echo "<th>brand</th>";
echo "<th>category</th>";
echo "<th>price</th>";
echo "<th>discount</th>";
echo "<th>stock</th>";
echo "<th>edit</th>";
echo "<th>update Images</th>";
echo "<th>Remove</th>";
echo "<th>Notes</th>";
echo "</tr>";
//print the data
$count = 1;
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>$count</td>";
    foreach ($row as $key => $value){
        echo "<td>$value</tb>";
    }
    echo "<td><a href='../editItem?id=";
    echo $row['id'];
    echo "' target='_blank'>edit</a>";
    echo "<td><a href='../updateImages?id=" . $row['id'] . "' target='_blank'>Images</a>";
    echo "<td><button ";
    echo "onclick='removeItem(\"" . $row['id'] . "\", \"$count\")'>";
    echo "remove</button></td>";
    echo "<td id='$count'></td>";
    echo "</tr>";
    $count++;
}

//free memory and close the connection
mysqli_free_result($result);
mysqli_close($dbConn);
?>