<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="Admin_sales_reprot.css" rel="stylesheet" type="text/css">
<title>Addmin  Sales Report</title>

</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <!-- Brand logo and text -->
        <a href="#" class="brand">
            <i class='bx bxs-right-arrow'></i>
            <span class="text">Admin Panel</span>
        </a>
        <!-- Main navigation menu -->
        <ul class="side-menu top">
            <li class="active">
                <a href="Dashbord.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Add_item.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Add New Products</span>
                </a>
            </li>
            <li>
                <a href="categoryAdd.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Add New Category</span>
                </a>
            </li>
            <li>
                <a href="Addmin_View.php">
                    <i class='bx bxs-right-arrow-square'></i>
                    <span class="text">View Products</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Best_Item.php">
                    <i class='bx bxs-left-arrow-square'></i>
                    <span class="text">View Best Products</span>
                </a>
            </li>
            <li>
                <a href="Admin_sales_reprot.php">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Sales Report</span>
                </a>
            </li>
            <li>
                <a href="Addmin_Feedback.php">
                    <i class='bx bxs-notification'></i>
                    <span class="text">Feedback</span>
                </a>
            </li>
            <li>
                <a href="Manage_User.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Manage User</span>
                </a>
            </li>
            <li>
                <a href="Manage_Employee.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Manage Employee</span>
                </a>
            </li>
            <li>
                <a href="A_Add_Employe.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Add New Employee</span>
                </a>
            </li>
        </ul>
    
    </section>
    <!-- SIDEBAR -->


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <!-- Hamburger menu icon -->
            <i class='bx bx-menu' ></i>
            <!-- Navigation links and search form -->
           <!-- <a href="#" class="nav-link">Categories</a> -->
            <form action="#">
                <div class="form-input">
                   <!-- <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button> -->
                </div>
            </form>
            <li>
<!--profile-->
            <a href="Admin_profile.php" class="profile">
                <i class='bx bxs-user-circle'></i>
            </a>
</li>
            <!--logout-->
       <li>
                <a href="login.html" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
          
        </nav>
        <!-- NAVBAR -->
        
        <!-- JavaScript file for additional functionality -->
        <script src="home.js"></script>

       <!-- Sales Report-->
       
        <?php


// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "shopping_cart");

// Check if connection was successful
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve cart items from the cart_items table along with product weight
$sql = "SELECT cart_items.*,addproduct.P_weight 
        FROM cart_items 
        JOIN addproduct ON cart_items.product_id =addproduct.Product_ID ";
$result = mysqli_query($connect, $sql);

if (!$result) {
    die("Error fetching cart items: " . mysqli_error($connect));
}

$output = "";
$output .= "<h2 class='text-center'>Sales Report</h2>";
$output .= "<table class='table table-bordered table-striped'>";
$output .= "<tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Weight</th>
                <th>Quantity Sold</th>
                <th>Total Sales</th>
                <th>Update Date</th>
            </tr>";

$total_sales = 0;

// Loop through each row in the cart_items table
while ($row = mysqli_fetch_assoc($result)) {
    $output .= "<tr>
                    <td>".$row['product_id']."</td>
                    <td>".$row['product_name']."</td>
                    <td>".$row['P_weight']." </td>
                    <td>".$row['quantity']."</td>
                    <td>Rs.".number_format($row['total_price'], 2)."</td>
                    <td>".$row['updated']."</td>
                </tr>";
    $total_sales += $row['total_price'];
}

$output .= "<tr>
                <td colspan='5'></td>
                <td><b>Total Sales: Rs.".number_format($total_sales, 2)."</b></td>
            </tr>";
$output .= "</table>";

echo $output;
?>
  <!-- Sales Report-->
    
</body>
</html>