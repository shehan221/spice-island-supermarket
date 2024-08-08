<?php
// Include the database connection file
include('DBConnecter.php');

// Get the 'category_id' from the GET request, if it exists, and convert it to an integer. Default to null if not set.
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Get the 'search' parameter from the GET request, if it exists, and escape it for safety. Default to an empty string if not set.
$search = isset($_GET['search']) ? $con->real_escape_string($_GET['search']) : '';

// Start building the SQL query to select all products from the 'addproduct' table
$sql = "SELECT * FROM  bestitem";

// If a category ID is provided, add a WHERE clause to filter by category
if ($category_id) {
    $sql .= " WHERE category_ID = $category_id";
// If a search term is provided and no category ID, add a WHERE clause to filter by product name
} elseif ($search) {
    $sql .= " WHERE B_name LIKE '%$search%'";
}

// Execute the SQL query
$result = $con->query($sql);

// Initialize an empty array to store the products
$products = [];

// Loop through the result set and fetch each row as an associative array
while ($row = $result->fetch_assoc()) {
    // Add the product details to the products array
    $products[] = [
        'image' => $row['B_image'],
        'title' => $row['B_name'],
        'price' => $row['B_price'],
        'weight' => $row['B_weight'],
        'quantity' => $row['B_quantity']
    ];
}

// Encode the products array to JSON format and output it
echo json_encode($products);
?>
