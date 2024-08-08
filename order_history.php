<?php
require 'register_config.php';

if (!isset($_SESSION['id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch receipts data
$result = mysqli_query($conn, "SELECT * FROM receipts WHERE customer_id = '$userId'");
$totalPriceReceipts = 0;

// Fetch receipts_2 data
$result2 = mysqli_query($conn, "SELECT * FROM receipts_2 WHERE user_id = '$userId'");
$totalPriceReceipts2 = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 90%;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .no-orders {
            margin-top: 20px;
            color: #666;
        }

        .total-price {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order History</h1>

        <h2>Product Receipts</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $order['product_id']; ?></td>
                        <td><?php echo $order['product_name']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['total_price']; ?></td>
                    </tr>
                    <?php $totalPriceReceipts += $order['total_price']; ?>
                <?php endwhile; ?>
            </table>
            <div class="total-price">Total Price: RS. <?php echo $totalPriceReceipts; ?></div>
        <?php else: ?>
            <p class="no-orders">You have no orders yet.</p>
        <?php endif; ?>

        <h2>Exclusive Products</h2>
        <?php if (mysqli_num_rows($result2) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php while ($order2 = mysqli_fetch_assoc($result2)): ?>
                    <tr>
                        <td><?php echo $order2['product_id']; ?></td>
                        <td><?php echo $order2['product_name']; ?></td>
                        <td><?php echo $order2['quantity']; ?></td>
                        <td><?php echo $order2['total_price']; ?></td>
                    </tr>
                    <?php $totalPriceReceipts2 += $order2['total_price']; ?>
                <?php endwhile; ?>
            </table>
            <div class="total-price">Total Price: RS. <?php echo $totalPriceReceipts2; ?></div>
        <?php else: ?>
            <p class="no-orders">You have no orders yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
