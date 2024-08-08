<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="S_Manage_profile.css" rel="stylesheet" type="text/css">
<title>Staff Dashboard/S_Manage_profile.php</title>
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
			<li>
                <a href="S_Manage_profile.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Manage Profile</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            
            <a href="#" class="nav-link"></a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
			
            <a href="A_S_login.html" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </nav>
        <!-- NAVBAR -->
    </section>
    <!-- CONTENT -->
    
    <script src="home.js"></script>
</body>
</html>

