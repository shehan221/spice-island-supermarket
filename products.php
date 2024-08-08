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
    <link href="pp.css" rel="stylesheet" type="text/css">
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

<div class="container">
    <div class="sidebar">
        <div class="filter">
            <h3>Category</h3>
            <div id="btn"></div>
            <div>
               <a href="products.php"><button class="reset-button">All Products</button></a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="header">
            <p>All Products</p>
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
        <div id="root"></div>
    </div>
</div>

<script>
    function fetchCategories() {
        fetch('fetch_categories.php')
            .then(response => response.json())
            .then(categories => {
                const btns = categories.map(cat => ({
                    id: cat.category_ID,
                    name: cat.C_name
                }));
                const filters = [...new Set(btns.map((btn) => btn))];
                document.getElementById('btn').innerHTML = filters.map((btn) => {
                    var { name, id } = btn;
                    return `<button class='fil-p' onclick='filterItems(${id})'>${name}</button>`;
                }).join('');
            });
    }

    function fetchProducts() {
        fetch('fetch_products.php')
            .then(response => response.json())
            .then(products => displayItems(products));
    }

    const displayItems = (items) => {
        document.getElementById('root').innerHTML = items.map(item => {
            const { Product_ID, P_image, P_name, P_price, P_weight, P_quantity } = item;
            return (
                `<div class='box'>
                    <h3>${P_name}</h3>
                    <p class='weight'>${P_weight}</p>
                    <div class='img-box'>
                        <img class='image' src=${P_image} alt="${P_name}" />
                    </div>
                    <div class='bottom'>
                        <h2>RS. ${P_price}</h2>
                        <p>${P_quantity <= 10 ? 'Out of Stock' : `Available: ${P_quantity}`}</p>
                        <form method='post' action='products.php?id=${Product_ID}'>
                            <input type='hidden' name='name' value='${P_name}'>
                            <input type='hidden' name='price' value='${P_price}'>
                            <input type='number' name='quantity' value='1' class='form-control mb-2'>
                            <input type='submit' name='add_to_cart' class='btn' value='Add To Cart'>
                        </form>
                    </div>
                </div>`
            );
        }).join('');
    };

    function filterItems(categoryId) {
        fetch('fetch_products.php?category_id=' + categoryId)
            .then(response => response.json())
            .then(filteredItems => displayItems(filteredItems));
    }

    function searchItems() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        fetch('fetch_products.php?search=' + searchInput)
            .then(response => response.json())
            .then(filteredItems => displayItems(filteredItems));
    }

    fetchCategories();
    fetchProducts();
</script>
</body>
</html>

