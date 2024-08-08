<?php
session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'shopping_cart';

// Establish database connection
$connect = mysqli_connect($hostname, $username, $password, $database);


if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Function to fetch product details from database
function fetchProductDetails($connect, $productId) {
    $query = "SELECT * FROM upcoming WHERE id = $productId";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

// Process actions only if POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add') {
           
            $productId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

          
            if ($productId > 0 && $quantity > 0) {
               
                $productDetails = fetchProductDetails($connect, $productId);

                if ($productDetails) {
                    // Initialize cart if not already set
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }

                    // Check if product already exists in cart, update quantity if so
                    $found = false;
                    foreach ($_SESSION['cart'] as &$item) {
                        if ($item['id'] == $productId) {
                            $item['quantity'] += $quantity;
                            $found = true;
                            break;
                        }
                    }

                    // If product is not found in cart, add new item
                    if (!$found) {
                        $newItem = array(
                            'id' => $productId,
                            'product_name' => $productDetails['product_name'], 
                            'product_price' => $productDetails['product_price'], 
                            'quantity' => $quantity
                        );
                        $_SESSION['cart'][] = $newItem;
                    }

                    // Return updated cart count
                    echo count($_SESSION['cart']);
                } else {
                  
                    echo 'Product not found';
                }
            } else {
                echo 'Invalid parameters';
            }
        } elseif ($action == 'remove') {
            $productId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

            if ($productId > 0) {
                // Remove product from cart if it exists
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $item) {
                        if ($item['id'] == $productId) {
                            unset($_SESSION['cart'][$key]);
                            break;
                        }
                    }
                    // Re-index array to maintain consistency
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                }
        
            } else {
              
                echo 'Invalid product ID';
            }
        } elseif ($action == 'clear') {
          
            unset($_SESSION['cart']);
            echo 'All items removed';
        } elseif ($action == 'checkout') {
          
            echo 'Checkout functionality not implemented yet';
        } elseif ($action == 'view') {
           
            echo json_encode(['error' => 'View action not implemented']);
        } else {
        
            echo json_encode(['error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['error' => 'Action parameter missing']);
    }
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
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

   
  echo '<form method="post" action="checkout.php" style="display:inline;">
    <input type="hidden" name="action" value="checkout">
    <button type="submit" class="checkout-button">Checkout</button>
</form>';
    
    echo '<a href="upcoming.php" class="back-button">Back to Products</a>';
    echo '</div>';
} else {
    echo '<p>No items in the cart.</p>';
}
mysqli_close($connect);
?>
