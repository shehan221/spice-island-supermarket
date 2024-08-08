<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the Confirm Order button is clicked
    if (isset($_POST['confirm_order'])) {
        // Get the cart items from the session
        $cart_items = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
        
        // Total amount
        $total_amount = 0;
        
        // Fetch the user ID from the register table
        $user_id = $_SESSION['id']; 
        
        // Prepare and execute SQL statement to insert receipt into the database
        $stmt = $pdo->prepare("INSERT INTO receipts (customer_id, product_id, product_name, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $quantity = $item['quantity'];
            $total_price = $item['total_price'];
            
            // Add the total price to calculate the total amount
            $total_amount += $total_price;
            
            // Bind parameters and execute the statement
            $stmt->execute([$user_id, $product_id, $product_name, $quantity, $total_price]);
        }
        
        
        
        echo '<script>alert("Order confirmed successfully!");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <link rel="stylesheet" href="receipt_style.css">
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="images/profile pic and logo/logo.jpg" alt="Supermarket Logo">
            <h2>Supermarket Receipt</h2>
        </div>
        <?php
        if (isset($_SESSION['otp_message'])) {
            echo "<p class='message'>" . $_SESSION['otp_message'] . "</p>";
            unset($_SESSION['otp_message']);
        }
        ?>
        <div class="receipt-content">
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
						<th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cart_items = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
                    $total = 0;
                    if (!empty($cart_items)) {
                        foreach ($cart_items as $item) {
                            $total += $item['total_price'];
                            echo "
                            <tr>
                                <td>{$item['product_id']}</td>
                                <td>{$item['product_name']}</td>
                                <td>{$item['quantity']}</td>
                                <td>Rs." . number_format($item['total_price'], 2) . "</td>
                            </tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3"><b>Total Amount</b></td>
                        <td>Rs. <?php echo number_format($total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form method="post" action="">
            <div class="otp-container">
                <input type="text" id="otpInput" placeholder="Enter OTP" required>
                <a href="otp.php" class="send-otp-btn">Send OTP</a>
            </div>
            <button type="submit" name="confirm_order" class="confirm-order">Confirm Order</button>
        </form>
        <div class="receipt-footer">
            <a href="cart.php" class="back-to-cart">Back to Cart</a>
        </div>
    </div>
</body>
</html>