<?php
session_start();
// Use dirname(__FILE__) to ensure paths work regardless of where the file is called from
include_once __DIR__ . '/../includes/db.php';

// Check authentication
if (!isset($_SESSION['user'])) {
    header("Location: ../signin.php");
    exit();
}

// Support both POST (form) and GET (simple links from the new UI)
$cart_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : (isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0);
$action = isset($_GET['action']) ? $_GET['action'] : '';
$user_id = $_SESSION['user']['id'];

if ($cart_id > 0) {
    if ($action === 'plus' || $action === 'minus') {
        // Handle the +/- buttons from the new UI
        $change = ($action === 'plus') ? 1 : -1;
        $query = "UPDATE cart SET quantity = quantity + ($change) WHERE id = $cart_id AND user_id = $user_id AND (quantity + $change) > 0";
        mysqli_query($conn, $query);
        
        // If they minus when quantity is 1, you might want to delete, 
        // but usually, luxury sites keep it at 1 until "Remove" is clicked.
    } elseif (isset($_POST['qty'])) {
        // Handle manual form updates if any
        $quantity = intval($_POST['qty']);
        if ($quantity > 0) {
            $query = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id";
        } else {
            $query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
        }
        mysqli_query($conn, $query);
    }
}

header("Location: ../cart.php?updated=1");
exit();
?>