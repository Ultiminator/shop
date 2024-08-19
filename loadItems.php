<?php
// let's  get the data
$rating = $_POST['rating'];
$max = $_POST['max'];
$min = $_POST['min'];
$sort = $_POST['sort'];
$offer = $_POST['offer'];
$stock = $_POST['stock'];
if (isset($_POST['cats'])) {
    $cats = $_POST['cats'];
}
if (isset($_POST['brands'])) {
    $brands = $_POST['brands'];
}
//prepare the array to hold the items
$items = [];

//connect to db
require "./variables.php";
$dbConn = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $dbName);
if (mysqli_connect_errno()){
    die("can't connect to the datatbase");
}
$query = "select * from items where rating >= $rating";
$query .= " and price between $min and $max";
if ($offer) {
    $query .= " and discount >= 1";
}
if ($stock) {
    $query .= " and amount >= 1";
}
if (isset($cats)){
    $query .= " and tag in (";
    foreach ($cats as $key => $cat) {
        if ($key == 0) {
            $query .= "'$cat'";
        }else {
            $query .= ", '$cat'";
        }
    }
    $query .= ")";
}
if (isset($brands)){
    $query .= " and brand in (";
    foreach ($brands as $key => $brand) {
        if ($key == 0) {
            $query .= "'$brand'";
        }else {
            $query .= ", '$brand'";
        }
    }
    $query .= ")";
}
$query .= " order by $sort";
//perform the query
$result = mysqli_query($dbConn, $query);
if (!$result) {
    die("error while getting the items from database");
}
// add every row to the items array
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

// now lets get the image of every item
foreach ($items as $key => $item) {
    $query = "select * from images where itemId = " . $item['id'];
    $query .= " order by id asc";
    $result = mysqli_query($dbConn, $query);
    if (!$result || mysqli_num_rows($result) == 0) {
        $items[$key]['img'] = "../default.jpg";
    }else {
        $row = mysqli_fetch_assoc($result); //first image only
        $items[$key]['img'] = $row['id'] . "." . $row['extension'];
    }
}

//resturn the array in the response
echo json_encode($items);
?>