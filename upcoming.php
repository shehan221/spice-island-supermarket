<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

// Function to fetch upcoming products from database
function fetchProducts($connect) {
    $query = "SELECT * FROM upcoming";
    $result = mysqli_query($connect, $query);

    $products = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    return $products;
}

$products = fetchProducts($connect);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $productId = intval($_POST['id']);
        $productName = mysqli_real_escape_string($connect, $_POST['name']);
        $productPrice = floatval($_POST['price']);
        $quantity = intval($_POST['quantity']);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cartItemExists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity'] += $quantity;
                $cartItemExists = true;
                break;
            }
        }

        if (!$cartItemExists) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity
            ];
        }

        echo count($_SESSION['cart']);
        exit;
    }
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUR PRODUCTS</title>
    <link rel="stylesheet" href="up_com.css">
</head>
<body>
	<!--<audio autoplay loop>
    <source src="audio/music.mp3.unknown" type="audio/mpeg">
    Your browser does not support the audio element.
</audio> -->
<div class="main">
    <div class="navbar">
        <div class="icon">
            <div class="image-container">
                <a href="login.html"><img src="uploads/logo.jpg" alt="Logo"></a>
            </div>
        </div>
        <div class="menu">
            <ul>
               <li><a href="ui.php">HOME</a></li>
                <li><a href="products.php">PRODUCTS</a></li>
                <li><a href="EXCLUSIVE_PRODUCTS.php">BEST PRODUCTS</a></li>
                <li><a href="feedback.html">FEEDBACK</a></li>
                <li><a href="about_us.html">ABOUT US</a></li>
                <li><a href="upcoming.php">EXCLUSIVE PRODUCTS</a></li>
                <li>
                    <div class="profile-icon">
                        <a href="registration.php">
                            <img src="http://localhost/spice%20island%20supermarket/images/profile pic and logo/profile_icon.jpg" alt="Profile Picture">
                            <span>LOGIN / REGISTER</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="cart-icon">
            <a href="addTocart.php">
                <img src="images/cart icon/cart.jpg" alt="Cart">
                <div class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></div>
            </a>
        </div>
    </div>
</div>

<div class="form-container">
    <h1>EXCLUSIVE PRODUCTS!!</h1>

    <div class="discount-badge">
        <p><strong>100% ORGANIC</strong></p>
    </div>

    <div class="slider">
        <input type="radio" name="radio-btn" id="radio1" checked>
        <input type="radio" name="radio-btn" id="radio2">
        <input type="radio" name="radio-btn" id="radio3">
        <input type="radio" name="radio-btn" id="radio4">

        <div class="slides">
            <div class="slide">
                <video autoplay loop muted>
                    <source src="images/upcoming/products.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="slide">
                <video autoplay loop muted>
                    <source src="images/upcoming/harwest.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="slide">
                <video autoplay loop muted>
                    <source src="images/upcoming/making.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="slide">
                <video autoplay loop muted>
                    <source src="images/upcoming/package .mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="navigation-auto">
            <div class="auto-btn1"></div>
            <div class="auto-btn2"></div>
            <div class="auto-btn3"></div>
            <div class="auto-btn4"></div>
        </div>

        <div class="navigation-manual">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
            <label for="radio3" class="manual-btn"></label>
            <label for="radio4" class="manual-btn"></label>
        </div>
    </div>

    <h2>Available Products</h2>
    
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>">
                <div class="product-details">
                    <h3><?php echo $product['product_name']; ?></h3>
                    <h4>Rs.<?php echo $product['product_price']; ?></h4>
                    <div class="quantity">
                        <label for="quantity<?php echo $product['id']; ?>">Quantity:</label>
                        <input type="number" id="quantity<?php echo $product['id']; ?>" name="quantity<?php echo $product['id']; ?>" min="1" value="1">
                    </div>
                    <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo $product['product_name']; ?>', <?php echo $product['product_price']; ?>, document.getElementById('quantity<?php echo $product['id']; ?>').value)">Add to Cart</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script type="text/javascript">
        function addToCart(productId, productName, productPrice, quantity) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = xhr.responseText; 
                    }
                }
            };
            xhr.send("action=add&id=" + productId + "&name=" + encodeURIComponent(productName) + "&price=" + productPrice + "&quantity=" + quantity);
        }

        var counter = 1;
        setInterval(function() {
            document.getElementById('radio' + counter).checked = true;
            counter++;
            if (counter > 4) {
                counter = 1;
            }
        }, 5000);
    </script>
</div>
</body>
</html>
