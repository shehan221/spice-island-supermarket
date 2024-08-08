<?php
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM categories";
$result = mysqli_query($connect, $query);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

echo json_encode($categories);
?>
