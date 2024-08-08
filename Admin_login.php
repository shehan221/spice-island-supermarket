<?php 
session_start();

include('DBConnecter.php');

// Check if the form was submitted
if(isset($_POST['submit'])){
    // check the special characters
    $email = mysqli_real_escape_string($con, $_POST['admin_email']);
    $password = mysqli_real_escape_string($con, $_POST['admin_password']);
    
    // Query to fetch admin details
    $result = mysqli_query($con, "SELECT * FROM admin_login WHERE admin_email='$email' and admin_password='$password'") or die(mysqli_error($con));
    
    // Check if a row is returned
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Store admin details in session variables
        $_SESSION['admin_email'] = $row['admin_email'];
        $_SESSION['admin_password'] = $row['admin_password'];
        
        // Redirect to desired location upon successful login
        header("Location: Dashbord.php"); // Replace with your actual admin dashboard URL
        exit();
    } else {
        // Invalid login credentials
        $error = "Invalid email or password. Please try again.";
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<link href="Adminlogin.css" rel="stylesheet" type="text/css">
</head>

<body>
    <h1>Welcome to Spice Island Mart Company Menu</h1>
    <h2>Admin Login</h2>
    
    <div class="container">
        <form method="post">
            <?php
            // Display error message if login failed
            if(isset($error)) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            ?>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" placeholder="Enter your email" name="admin_email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="admin_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
            <button class="btn btn-primary-back"><a href="login.html">Back</a></button>
        </form>
    </div>
</body>
</html>
