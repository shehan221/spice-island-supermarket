<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

if (isset($_GET['category_id'])) {
    $_SESSION['category_id'] = $_GET['category_id'];
}

$category_id = isset($_SESSION['category_id']) ? $_SESSION['category_id'] : null;

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $session_array_id = array_column($_SESSION['cart'], "id");

        if (!in_array($_GET['id'], $session_array_id)) {
            $session_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity']
            );
            $_SESSION['cart'][] = $session_array;
        }
    } else {
        $session_array = array(
            'id' => $_GET['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        );
        $_SESSION['cart'][] = $session_array;
    }
}
?>
<!doctype html>
<html>
<head>
    <link href="EXCLUSIVE_PRODUCTS.css" rel="stylesheet" type="text/css">
    <title>Product Filter</title>
</head>
<body>
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
                            <img src="images/profile pic and logo/profile_icon.jpg" alt="Profile Picture">
                            <span>LOGIN / REGISTER</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


    <div class="content">
        <div class="header">
            <p>BEST SELLING PRODUCTS</p>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search products...">
                <button onclick="searchItems()">Search</button>
            </div>
            <div class="cart-icon">
            <a href="cart.php">
                <img src="cart.jpg" alt="Cart">
                <div class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></div>
            </a>
        </div>
        </div>
            <!-- Container for displaying products -->
            <div id="root"></div>
        </div>
    </div>

    <script>
        // Fetch categories from the server and display as filter buttons
        function fetchCategories() {
            fetch('fetch_Ecategories.php')
                .then(response => response.json())
                .then(categories => {
                    const btns = categories.map(cat => ({
                        id: cat.category_ID,
                        name: cat.C_name
                    }));
                    // Create unique set of categories
                    const filters = [...new Set(btns.map((btn) => btn))];
                    // Populate the 'btn' div with category buttons
                    document.getElementById('btn').innerHTML = filters.map((btn) => {
                        var { name, id } = btn;
                        return `<button class='fil-p' onclick='filterItems(${id})'>${name}</button>`;
                    }).join('');
                });
        }

        // Fetch products from the server and display them
        function fetchEProducts() {
            fetch('fetch_Eproducts.php')
                .then(response => response.json())
                .then(products => displayItems(products));
        }

        // Function to display products on the page
        const displayItems = (items) => {
            document.getElementById('root').innerHTML = items.map(item => {
                const { image, title, price, weight, quantity } = item;
                return (
                    `<div class='box'>
                        <h3>${title}</h3>
                        <p class='weight'>${weight}</p>
                        <div class='img-box'>
                            <img class='images' src=${image} alt="${title}" />
                        </div>
                        <div class='bottom'>
                            <h2>RS. ${price}</h2>
                            <p>${quantity <= 10 ? 'Out of Stock' : `Available: ${quantity}`}</p>
                            <input type='number' name='quantity' value='1' class='form-control mb-2'>
                           <input type='submit'  name='add_to_cart' class='btn' value='Details'>

                        </div>
                    </div>`
                );
            }).join('');
        };

        // Filter products based on selected category
        function filterItems(categoryId) {
            fetch('fetch_Eproducts.php?category_id=' + categoryId)
                .then(response => response.json())
                .then(filteredItems => displayItems(filteredItems));
        }

        // Search products based on input text
        function searchItems() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            fetch('fetch_Eproducts.php?search=' + searchInput)
                .then(response => response.json())
                .then(filteredItems => displayItems(filteredItems));
        }

        // Initialize page by fetching categories and products
        fetchCategories();
        fetchEProducts();
    </script>
</body>
</html>
