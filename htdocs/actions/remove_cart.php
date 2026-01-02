<?php
session_start();
// Use __DIR__ to avoid path errors
include_once __DIR__ . '/../includes/db.php';

// Check authentication
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Get ID from URL
if (isset($_GET['id'])) {
    $cart_id = intval($_GET['id']);
    $user_id = $_SESSION['user']['id'];

    // Security check: Only delete if the item belongs to the current user
    $query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
    
    if(mysqli_query($conn, $query)) {
        header("Location: ../cart.php?removed=1");
    } else {
        // Log error if needed or redirect
        header("Location: ../cart.php?error=db_error");
    }
    exit();
} else {
    header("Location: ../cart.php");
    exit();
}
?>