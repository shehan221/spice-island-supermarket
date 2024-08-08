<?php
// Include the database connection file
include 'DBConnecter.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Link to Boxicons CSS for icons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link to custom CSS for styling -->
<link href="Addmin_Best_Item.css" rel="stylesheet" type="text/css">
<title>Addmin View Best Product</title>
<script type="text/javascript">
    // JavaScript function to confirm deletion of an item
    function confirmDeletion(deleteUrl) {
        if (confirm("Do you want to delete this item?")) {
            window.location.href = deleteUrl;
        }
    }
</script>
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

        <!-- Best Selling Products Section -->
        <h2>Best Selling Products</h2>
        <!-- Table to display best selling products -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Best Sell Id</th>
                    <th scope="col">Product Id</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Product Name</th>    
                    <th scope="col">Product Details</th>
                    <th scope="col">Product Price</th> 
                    <th scope="col">Product Quantity</th>      
                    <th scope="col">Image</th> 
                    <th scope="col">Operation</th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                // Fetch best selling products from the database
                $sql = "SELECT * FROM `bestitem`";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Extract product details from the database result
                        $B_id = $row['B_id'];
                        $Product_ID = $row['Product_ID'];
                        $B_category = $row['B_category'];
                        $B_name = $row['B_name'];
                        $B_details = $row['B_details']; 
                        $B_price = $row['B_price'];
                        $B_quantity = $row['B_quantity'];
                        $B_image = $row['B_image'];

                        // Display product details in the table
                        echo '<tr>
                            <th scope="row">'.$B_id.'</th>
                            <td>'.$Product_ID.'</td>
                            <td>'.$B_category.'</td>
                            <td>'.$B_name.'</td>
                            <td>'.$B_details.'</td>
                            <td>'.$B_price.'</td>
                            <td>'.$B_quantity.'</td>
                            <td><img src="'.$B_image.'" alt="'.$B_name.'" style="width:100px;height:auto;"></td>

                            <td>
                            <!-- Button to delete the product, with confirmation -->
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="confirmDeletion(\'Bestdelet.php?deleteB_id='.$B_id.'\')">Delete</a>
                        </td>
                        </tr>';
                    }
                } else {
                    // Display message if no best selling products are found
                    echo '<tr><td colspan="6">No best selling products found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- End of Best Selling Products Section -->
    </section>
</body>
</html>
