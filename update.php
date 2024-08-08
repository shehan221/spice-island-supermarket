<?php 
// Including the database connection file
include('DBConnecter.php');

// Getting the product ID from the URL parameter
$Product_ID = $_GET['updateP_id'];

// Retrieving product details from the database based on the provided product ID
$sql = "SELECT * FROM `addproduct` WHERE Product_ID = $Product_ID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Assigning retrieved product details to variables
$P_name = $row['P_name'];
$P_datails = $row['P_datails'];
$P_price = $row['P_price'];
$P_quantity = $row['P_quantity'];
$P_image = $row['P_image']; 

// Handling form submission
if (isset($_POST['submit'])) {
    // Getting data from the form
    $P_name = mysqli_real_escape_string($con, $_POST['P_name']);
    $P_datails = mysqli_real_escape_string($con, $_POST['P_datails']);
    $P_price = mysqli_real_escape_string($con, $_POST['P_price']);
    $P_quantity = mysqli_real_escape_string($con, $_POST['P_quantity']);
    
    // Handling file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $upload_dir = 'uploads/'; // Directory for storing uploaded images
        $upload_file = $upload_dir . basename($image_name);
        
        // Moving uploaded file to the specified directory
        if (move_uploaded_file($image_tmp_name, $upload_file)) {
            $P_image = $upload_file; // Updating the image path
        } else {
            die('Failed to upload image.'); // Error message if image upload fails
        }
    }

    // Updating data in the database
    $sql = "UPDATE `addproduct` SET P_name = '$P_name', P_datails = '$P_datails', P_price = '$P_price',P_quantity='$P_quantity' ,P_image = '$P_image' WHERE Product_ID = $Product_ID";
    
    // Executing the SQL query
    $result = mysqli_query($con, $sql);
    // Checking if update was successful
    if ($result) {
        // Redirecting to view page if update was successful
        echo "<script>
        alert('Item Update successfully');
        window.location.href = 'Addmin_View.php';
      </script>";
    } else {
        // Displaying MySQL error if update fails
        die(mysqli_error($con));
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Product</title>
<link href="update.css" rel="stylesheet" type="text/css"> <!-- Linking CSS stylesheet -->
</head>

<body>
    <div class="container">
        <h2>Edit Product</h2>
        <!-- Form to edit the product, using POST method and supporting file uploads -->
        <form method="post" enctype="multipart/form-data">
            <!-- Input field for product name -->
            <label for="P_name">Product Name:</label>
            <input type="text" id="P_name" name="P_name" value="<?php echo htmlspecialchars($P_name); ?>" required>
            
            <!-- Input field for product details -->
            <label for="P_datails">Product Details:</label>
            <input type="text" id="P_datails" name="P_datails" value="<?php echo htmlspecialchars($P_datails); ?>" required>
            
            <!-- Input field for product price -->
            <label for="P_price">Product Price:</label>
            <input type="text" id="P_price" name="P_price" value="<?php echo htmlspecialchars($P_price); ?>" required>

            <label for="P_quantity">Product Quantity:</label>
            <input type="text" id="P_quantity" name="P_quantity" value="<?php echo htmlspecialchars($P_quantity); ?>" required>

            <!-- Input field for product image -->
            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <!-- Submit button to submit the form -->
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
            <button class="btn btn-primary-back"><a href="Addmin_View.php">Back</a></button> <!-- Button to navigate back to view page -->
        </form>
    </div>
</body>
</html>
