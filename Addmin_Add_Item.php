<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Include the database connection file
    include('DBConnecter.php');

    // Sanitize and escape user input to prevent SQL injection
    $P_name = mysqli_real_escape_string($con, $_POST['P_name']);
    $P_datails = mysqli_real_escape_string($con, $_POST['P_datails']);
    $P_price = mysqli_real_escape_string($con, $_POST['P_price']);
    $P_category = mysqli_real_escape_string($con, $_POST['Product_Category']);
    $P_quantity = mysqli_real_escape_string($con, $_POST['P_quantity']);
    $P_weight = mysqli_real_escape_string($con, $_POST['P_weight']);

    // Handle file upload
    $image = $_FILES['image']['name']; // Get the name of the uploaded file
    $target_dir = "uploads/"; // Directory where the file will be saved
    $target_file = $target_dir . basename($image); // Full path of the file
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

    // Ensure the upload directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check if the uploaded file is an actual image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Allow only certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowed_extensions)) {
            // Check file size (limit to 1MB)
            if ($_FILES['image']['size'] <= 1000000) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Retrieve category_ID from the category table based on the selected category name
                    $stmt = $con->prepare("SELECT category_ID FROM categories WHERE C_name = ?");
                    $stmt->bind_param("s", $P_category);
                    $stmt->execute();
                    $stmt->bind_result($category_ID);
                    $stmt->fetch();
                    $stmt->close();

                    if ($category_ID) {
                        // Use prepared statements to prevent SQL injection
                        $stmt = $con->prepare("INSERT INTO `addproduct` (P_name, P_datails, P_price, P_image, P_quantity, category_ID, Product_Category, P_weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssssiss", $P_name, $P_datails, $P_price, $target_file, $P_quantity, $category_ID, $P_category, $P_weight);

                        // Execute the query
                        if ($stmt->execute()) {
                            // Redirect to admin home page or display success message
                            echo "<script>
                                    alert('Item added successfully');
                                    window.location.href = 'Addmin_Add_Item.php';
                                  </script>";
                            exit();
                        } else {
                            // Display database error
                            die("Database error: " . $stmt->error);
                        }
                        $stmt->close();
                    } else {
                        // Display error if category ID is not found
                        echo "<script>alert('Category not found.');</script>";
                    }
                } else {
                    // Display error if file upload fails
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            } else {
                // Display error if file size exceeds the limit
                echo "<script>alert('Sorry, your file is too large.');</script>";
            }
        } else {
            // Display error if file format is not allowed
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        }
    } else {
        // Display error if the uploaded file is not an image
        echo "<script>alert('File is not an image.');</script>";
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Link to Boxicons CSS for icons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link to custom CSS for styling -->
<link href="Addmin_Add.css" rel="stylesheet" type="text/css">
<title>Admin Add Product</title>
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <!-- Brand logo and text -->
        <a href="#" class="brand">
            <i class='bx bxs-right-arrow'></i>
            <span class="text">Admin Panel</span>
        </a>
        <!-- Main navigation menu -->
        <ul class="side-menu top">
            <li class="active">
                <a href="Dashbord.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Add_item.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Add New Products</span>
                </a>
            </li>
            <li>
                <a href="categoryAdd.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Add New Category</span>
                </a>
            </li>
            <li>
                <a href="Addmin_View.php">
                    <i class='bx bxs-right-arrow-square'></i>
                    <span class="text">View Products</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Best_Item.php">
                    <i class='bx bxs-left-arrow-square'></i>
                    <span class="text">View Best Products</span>
                </a>
            </li>
            <li>
                <a href="Admin_sales_reprot.php">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Sales Report</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Feedback.php">
                    <i class='bx bxs-notification'></i>
                    <span class="text">Feedback</span>
                </a>
            </li>
            <li>
                <a href="Manage_User.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Manage User</span>
                </a>
            </li>
            <li>
                <a href="Manage_Employee.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Manage Employee</span>
                </a>
            </li>
            <li>
                <a href="A_Add_Employe.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Add New Employee</span>
                </a>
            </li>
        </ul>
    
    </section>
    <!-- SIDEBAR -->


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <!-- Hamburger menu icon -->
            <i class='bx bx-menu' ></i>
            <!-- Navigation links and search form -->
          <!--  <a href="#" class="nav-link">Categories</a> -->
            <form action="#">
                <div class="form-input">
                   <!-- <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button> -->
                </div>
            </form>
            <li>
<!--profile-->
            <a href="Admin_profile.php" class="profile">
                <i class='bx bxs-user-circle'></i>
            </a>
</li>
            <!--logout-->
       <li>
                <a href="login.html" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
          
        </nav>
        <!-- NAVBAR -->
        
        <!-- JavaScript file for additional functionality -->
        <script src="home.js"></script>

        <!-- Add New Product -->
        <div class="container">

            <h2>ADD NEW PRODUCT</h2>

            <!-- Form to add new product, using POST method and supporting file uploads -->
            <form method="post" enctype="multipart/form-data">
                <!-- Input field for product name -->
                <label for="P_name">Product Name:</label>
                <input type="text" id="P_name" name="P_name" required autocomplete="off">

                <!-- Input field for product category -->
                <label for="Product_Category">Select The Product Category: </label>
                <select id="Product_Category" name="Product_Category" required>
                    <?php
                    // Include the database connection file
                    include('DBConnecter.php');
                    
                    // Fetch categories from the database
                    $result = $con->query("SELECT category_ID, C_name FROM categories");
                    
                    // Check if categories exist and populate the dropdown
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'. $row['C_name'] .'">'. $row['C_name'] .'</option>';
                        }
                    } else {
                        echo '<option value="">No categories available</option>';
                    }
                    
                    // Close the database connection
                    $con->close();
                    ?>
                </select>
                
                <!-- Input field for product details -->
                <label for="P_datails">Product Details:</label>
                <input type="text" id="P_datails" name="P_datails" required autocomplete="off">
                
                <!-- Input field for product price -->
                <label for="P_price">Product Price:</label>
                <input type="text" id="P_price" name="P_price" required autocomplete="off">

                <!-- Input field for product quantity -->
                <label for="P_quantity">Product Quantity:</label>
                <input type="text" id="P_quantity" name="P_quantity" required autocomplete="off">

                <!-- Input field for product weight -->
                <label for="P_weight">Product Weight:</label>
                <input type="text" id="P_weight" name="P_weight" required autocomplete="off">
    
                <!-- Input field for product image -->
                <label for="image">Product Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
    
                <!-- Submit button to submit the form -->
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    
                <!-- <button class="btn btn-primary-back"><a href="view.php">Back</a></button> -->
    
            </form>
        </div>
        <!-- Add New Product -->
    </section>
</body>
</html>
