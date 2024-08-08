<?php 

// Including the database connection file
include 'DBConnecter.php';

// Checking if the 'deleteP_id' parameter is set in the URL
if(isset($_GET['deleteE_id'])){
    // Retrieving the 'deleteP_id' value from the URL
    $E_id = $_GET['deleteE_id'];
    
    // SQL query to delete a record from the 'addproduct' table where the 'P_id' matches the provided value
    $sql = "DELETE FROM `employee` WHERE E_id = $E_id";
    
    // Executing the SQL query
    $result = mysqli_query($con, $sql);
    
    // Checking if the query was executed successfully
    if($result){
        // Redirecting to the 'view.php' page if the record was successfully deleted
        header('location:Manage_Employee.php');
    } else {
        // Terminating script execution and displaying the MySQL error message if the query fails
        die(mysqli_error($con));
    }
} else {
    // Redirecting to the 'view.php' page if the 'deleteP_id' parameter is not set in the URL
    header('location:Manage_Employee.php'); // Redirect if no P_id is set
}

?>
