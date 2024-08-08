<?php
// Include the database connection file
include 'DBConnecter.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="Manage_Employee.css" rel="stylesheet" type="text/css">
<title>Employee Details</title>
<script type="text/javascript">
    // JavaScript function to confirm deletion with a popup
    function confirmDeletion(deleteUrl) {
        if (confirm("Do you want to delete this Details?")) {
            window.location.href = deleteUrl; // Redirect to delete URL if confirmed
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

        <!-- Employee Details Section -->
        <h2>Employee Details</h2>
        
        <!-- Table to display employee details -->
        <table class="table">
            <thead>
                <tr>
                    <!-- Table headers -->
                    <th scope="col">Employee Id</th>
                    <th scope="col">Employee Name</th>    
                    <th scope="col">Email Address</th>    
                    <th scope="col">Contact Number</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Select all employees from the database
                $sql = "SELECT * FROM `employee`";
                $result = mysqli_query($con, $sql);
                
                // If there are employees found, display them in the table
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $E_id = $row['E_id'];
                        $E_name = $row['E_name'];
                        $E_email = $row['E_email']; 
                        $E_Cnumber = $row['E_Cnumber'];
                        
                        // Display employee details in table rows
                        echo '<tr>
                            <th scope="row">'.$E_id.'</th>
                            <td>'.$E_name.'</td>
                            <td>'.$E_email.'</td>
                            <td>'.$E_Cnumber.'</td>
                            <td>
                                <!-- Button to delete an employee -->
                                <a class="btn btn-danger" href="javascript:void(0);" onclick="confirmDeletion(\'E_delete.php?deleteE_id='.$E_id.'\')">Delete</a>
                            </td>
                        </tr>';
                    }
                } else {
                    // If no employees found, display a message in a single table row
                    echo '<tr><td colspan="5">No employees found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- End of Employee Details Section -->
        
    </section>
    <!-- CONTENT -->
</body>
</html>
