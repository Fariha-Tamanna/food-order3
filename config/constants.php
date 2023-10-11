<?php 

// start session
session_start();

// Create Constants to Store Non Repeating Values

define('SITEURL', 'http://localhost/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');

$conn = mysqli_connect('LOCALHOST', 'root', '') or die(mysqli_error()); // Database Connection
$db_select = mysqli_select_db($conn, 'food-order') or die(mysqli_error()); // Selecting Database


?>