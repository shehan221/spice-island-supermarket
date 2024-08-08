<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\Exception.php';
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\PHPMailer.php';
require 'C:\wamp64\www\spice island supermarket\phpmailer\src\SMTP.php';

session_start();

if (!isset($_SESSION['id'])) {
    die("User not logged in.");
}

$userId = $_SESSION['id']; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart"; // Replace with your database name

// Create connection
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

// Close connection
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
    $mail->addAddress($recipientEmail, 'supermarket'); // Add a recipient

    // Content
    $logoPath = 'C:\wamp64\www\final\spice island supermarket\images\profile pic and logo\mail_logo.jpg';
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'About your Login';
    $mail->Body    = '
    <div style="width: 100%; text-align: center;">
        <img src="cid:logo" alt="Logo" style="max-width: 150px; border-radius: 50%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="margin-top: 20px; padding: 20px; font-family: Arial, sans-serif; color: #666; text-align: center;">
            <h2 style="font-size: 24px; margin-bottom: 20px;">THANK YOU FOR YOUR ORDER</h2>
            <p style="font-size: 16px;">Thank you for your purchase. Enter your OTP code to confirm your order- <span style="font-weight: bold; color: #333;">7768</span>.</p>
        </div>
    </div>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Attach the logo image
    $mail->addEmbeddedImage($logoPath, 'logo', 'logo.jpg');

    // Send email
    $mail->send();
    echo
	 "<script> alert('gmail has been sent'); </script>";
	 header("location: receipt.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
