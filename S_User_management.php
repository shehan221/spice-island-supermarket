<?php
// Include the database connection file
include 'DBConnecter.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="S_User_management.css" rel="stylesheet" type="text/css">
<title>Staff Dashboard/S_User_management</title>
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-right-arrow'></i>
            <span class="text">Staff Panel</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="S_Dashbord.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Order Management</span>
                </a>
            </li>
            <li>
                <a href="S_User_management.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">User Management</span>
                </a>
            </li>
            <li>
                <a href="S_Product_management.php">
                    <i class='bx bxs-right-arrow-square'></i>
                    <span class="text">Product Management</span>
                </a>
            </li>
            <li>
                <a href="S_Customer_Feedback.php">
                    <i class='bx bxs-notification'></i>
                    <span class="text">Customer Feedback</span>
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
            <!--<i class='bx bx-menu' ></i>-->
            <!-- Navigation links and search form -->
           <!-- <a href="#" class="nav-link">Categories</a>-->
            <form action="#">
                <div class="form-input">
                   <!-- <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>-->
                </div>
            </form>
            <li>
<!--profile-->
           

            <!--logout-->
       <li>
                <a href="login.html" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
          
        </nav>

    <!-- User Details Section -->
    <h2>User Details</h2>
        
        
        <table class="table">
            <thead>
                <tr>
                    <!-- Table headers -->
                    <th scope="col">User Id</th>
                    <th scope="col">User Name</th>    
                    <th scope="col">User Email Address</th>    
                    <th scope="col">User Register Date and Time</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                // Select all user from the database
                $sql = "SELECT * FROM `register`";
                $result = mysqli_query($con, $sql);
                
                
                if ($result) {
                   while ($row = mysqli_fetch_assoc($result)) {
                        $u_id = $row['id'];
                       $u_name = $row['username'];
                        $u_email = $row['email']; 
                        $u_date = $row['created_at'];
                        
                       
                        echo '<tr>
                           <th scope="row">'.$u_id.'</th>
                            <td>'.$u_name.'</td>
                            <td>'.$u_email.'</td>
                            <td>'.$u_date.'</td>
                        
                            
                        </tr>';
                    }
                } else {
                   
                   echo '<tr><td colspan="5">No User found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- End of User Details Section -->
        
    </section>
    <!-- CONTENT -->

</body>
</html>
