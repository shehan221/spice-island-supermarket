<?php
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

$query = "SELECT * FROM addproduct";

if ($category_id) {
    $query .= " WHERE category_id = '$category_id'";
} elseif ($search) {
    $query .= " WHERE P_name LIKE '%$search%' OR P_description LIKE '%$search%'";
}

$result = mysqli_query($connect, $query);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode($products);
?>
