<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = ""; // Default XAMPP password is empty
$dbname = "velvet_vogue";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>