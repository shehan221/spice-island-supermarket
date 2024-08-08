<?php
// Check if the form has been submitted
if(isset($_POST['submit'])){
    // Include the database connection file
    include('DBConnecter.php');
    
    // Get the category name from the form
    $C_name = $_POST['C_name'];
    
    // Prepare the SQL statement with a placeholder
    $sql = "INSERT INTO `categories` (C_name) VALUES (?)";
    
    // Prepare and bind
    if($stmt = $con->prepare($sql)){
        // Bind the category name to the placeholder
        $stmt->bind_param("s", $C_name);
        
        // Execute the statement
        if($stmt->execute()){
            // If successful, alert the user and redirect to Addmin_Add_Item.php
            echo "<script>
                    alert('Category added successfully');
                    window.location.href = 'Addmin_Add_Item.php';
                  </script>";
            exit();
        } else {
            // If execution failed, alert the user with the error
            echo "<script>
                    alert('Database error: " . $stmt->error . "');
                  </script>";
        }
        // Close the prepared statement
        $stmt->close();
    } else {
        // If preparation of the statement failed, alert the user with the error
        echo "<script>
                alert('Database error: " . $con->error . "');
              </script>";
    }
    
    // Close the database connection
    $con->close();
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Link to Boxicons CSS for icons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link to custom CSS file for adding category -->
<link href="A_Add_Category.css" rel="stylesheet" type="text/css">
<title>Admin View Best Product</title>
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
           <!-- <a href="#" class="nav-link">Categories</a> -->
            <form action="#">
                <div class="form-input">
                  <!--  <input type="search" placeholder="Search...">
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

        <!-- Add Category Section -->
        <h2>Add Category</h2>
        <div class="container">
            <!-- Form to add a new category -->
            <form method="post">
                <div class="form-group">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" id="categoryName" class="form-control" placeholder="Enter category name" name="C_name" required autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Add</button>
                    <button type="button" class="btn btn-secondary btn-back" onclick="window.history.back()">Back</button>
                </div>
            </form>
        </div>
    </section>
    <!-- END OF CONTENT -->
</body>
</html>
