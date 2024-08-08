<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

// Check database connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle remove action
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $id_to_remove = $_GET['id'];
    
    // Remove item from the cart session
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $id_to_remove) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Redirect back to cart page
    header("Location: cart.php");
    exit();
}

// Handle clear all action
if (isset($_GET['action']) && $_GET['action'] === 'clearall') {
    // Clear the entire cart session
    unset($_SESSION['cart']);
    // Redirect back to cart page
    header("Location: cart.php");
    exit();
}

// Handle checkout action
if (isset($_SESSION['cart']) && isset($_POST['checkout'])) {
    $cart_items = [];
    foreach ($_SESSION['cart'] as $key => $value) {
        $item_id = $value['id'];
        $item_name = $value['name'];
        $item_price = $value['price'];
        $item_quantity = $value['quantity'];
        
        // Fetch the product ID from the addproduct table
        $sql_product = "SELECT Product_ID, P_name, P_price FROM addproduct WHERE Product_ID = '$item_id'";
        $result_product = mysqli_query($connect, $sql_product);
        
        // Check if query executed successfully
        if (!$result_product) {
            die("Error in SQL query: " . mysqli_error($connect));
        }
        
        // Fetch the product details
        if ($row_product = mysqli_fetch_assoc($result_product)) {
            $product_id = $row_product['Product_ID'];
            $product_name = $row_product['P_name'];
            $product_price = $row_product['P_price'];
        } else {
            // Handle the case where the product is not found
            die("Product with ID $item_id not found in the database.");
        }
        
        // Check if the item already exists in the cart_items table
        $sql_check_item = "SELECT id, quantity FROM cart_items WHERE product_id = '$product_id'";
        $result_check_item = mysqli_query($connect, $sql_check_item);
        
        if (mysqli_num_rows($result_check_item) > 0) {
            // If the item exists, update its quantity and total price
            $row_item = mysqli_fetch_assoc($result_check_item);
            $new_quantity = $row_item['quantity'] + $item_quantity;
            $new_total_price = $new_quantity * $product_price;
            $sql_update_cart = "UPDATE cart_items SET quantity = '$new_quantity', total_price = '$new_total_price' WHERE id = '".$row_item['id']."'";
            $result_update_cart = mysqli_query($connect, $sql_update_cart);
            
            if (!$result_update_cart) {
                die("Error updating cart item: " . mysqli_error($connect));
            }
        } else {
            // Insert the item details into the database
            $sql_insert_cart = "INSERT INTO cart_items (product_id, product_name, quantity, total_price) VALUES ('$product_id', '$product_name', '$item_quantity', '".($product_price * $item_quantity)."')";
            $result_insert_cart = mysqli_query($connect, $sql_insert_cart);
            
            if (!$result_insert_cart) {
                die("Error inserting cart item: " . mysqli_error($connect));
            }
        }
        
        // Collect cart items for the receipt page
        $cart_items[] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'quantity' => $item_quantity,
            'total_price' => $item_quantity * $product_price
        ];
    }
    
    // Clear the cart after saving details to the database
    unset($_SESSION['cart']);
    $_SESSION['cart_items'] = $cart_items; // Store the cart details in session for display on receipt page
    header("Location: receipt.php"); // Redirect to receipt page
    exit(); // Stop further execution of the script
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart_style.css">
</head>
<body>
    <h2 class="text-center">Item Selected</h2>
    <?php
    $total = 0;
    $output = "";

    $output .= "
    <table class='table table-bordered table-striped'>
    <tr>
    <th>ID</th>
    <th>Item Name</th>
    <th>Item Price</th>
    <th>Item Quantity</th>
    <th>Total Price</th>
    <th>Action</th>
    </tr>";

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $output .= "
            <tr>
              <td>".$value['id']."</td>
              <td>".$value['name']."</td>
              <td>".$value['price']."</td>
              <td>".$value['quantity']."</td>
              <td>Rs.".number_format($value['price'] * $value['quantity'], 2)."</td>
              <td>
                <a href='cart.php?action=remove&id=".$value['id']."'>
                  <button class='btn btn-danger btn-block'>Remove</button>
                </a>
              </td>
            </tr>";

            $total += $value['quantity'] * $value['price'];
        }

        $output .= "
        <tr>
          <td colspan='3'></td>
          <td><b>Total Price</b></td>
          <td>Rs.".number_format($total, 2)."</td>
          <td>
            <a href='cart.php?action=clearall'>
              <button class='btn btn-warning'>Clear All</button>
            </a>
          </td>
        </tr>";
    }

    $output .= "</table>";
    echo $output;
    ?>

    <div style="margin-top: 20px;" class="text-center">
        <form method="post" action="">
            <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
        </form>
        <a href="products.php">
            <button class="btn btn-primary">Back to Products</button>
        </a>
    </div>
</body>
</html>
