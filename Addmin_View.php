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
<!-- Link to custom CSS file for admin view -->
<link href="Addmin_view.css" rel="stylesheet" type="text/css">
<title>Admin view product</title>
<script type="text/javascript">
    // JavaScript function to confirm deletion of a product
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

        <!-- View Product Section -->
        <h2>Product Table</h2>

        <!-- Table to display product details -->
        <table class="table">
            <thead>
                <tr>
                    <!-- Table headers -->
                    <th scope="col">Product Id</th>
                    <th scope="col">Category Id</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Details</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Product Quantity</th>
                    <th scope="col">Image</th>
                    <th scope="col">Add to Best Sells</th>
                    <th scope="col">Update Details</th>
                    <th scope="col">Remove Products</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Select all products from the database
                $sql = "SELECT * FROM `addproduct`";
                $result = mysqli_query($con, $sql);
                
                // If there are products found, display them in the table
                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        // Assign product details to variables
                        $Product_ID = $row['Product_ID'];
                        $category_ID = $row['category_ID'];
                        $Product_Category = $row['Product_Category'];
                        $P_name = $row['P_name'];
                        $P_details = $row['P_datails']; 
                        $P_price = $row['P_price'];
                        $P_quantity = $row['P_quantity'];
                        $P_image = $row['P_image'];    
                        
                        // Display product details in table rows
                        echo '<tr>
                            <th scope="row">'.$Product_ID.'</th>
                             <td>'.$category_ID.'</td>
                            <td>'.$Product_Category.'</td>
                            <td>'.$P_name.'</td>
                            <td>'.$P_details.'</td>
                            <td>'.$P_price.'</td>
                            <td>'.$P_quantity .'</td>
                            <td><img src="'.$P_image.'" alt="'.$P_name.'" style="width:100px;height:auto;"></td>
                            <!-- Button to add the product to best-selling items -->
                            <td><a class="btn btn-primary" href="Bestsells.php?bestid='.$Product_ID.'">Add</a></td>
                            <!-- Buttons for editing and deleting the product -->
                            <td>
                                <a class="btn btn-primary" href="update.php?updateP_id='.$Product_ID.'">Edit</a> 
                                </td>
                                <td>
                                <!-- JavaScript function to confirm deletion -->
                                <a class="btn btn-danger" href="javascript:void(0);" onclick="confirmDeletion(\'delete.php?deleteP_id='.$Product_ID.'\')">Delete</a>
                            </td>
                        </tr>';
                    }
                } else {
                    // If no products found, display a message in a single table row
                    echo '<tr><td colspan="7">No products found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- End of View Product Section -->
</body>
</html>
