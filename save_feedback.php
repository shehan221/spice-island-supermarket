<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and retrieve their ID from the session
if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    // Redirect the user to the login page if they are not logged in
    header("Location: login.php");
    exit();
}

// Get data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// SQL query to insert data into the database
$sql = "INSERT INTO feedback (id, name, email, message) VALUES ('$user_id', '$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Feedback submitted successfully');</script>";
    header("Location: thanks_feedback.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
