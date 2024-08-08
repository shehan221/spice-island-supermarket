<?php
$con = new mysqli('localhost', 'root', '', 'shopping_cart');

if (!$con) {
    die(mysqli_error($con));
}
?>