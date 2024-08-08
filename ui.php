<?php
include 'DBConnecter.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Interface </title>
    <link rel="stylesheet" href="user_IF.css">
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
                            <img src="http://localhost/spice%20island%20supermarket/images/profile pic and logo/profile_icon.jpg" alt="Profile Picture">
                            <span>LOGIN / REGISTER</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Radio buttons for each slide (used for manual navigation) -->
<div class="slider">
    <input type="radio" name="radio-btn" id="radio1" checked>
    <input type="radio" name="radio-btn" id="radio2">
    <input type="radio" name="radio-btn" id="radio3">
    <input type="radio" name="radio-btn" id="radio4">

    <!-- Individual slide with image and link  -->
    <div class="slides">
        <div class="slide first">
            <a href="#"><img src="http://localhost/spice%20island%20supermarket/images/sideshow/slide_pic_1.jpg" alt="Slide 1"></a>
        </div>
        <div class="slide">
            <a href="#"><img src="http://localhost/spice%20island%20supermarket/images/sideshow/slide_pic_2.jpg" alt="Slide 2"></a>
        </div>
        <div class="slide">
            <a href="#"><img src="http://localhost/spice%20island%20supermarket/images/sideshow/slide_pic_3.jpg" alt="Slide 3"></a>
        </div>
        <div class="slide">
            <a href="#"><img src="http://localhost/spice%20island%20supermarket/images/sideshow/slide_pic_4.jpg" alt="Slide 4"></a>
        </div>
    </div>

    <!-- Automatic navigation buttons (styled in CSS) -->
    <div class="navigation-auto">
        <div class="auto-btn1"></div>
        <div class="auto-btn2"></div>
        <div class="auto-btn3"></div>
        <div class="auto-btn4"></div>
    </div>

    <!-- Manual navigation buttons -->
    <div class="navigation-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label>
    </div>
</div>

<!-- JavaScript to auto-rotate the slides every 5 seconds -->
<script type="text/javascript">
    var counter = 1;
    setInterval(function() {
        document.getElementById('radio' + counter).checked = true;
        counter++;
        // Reset the counter if it exceeds the number of slides
        if (counter > 4) {
            counter = 1;
        }
    }, 5000); // 5000 milliseconds = 5 seconds
</script>

<!-- Best Selling Products Carousel -->
<div class="carousel">
    <h3>BEST PRODUCTS ITEMS</h3>
    <div class="carousel-inner">
        <?php 
        $sql = "SELECT * FROM bestitem";
        $result = mysqli_query($con, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $B_name = $row['B_name'];
                $B_details = $row['B_details']; 
                $B_price = $row['B_price'];
                $B_image = $row['B_image'];

                echo '<div class="carousel-item">
                    <div class="content">
                        <img src="'.$B_image.'" alt="'.$B_name.'">
                        <h3>'.$B_name.'</h3>
                        <p>'.$B_details.'</p>
                        <h6>Rs.'.$B_price.'</h6>
                        <button class="Buy"><a href="EXCLUSIVE_PRODUCTS.php">DETAILS</a></button>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="carousel-item">No best selling products found.</div>';
        }
        ?>
    </div>
</div> <!-- arrow controls for best cell-->
<div class="carousel-controls">
    <button onclick="prev()">&#10094;</button>
    <button onclick="next()">&#10095;</button>
</div>

<script> //arrow key function
    let currentIndex = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;
        if (index >= totalSlides) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalSlides - 1;
        } else {
            currentIndex = index;
        }
        const newTransform = -currentIndex * 100;
        document.querySelector('.carousel-inner').style.transform = `translateX(${newTransform}%)`;
    }

    function next() {
        showSlide(currentIndex + 1);
    }

    function prev() {
        showSlide(currentIndex - 1);
    }
</script>

<!------------------------//////////////////////////////////---------------------------->

<!-- all  Products  -->

<div class="carousel-Products">
    <h3>ALL PRODUCTS ITEMS </h3>
    <div class="carousel-inner-Products">
        <?php 
        $sql = "SELECT * FROM addproduct";
        $result = mysqli_query($con, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $P_name = $row['P_name'];
                $P_datails = $row['P_datails']; 
                $P_price = $row['P_price'];
                $P_image = $row['P_image'];

                echo '<div class="carousel-item-Products">
                    <div class="content">
                        <img src="'.$P_image.'" alt="'.$P_name.'">
                        <h3>'.$P_name.'</h3>
                        <p>'.$P_datails.'</p>
                        <h6>Rs.'.$P_price.'</h6>
                        <button class="Buy"><a href="products.php">DETAILS</a></button>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="carousel-item-Products">No products found.</div>';
        }
        ?>
    </div>
</div>
<div class="carousel-Products-controls"> <!-- arrow controls for best cell-->
    <button onclick="prevProduct()">&#10094;</button>
    <button onclick="nextProduct()">&#10095;</button>
</div>

<script>
    let currentProductIndex = 0; //function for  all products 

    function showProductSlide(index) {
        const productSlides = document.querySelectorAll('.carousel-item-Products');
        const totalProductSlides = productSlides.length;
        if (index >= totalProductSlides) {
            currentProductIndex = 0;
        } else if (index < 0) {
            currentProductIndex = totalProductSlides - 1;
        } else {
            currentProductIndex = index;
        }
        const newProductTransform = -currentProductIndex * 100;
        document.querySelector('.carousel-inner-Products').style.transform = `translateX(${newProductTransform}%)`;
    }

    function nextProduct() {
        showProductSlide(currentProductIndex + 1);
    }

    function prevProduct() {
        showProductSlide(currentProductIndex - 1);
    }
</script>


<!--Category images show-->

<div class="container">

        <div class="item snacks">
        <a href="products.php"> <img src="uploads/scale.webp" alt="Snacks">
            <div class="text">Snacks</div></a>
        </div>
        <div class="item vegetables">
        <a href="products.php"><img src="uploads/Cooked_1.jpg" alt="Vegetables">
            <div class="text">Vegetables</div></a>
        </div>
        <div class="item fresh-meats">
        <a href="products.php"> <img src="images/fish and meat/chicken.jpg" alt="Fresh Meats">
            <div class="text">Fresh Meats</div></a>
        </div>
        <div class="item beauty-picks">
        <a href="products.php"> <img src="uploads/bb.jpg" alt="Beauty Picks">
            <div class="text">Beauty Picks</div></a>
        </div>
        <div class="item homeware-items">
        <a href="products.php"> <img src="uploads/isa.webp" alt="Homeware Items">
            <div class="text">Homeware Items</div></a>
        </div>
        <div class="item juices">
        <a href="products.php"> <img src="uploads/how-healthy-are-cold-pressed-juices.jpg" alt="Juices">
            <div class="text">Juices</div></a>
        </div>
    </div>


     <!-- Footer Section -->
     <footer>
            <div class="footer-content">
                <div class="footer-section contact-info">
                    <h3>SPICE ISLAND SUPERMARKET</h3>
                    <p>SIM WEBSITE<br>
                    NO:78,NARAHENPITA,SRI LANKA.</p>
                    <p><a href="tel:+94112303500">+94 11 2303500</a><br>
                    (Daily operating hours 8.00 a.m to 8.00 p.m)</p>
                </div>
                <div class="footer-section quick-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="ui.php">HOME</a></li>
                <li><a href="products.php">PRODUCTS</a></li>
                <li><a href="EXCLUSIVE_PRODUCTS.php">BEST PRODUCTS</a></li>
                <li><a href="feedback.html">FEEDBACK</a></li>
                <li><a href="about_us.html">ABOUT US</a></li>
                <li><a href="upcoming.php">EXCLUSIVE PRODUCTS</a></li>
                    </ul>
                </div>
                <div class="footer-section categories">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="products.php">Grocery</a></li>
                        <li><a href="products.php">Beverages</a></li>
                        <li><a href="products.php">Household</a></li>
                        <li><a href="products.php">Vegetables</a></li>
                        <li><a href="products.php">Fruits</a></li>
                    </ul>
                </div>
                <div class="footer-section useful-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Stores</a></li>
                        <li><a href="#">Delivery grid</a></li>
                    </ul>
                </div>
                <div class="footer-section customer-service">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="feedback.html">Contact us</a></li>
                        <li><a href="about_us.html">About us</a></li>
                    </ul>
                </div>
                <div class="social-media">
                    <a href="#"><img src="uploads/pngtree-facebook-icon-png-image_3566127.png" alt="Facebook"></a>
                    <a href="#"><img src="uploads/Twitter-Feature.jpg" alt="Twitter"></a>
                    <a href="#"><img src="uploads/in.jpg" alt="Instagram"></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
