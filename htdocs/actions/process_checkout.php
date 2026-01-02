<?php
session_start();
// Use __DIR__ to ensure it finds the db file in the parent folder's includes directory
include_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    $payment_method = mysqli_real_escape_string($conn, $_POST['paymentMethod']);
    
    // Additional security: Get shipping info from POST if you want to update user profile
    $shipping_name = mysqli_real_escape_string($conn, $_POST['name']);
    $shipping_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $shipping_address = mysqli_real_escape_string($conn, $_POST['address']);

    // 1. Calculate Total from Cart
    $cart_query = "SELECT c.product_id, c.quantity, p.price 
                   FROM cart c JOIN products p ON c.product_id = p.id 
                   WHERE c.user_id = $user_id";
    $cart_result = mysqli_query($conn, $cart_query);
    
    $total_bill = 0;
    $items = [];
    while($row = mysqli_fetch_assoc($cart_result)) {
        $total_bill += ($row['price'] * $row['quantity']);
        $items[] = $row;
    }

    if ($total_bill > 0) {
        // Simple logic for shipping (Free for this design, but can be adjusted)
        $final_total = $total_bill;

        // 2. Insert into Orders Table
        // We include the payment method and a default status
        $order_sql = "INSERT INTO orders (user_id, total_amount, payment_method, status, created_at) 
                      VALUES ($user_id, $final_total, '$payment_method', 'Confirmed', NOW())";
        
        if (mysqli_query($conn, $order_sql)) {
            $order_id = mysqli_insert_id($conn);

            // 3. Insert each item into Order Items table (if you have one)
            // If you don't have order_items table yet, this part is just good practice
            foreach ($items as $item) {
                $pid = $item['product_id'];
                $qty = $item['quantity'];
                $pri = $item['price'];
                
                // Using a check to see if order_items table exists
                $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'order_items'");
                if(mysqli_num_rows($check_table) > 0) {
                    $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                 VALUES ($order_id, $pid, $qty, $pri)";
                    mysqli_query($conn, $item_sql);
                }
            }

            // 4. Clear the Cart
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

            // Redirect to success or account page
            header("Location: ../account.php?order_success=1");
        } else {
            header("Location: ../checkout.php?error=db_error");
        }
    } else {
        header("Location: ../cart.php");
    }
    exit();
}
?>