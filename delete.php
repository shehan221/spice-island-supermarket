<?php 

// Including the database connection file
include 'DBConnecter.php';

// Checking if the 'deleteP_id' parameter is set in the URL
if(isset($_GET['deleteP_id'])){
    // Retrieving the 'deleteP_id' value from the URL
    $Product_ID = $_GET['deleteP_id'];
    
    // SQL query to delete a record from the 'addproduct' table where the 'P_id' matches the provided value
    $sql = "DELETE FROM `addproduct` WHERE Product_ID =$Product_ID";
    
    // Executing the SQL query
    $result = mysqli_query($con, $sql);
    
    // Checking if the query was executed successfully
    if($result){
        // Redirecting to the 'view.php' page if the record was successfully deleted
        header('location:Addmin_View.php');
    } else {
        // Terminating script execution and displaying the MySQL error message if the query fails
        die(mysqli_error($con));
    }
} else {
    // Redirecting to the 'view.php' page if the 'deleteP_id' parameter is not set in the URL
    header('location:Addmin_View.php'); // Redirect if no P_id is set
}

?>
