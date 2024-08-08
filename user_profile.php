<?php
require 'register_config.php';

// Logout functionality
if (isset($_POST["logout"])) {
	
    // Store user ID before destroying the session
    $userId = $_SESSION["id"];
	
    session_destroy();
	
    header("Location: ui.php");
    exit();
}

// Delete account functionality
if (isset($_POST["delete_account"])) {
	
    $userId = $_SESSION["id"];

    // Remove the user from the database
    $deleteQuery = "DELETE FROM register WHERE id = '$userId'";
    mysqli_query($conn, $deleteQuery);

   
    session_destroy();

    header("Location: ui.php");
    exit();
}

// Update user details
if (isset($_POST["update_details"])) {
    $userId = $_SESSION["id"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];

    $updateQuery = "UPDATE register SET mobile = '$mobile', email = '$email' WHERE id = '$userId'";
    mysqli_query($conn, $updateQuery);

    // Set success message
    $_SESSION["success_message"] = "Profile updated successfully.";

    // Redirect to the same page to show the success message
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Fetch user details
$userId = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM register WHERE id = '$userId'");
$userDetails = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #DBD3D4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            max-width: 1200px;
            width: 100%;
        }

        .sidebar {
            width: 300px;
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-sidebar {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-pic {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .welcome {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .nav-menu {
            width: 100%;
        }

        .nav-menu a,
        .nav-menu form button {
            display: block;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-bottom: 15px; 
            font-size: 16px;
        }

        .nav-menu a:hover,
        .nav-menu form button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .logout-button {
            background-color: #28a745;
        }

        .logout-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .nav-menu form {
            width: 100%;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .button-group form {
            width: 48%;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .user-details {
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        .details-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .detail-box {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            text-align: left;
        }

        .detail-box label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .detail-box input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .detail-box input[readonly] {
            background-color: #e9ecef;
        }

        h2 {
            margin: 5px 0;
            font-size: 20px;
        }

        p {
            font-size: 18px;
            margin-top: 20px;
            color: #555;
            text-align: center;
        }

        .save-button {
            background-color: #17a2b8;
            color: white;
            padding: 10px; 
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
            font-size: 16px;
            width: 100%;
        }

        .save-button:hover {
            background-color: #138496;
            transform: scale(1.05);
        }

        .success-message {
            color: green;
            font-size: 18px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-sidebar">
                <img src="images/profile pic and logo/profile_icon.jpg" alt="Profile Picture" class="profile-pic">
                <div class="welcome"><?php echo $userDetails['username'] . ' ' . $userDetails['lastname']; ?></div> <!--display user name from the database-->
            </div>
            <nav class="nav-menu">
                <a href="ui.php">Home</a>
                <a href="products.php">View Products</a>
                <a href="order_history.php">Order History</a>
                <div class="button-group">
                    <form method="post">
                        <button type="submit" name="logout" class="logout-button">Logout</button>
                    </form>
                    <form method="post">
                        <button type="submit" name="delete_account" class="delete-button" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">Delete Account</button>
                    </form>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <div class="profile-info">
                <div class="user-details">
                    <form method="post">
						
                        <div class="details-header">Details</div>
                       
                        <div class="detail-box">
                            <label for="user_id">User ID</label>
                            <input type="text" id="user_id" value="<?php echo $userDetails['id']; ?>" readonly>
                        </div>
                        <div class="detail-box">
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" name="mobile" value="<?php echo $userDetails['mobile']; ?>"><!--display user details editable-->
                        </div>
                        <div class="detail-box">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $userDetails['email']; ?>"> 
                        </div>
                        <button type="submit" name="update_details" class="save-button">Save Changes</button>
                    </form> <p>
					</p>
					 <?php
                        if (isset($_SESSION["success_message"])) { //display success message in the footer of the form
                            echo '<div class="success-message">' . $_SESSION["success_message"] . '</div>';
                            unset($_SESSION["success_message"]); 
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
