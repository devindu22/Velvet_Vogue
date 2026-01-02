<?php
session_start();
include '../includes/db.php';

$email = $_POST['email'];
$pass = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user'] = $user;
    header("Location: ../index.php");
} else {
    echo "Invalid login";
}
?>