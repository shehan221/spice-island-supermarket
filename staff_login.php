<?php 
session_start();

include('DBConnecter.php');

// Check if the form was submitted
if(isset($_POST['submit'])){
    // Sanitize and fetch input
    $email = mysqli_real_escape_string($con, $_POST['E_email']);
    $password = mysqli_real_escape_string($con, $_POST['E_password']);
    
    // Query to fetch admin details
    $result = mysqli_query($con, "SELECT * FROM employee WHERE E_email='$email' and E_password='$password'") or die(mysqli_error($con));
    
    // Check if a row is returned
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Store admin details in session variables
        $_SESSION['E_email'] = $row['E_email'];
        $_SESSION['E_password'] = $row['E_password'];
        
        // Redirect to desired location upon successful login
        header("Location: S_Dashbord.php"); // Replace with your actual admin dashboard URL
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
<title>Staff Login</title>
<link href="satfflogin.css" rel="stylesheet" type="text/css">
</head>

<body>
    <h1>Welcome to Spice Island Mart Company Menu</h1>
    <h2>Satff Login</h2>
    
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
                <input type="email" class="form-control" placeholder="Enter your email" name="E_email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="E_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
            <button class="btn btn-primary-back"><a href="login.html">Back</a></button>
        </form>
    </div>
</body>
</html>
