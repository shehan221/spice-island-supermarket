<?php
// Check if the form has been submitted
if(isset($_POST['submit'])){
	
	// Include the database connection file
	include('DBConnecter.php');
	
	// Retrieve form data and store in variables
	$E_name = $_POST['E_name'];
	$E_email = $_POST['E_email'];
	$E_Cnumber = $_POST['E_Cnumber'];
	$E_password = $_POST['E_password'];
	$E_Cpassword = $_POST['E_Cpassword'];
	
	// Check if email or username already exists in the database
	$email_check_query = "SELECT * FROM employee WHERE E_email='$E_email' or E_name='$E_name'";
	$duplicate = mysqli_query($con, $email_check_query);
	
	// If a duplicate is found, alert the user
	if(mysqli_num_rows($duplicate)>0){
		echo "<script> alert('Username or Email already taken'); </script>";
	}
    else{
		// Check if passwords match
		if($E_password == $E_Cpassword) {
			// Insert the new employee data into the database
			$query = "INSERT INTO employee (E_name, E_email, E_Cnumber, E_password) VALUES ('$E_name', '$E_email', '$E_Cnumber', '$E_password')";
			mysqli_query($con, $query);
			
			// Alert the user that registration was successful
			echo "<script> alert('Registration successful'); </script>";
		} else {
			// Alert the user that passwords do not match
			echo "<script> alert('Password and confirm password does not match'); </script>";
		}
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
<link href="A_Add_Employee.css" rel="stylesheet" type="text/css">
<title>Admin Menu</title>
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

        <!-- Employee Registration Form -->
        <h2>Employee Registration</h2>
	
	<div class="container">
	
	<form method="post">
		<div class="form-group">
		<label>Employee Name:</label>
            <input type="text" class="form-control" placeholder="Enter your user name" name="E_name" required autocomplete="off">
		</div>
            
        <div class="form-group">
		<label>Email:</label>
            <input type="email" class="form-control" placeholder="Enter your email" name="E_email" required autocomplete="off">
        </div>

        <div class="form-group">
            <label>Contact Number:</label>
            <input type="text" class="form-control" placeholder="Enter your Contact Number" name="E_Cnumber" required autocomplete="off">
        </div>

        <div class="form-group">
		<label>Password:</label>
            <input type="password" class="form-control"  name="E_password" required autocomplete="off">
		</div>

        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" class="form-control"  name="E_Cpassword" required autocomplete="off">
        </div>
		
		<button type="submit" class="btn btn-primary" name="submit">Register</button>
		
	</form>
	
	</div>
        <!-- End of Employee Registration Form -->
</body>
</html>
