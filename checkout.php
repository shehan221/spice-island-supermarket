<?php
session_start();


$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'shopping_cart';


$connect = mysqli_connect($hostname, $username, $password, $database);


if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}


function fetchProductDetails($connect, $productId) {
    $query = "SELECT * FROM upcoming WHERE id = $productId";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function createReceipt($connect, $cart, $userId) {
    foreach ($cart as $item) {
        if (!isset($item['name'], $item['price'], $item['quantity'])) {
            echo 'Invalid item structure';
            return false;
        }
        
        $productId = $item['id'];
        $productName = mysqli_real_escape_string($connect, $item['name']);
        $productPrice = $item['price'];
        $quantity = $item['quantity'];
        $totalPrice = $productPrice * $quantity;
        
        $query = "INSERT INTO receipts_2 (user_id, product_id, product_name, product_price, quantity, total_price) VALUES ($userId, $productId, '$productName', $productPrice, $quantity, $totalPrice)";
        if (!mysqli_query($connect, $query)) {
            echo 'Database insert error: ' . mysqli_error($connect);
            return false; 
        }
    }
    return true;
}


$orderPlaced = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'checkout') {
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];
                } else {
                    echo 'User not logged in';
                    exit;
                }

             
                if (createReceipt($connect, $_SESSION['cart'], $userId)) {
                    unset($_SESSION['cart']);
                    $orderPlaced = true;
                } else {
                    echo 'Failed to place order. Please try again.';
                }
            } else {
                echo 'No items in the cart to checkout.';
            }
        } else {
            echo 'Invalid action';
        }
    } else {
        echo 'Action parameter missing';
    }
} else {
    echo 'Invalid request method';
}


if ($orderPlaced) {
    
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .confirmation-wrapper {
            background-color: #e0ffe0;
            border: 2px solid #32cd32;
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 50px;
        }
        .confirmation-message {
            font-size: 18px;
            font-weight: bold;
            color: #32cd32;
            margin-bottom: 20px;
        }
        .button-container {
            margin-top: 20px;
        }
        .view-order-button, .back-to-products-button {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .view-order-button:hover, .back-to-products-button:hover {
            background-color: #1c86ee;
        }
    </style>
</head>
<body>
    <div class="confirmation-wrapper">
        <div class="confirmation-message">
            Order placed successfully!
        </div>
        <div class="button-container">
            <a href="user_profile.php" class="view-order-button">View Your Orders</a>
            <a href="upcoming.php" class="back-to-products-button">Back to Products</a>
        </div>
    </div>
</body>
</html>';
} else {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Display cart contents
        echo '<style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
            }
            tr:hover {
                background-color: #f5f5f5;
            }
            .remove-button, .clear-button, .checkout-button {
                background-color: #ff6347;
                color: white;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                margin-top: 10px;
                display: inline-block;
            }
            .clear-button {
                background-color: #ffa500;
            }
            .checkout-button {
                background-color: #32cd32;
            }
            .total {
                font-size: 18px;
                font-weight: bold;
                margin-top: 20px;
            }
            .button-container {
                text-align: center;
                margin-top: 20px;
            }
            .back-button {
                background-color: #1e90ff;
                color: white;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                display: inline-block;
                text-decoration: none;
                text-align: center;
                margin: 5px;
            }
        </style>';

        echo '<h2>Item Selected</h2>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Item Name</th>';
        echo '<th>Item Price</th>';
        echo '<th>Item Quantity</th>';
        echo '<th>Total Price</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $productDetails = fetchProductDetails($connect, $item['id']);
            if ($productDetails) {
                $totalPrice = $productDetails['product_price'] * $item['quantity'];
                $grandTotal += $totalPrice;

                echo '<tr>';
                echo '<td>' . $item['id'] . '</td>';
                echo '<td>' . $productDetails['product_name'] . '</td>';
                echo '<td>Rs. ' . $productDetails['product_price'] . '</td>';
                echo '<td>' . $item['quantity'] . '</td>';
                echo '<td>Rs. ' . number_format($totalPrice, 2) . '</td>';
                echo '<td><form method="post">
                    <input type="hidden" name="id" value="' . $item['id'] . '">
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" class="remove-button">Remove</button>
                </form></td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td colspan="4" style="text-align:right;"><strong>Total Price</strong></td>';
        echo '<td>Rs. ' . number_format($grandTotal, 2) . '</td>';
        echo '<td><form method="post" style="display:inline;">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="clear-button">Clear All</button>
        </form></td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';

    
        echo '<div class="button-container">';
        echo '<form method="post" style="display:inline;">
            <input type="hidden" name="action" value="checkout">
            <button type="submit" class="checkout-button">Checkout</button>
        </form>';

        echo '<a href="upcoming.php" class="back-button">Back to Products</a>';
        echo '</div>';
    } else {
        echo '<p>No items in the cart.</p>';
    }
}

mysqli_close($connect);
?>
