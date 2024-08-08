<?php
// Include the database connection file
include 'DBConnecter.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="Addmin_Feedback.css" rel="stylesheet" type="text/css">
<title>Addmin  Feedback Report</title>
<script type="text/javascript">
    function confirmDeletion(deleteUrl) {
        if (confirm("Do you want to delete this Feedback?")) {
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
          <!--  <a href="#" class="nav-link">Categories</a> -->
            <form action="#">
               <!-- <div class="form-input">
                    <input type="search" placeholder="Search...">
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

        <!--View_Product-->

        <h2>Customere Feedback Report</h2>
    <table class="table">
        <thead>
            <tr>
                <!-- Table headers -->
                <th scope="col">Feedback ID</th>    
                <th scope="col">Cusstomer Name</th>
                <th scope="col">Email</th>    
                <th scope="col">Massage</th>   
                <th scope="col">Delete</th> 
            </tr>
        </thead>
        <tbody>
            <?php 
            // Select all products from the database
            $sql = "SELECT * FROM `feedback`";
            $result = mysqli_query($con, $sql);
            
            // If there are products found, display them in the table
        if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['id'];
                    $name = $row['name'];
                    $email = $row['email']; 
                    $message = $row['message'];
                     
                    
                    // Display product details in table rows
                    echo '<tr>
                        <th scope="row">'.$id.'</th>
                        <td>'.$name.'</td>
                        <td>'.$email.'</td>
                        <td>'.$message.'</td>
                        <td>
                        <!-- Button to delete an employee -->
                                <a class="btn btn-danger" href="javascript:void(0);" onclick="confirmDeletion(\'A_Feedback_delete.php?deleteFeed_id='.$id.'\')">Delete</a>
                            </td>
                    </tr>';
               }
           } else {
               
                echo '<tr><td>No Feedback Found.</td></tr>';
            }
            ?>
        </tbody>
    </table>

     <!--View_Product-->
</body>
</html>
