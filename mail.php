<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// location for each folder in the computer 
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\Exception.php';
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\PHPMailer.php';
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\SMTP.php';

session_start();

if (!isset($_SESSION['id'])) {
    die("User not logged in."); //check if there is a user registerd 
}

$userId = $_SESSION['id']; //get the user id as a session 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart"; 


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recipient email from database
$sql = "SELECT email FROM register WHERE id =$userId"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the email
    $row = $result->fetch_assoc();
    $recipientEmail = $row['email'];
} else {
    die("No recipient found");
}


$conn->close();

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username   = 'shehanranaw757@gmail.com'; // SMTP username
    $mail->Password   = 'rkitogyovhzenlpu'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
    $mail->Port       = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom('shehanranaw757@gmail.com', 'supermarket company');
    $mail->addAddress($recipientEmail, 'supermarket'); // receiver 

    // Content
    $logoPath = 'C:\wamp64\www\final\spice island supermarket\images\profile pic and logo\mail_logo.jpg';
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'About your Login';
    $mail->Body    = '
    <div style="width: 100%; text-align: center;">
        <img src="cid:logo" alt="Logo" style="max-width: 150px; border-radius: 50%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="margin-top: 20px; padding: 20px; font-family: Arial, sans-serif; color: #666; text-align: center;">
            <h2 style="font-size: 24px; margin-bottom: 20px;">Welcome to SPICE ISLAND SUPERMARKET</h2>
            <p style="font-size: 16px;">Thank you for logging into our online supermarket! Discover a wide selection of products, convenient shopping, and excellent service. Explore our aisles from the comfort of your home and <span style="font-weight: bold; color: #333;">enjoy a seamless shopping experience with us.</span>.</p>
        </div>
    </div>';//email description and the css added to them
    

    
    $mail->addEmbeddedImage($logoPath, 'logo', 'logo.jpg');

    // Send email
    $mail->send();
    echo
	 "<script> alert('gmail has been sent'); </script>";
	 header("location: user_profile.php");//after the mail send redirect the user to user profile
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";//error handling
}
?>
