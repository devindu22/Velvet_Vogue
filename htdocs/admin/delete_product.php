<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Security Check: Only allow admins
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../signin.php?error=access_denied");
    exit();
}

// 2. Database connection
include '../includes/db.php';

// 3. Get the ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Fetch the product first to delete the physical image file from the server
    $find_res = mysqli_query($conn, "SELECT image FROM products WHERE id = $id");
    if ($find_res && mysqli_num_rows($find_res) > 0) {
        $product = mysqli_fetch_assoc($find_res);
        $image_path = "../assets/images/" . $product['image'];
        
        // Delete the file if it exists and isn't a placeholder/empty
        if (!empty($product['image']) && file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // 4. Delete the record from the database
    $delete_query = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $delete_query)) {
        // Redirect with success message
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        // Redirect with error message if database fails (e.g. foreign key constraint)
        header("Location: dashboard.php?error=delete_failed");
        exit();
    }
} else {
    // If no valid ID is provided, just go back
    header("Location: dashboard.php");
    exit();
}
?>