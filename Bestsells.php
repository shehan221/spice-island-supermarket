<?php
// Include the database connection file
include 'DBConnecter.php';

// Check if the 'bestid' parameter is set in the URL
if (isset($_GET['bestid'])) {
    $bestid = $_GET['bestid'];

    // Select product details from the addproduct table based on the Product_ID
    $sql = "SELECT * FROM `addproduct` WHERE Product_ID= $bestid";
    $result = mysqli_query($con, $sql);

    // If the product is found in the addproduct table
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        // Extract product details from the result set
        $Product_ID= $row['Product_ID'];
        $category_ID= $row['category_ID'];
        $Product_Category = $row['Product_Category'];
        $P_name = $row['P_name'];
        $P_details = $row['P_datails'];
        $P_price = $row['P_price'];
        $P_quantity = $row['P_quantity'];
        $P_image = $row['P_image'];

        // Insert the product details into the bestitem table
        $insert_sql = "INSERT INTO `bestitem` (Product_ID, category_ID, B_category, B_name, B_details, B_price, B_quantity, B_image) VALUES ('$Product_ID', ' $category_ID','$Product_Category', '$P_name', '$P_details', '$P_price', '$P_quantity', '$P_image')";
        $insert_result = mysqli_query($con, $insert_sql);

        // Check if the insertion was successful
        if ($insert_result) {
            // If successful, alert the user and redirect to Addmin_Best_Item.php
            echo "<script>alert('Product added to Best Sells successfully!'); window.location.href = 'Addmin_Best_Item.php';</script>";
        } else {
            // If insertion failed, alert the user and redirect to Addmin_View.php
            echo "<script>alert('Failed to add product to Best Sells.'); window.location.href = 'Addmin_View.php';</script>";
        }
    } else {
        // If the product is not found in the addproduct table, alert the user and redirect to Addmin_View.php
        echo "<script>alert('Product not found.'); window.location.href = 'Addmin_View.php';</script>";
    }
} else {
    // If 'bestid' parameter is not set, alert the user and redirect to Addmin_View.php
    echo "<script>alert('Invalid request.'); window.location.href = 'Addmin_View.php';</script>";
}
?>
