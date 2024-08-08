<?php
session_start(); 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and retrieve their ID from the session
//if(isset($_SESSION['id'])) {
    //$user_id = $_SESSION['id'];
//} else {
    // Redirect the user to the login page if they are not logged in
    //header("Location: login.php");
    //exit();
//}


$sql = "SELECT name, email, message FROM feedback";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Feedback Received</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th><th>Message</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No feedback received yet.";
}

$conn->close();
?>

</body>
</html>
