<?php
session_start();
include '../includes/db.php';

// 1. Check if user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page with a message
    header("Location: ../login.php?error=please_login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['qty']);

    if ($quantity <= 0) $quantity = 1;

    // 2. Check if product already exists in the user's cart
    $check_query = "SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // 3. Update existing quantity
        $row = mysqli_fetch_assoc($check_result);
        $new_qty = $row['quantity'] + $quantity;
        $cart_id = $row['id'];
        
        $update_query = "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id";
        mysqli_query($conn, $update_query);
    } else {
        // 4. Insert new record
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        mysqli_query($conn, $insert_query);
    }

    // 5. Redirect to cart page to show success
    header("Location: ../cart.php?success=added");
    exit();
} else {
    // Redirect back if accessed directly
    header("Location: ../index.php");
    exit();
}
?>