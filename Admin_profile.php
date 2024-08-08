<?php
    include('DBConnecter.php');

    // Retrieving product details from the database based on the provided product ID
$sql = "SELECT * FROM `admin_login`";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Assigning retrieved product details to variables
$admin_email = $row['admin_email'];
$admin_password = $row['admin_password'];

if (isset($_POST['submit'])) {
    // Getting data from the form
    $admin_email = mysqli_real_escape_string($con, $_POST['admin_email']);
    $admin_password  = mysqli_real_escape_string($con, $_POST['admin_password']);
  

   // Updating data in the database
   $sql = "UPDATE `admin_login` SET admin_email = '$admin_email', admin_password = '$admin_password'";
    
   // Executing the SQL query
   $result = mysqli_query($con, $sql);
   // Checking if update was successful
   if ($result) {
       // Redirecting to view page if update was successful
       echo "<script>
       alert('Admin Login Details Update successfully');
       window.location.href = 'Admin_profile.php';
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
<!-- Link to Boxicons CSS for icons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link to custom CSS file for adding category -->
<link href="Admin_profile.css" rel="stylesheet" type="text/css">
<title>Admin profile</title>
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
            <!--<a href="#" class="nav-link">Categories</a>-->
            <form action="#">
                <div class="form-input">
                   <!-- <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>-->
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

      
        
        <div class="container">
            <h2>Admin Login Details</h2>
           
            <form method="post" enctype="multipart/form-data">
           
            <label for="admin_email">Admin Email:</label>
            <input type="text" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($admin_email); ?>" required>
            
          
            <label for="admin_password">Password:</label>
            <input type="text" id="admin_password" name="admin_password" value="<?php echo htmlspecialchars($admin_password); ?>" required>
            
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
        </div>
    </section>
    <!-- END OF CONTENT -->
</body>
</html>
