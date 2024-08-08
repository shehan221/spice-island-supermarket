<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="sales_report_style.css">
</head>
<body>
<?php
require 'register_config.php';

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

// Check if connection was successful
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve cart items from the cart_items table along with product weight
$sql = "SELECT cart_items.*, products.weight 
        FROM cart_items 
        JOIN products ON cart_items.product_id = products.id";
$result = mysqli_query($connect, $sql);

if (!$result) {
    die("Error fetching cart items: " . mysqli_error($connect));
}

$output = "";
$output .= "<h2 class='text-center'>Sales Report</h2>";
$output .= "<table class='table table-bordered table-striped'>";
$output .= "<tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Weight</th>
                <th>Quantity Sold</th>
                <th>Total Sales</th>
                <th>Update Date</th>
            </tr>";

$total_sales = 0;

// Loop through each row in the cart_items table
while ($row = mysqli_fetch_assoc($result)) {
    $output .= "<tr>
                    <td>".$row['product_id']."</td>
                    <td>".$row['product_name']."</td>
                    <td>".$row['weight']." </td>
                    <td>".$row['quantity']."</td>
                    <td>Rs.".number_format($row['total_price'], 2)."</td>
                    <td>".$row['updated']."</td>
                </tr>";
    $total_sales += $row['total_price'];
}

$output .= "<tr>
                <td colspan='5'></td>
                <td><b>Total Sales: Rs.".number_format($total_sales, 2)."</b></td>
            </tr>";
$output .= "</table>";

echo $output;
?>

</body>
</html>
