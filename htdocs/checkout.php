<?php 
include 'includes/header.php'; 
include 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php?error=auth_required");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Get user data for pre-filling
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Fetch Cart for Summary
$cart_query = "SELECT c.quantity, p.name, p.price, p.image 
               FROM cart c JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

$total_bill = 0;
if (mysqli_num_rows($cart_result) == 0) {
    header("Location: cart.php");
    exit();
}
?>

<style>
    :root {
        --vv-gold: #c5a059;
        --vv-bg: #fcfcfc;
    }
    body { background-color: var(--vv-bg); }

    .checkout-container { padding: 60px 0; }
    
    .checkout-form-section { background: white; padding: 40px; border: 1px solid #eee; }
    
    .form-label { 
        font-size: 0.65rem; 
        text-transform: uppercase; 
        letter-spacing: 1.5px; 
        font-weight: 700; 
        color: #999; 
    }
    .form-control {
        border-radius: 0;
        border: none;
        border-bottom: 1px solid #eee;
        padding: 12px 0;
        font-size: 0.95rem;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #111;
        background: transparent;
    }

    .payment-option {
        border: 1px solid #eee;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 15px;
        position: relative;
    }
    .payment-option:hover { border-color: #ccc; }
    .payment-option input { position: absolute; opacity: 0; }
    .payment-option.active { border-color: #111; background: #fafafa; }
    .payment-option.active::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 20px;
        right: 20px;
        color: #111;
    }

    .order-summary-box { background: #fff; padding: 40px; border: 1px solid #eee; position: sticky; top: 120px; }
    .summary-item { display: flex; align-items: center; margin-bottom: 20px; }
    .summary-img { width: 50px; height: 65px; object-fit: cover; background: #f9f9f9; margin-right: 15px; }

    .btn-place-order {
        background: #111;
        color: #fff;
        border: none;
        border-radius: 0;
        padding: 20px;
        width: 100%;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-top: 30px;
    }
    .btn-place-order:hover { background: var(--vv-gold); color: #fff; }
</style>

<div class="checkout-container">
    <div class="container">
        <form action="actions/process_checkout.php" method="POST" id="checkoutForm">
            <div class="row g-5">
                <!-- Left: Details -->
                <div class="col-lg-7">
                    <div class="checkout-form-section mb-4">
                        <h4 class="fw-bold mb-4">Shipping Information</h4>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $user_data['name']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo $user_data['email']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $user_data['phone']; ?>" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Delivery Address</label>
                                <input type="text" name="address" class="form-control" value="<?php echo $user_data['address']; ?>" required placeholder="House No, Street Name, City">
                            </div>
                        </div>
                    </div>

                    <div class="checkout-form-section">
                        <h4 class="fw-bold mb-4">Payment Method</h4>
                        
                        <label class="payment-option active" id="labelCard">
                            <input type="radio" name="paymentMethod" value="Credit Card" checked onclick="updatePayment(this)">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-credit-card fa-lg me-3"></i>
                                <div>
                                    <span class="d-block fw-bold small">Online Payment</span>
                                    <span class="text-muted small">Visa, Mastercard, AMEX</span>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option" id="labelCOD">
                            <input type="radio" name="paymentMethod" value="COD" onclick="updatePayment(this)">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-truck fa-lg me-3"></i>
                                <div>
                                    <span class="d-block fw-bold small">Cash on Delivery</span>
                                    <span class="text-muted small">Pay when you receive the item</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="col-lg-5">
                    <div class="order-summary-box">
                        <h5 class="fw-bold mb-4 text-uppercase letter-spacing-1">Your Order</h5>
                        
                        <div class="mb-4">
                            <?php while($item = mysqli_fetch_assoc($cart_result)): 
                                $sub = $item['price'] * $item['quantity'];
                                $total_bill += $sub;
                                $img = !empty($item['image']) ? "assets/images/".$item['image'] : "https://via.placeholder.com/100x120";
                            ?>
                                <div class="summary-item">
                                    <img src="<?php echo $img; ?>" class="summary-img">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="small fw-bold"><?php echo $item['name']; ?></span>
                                            <span class="small">LKR <?php echo number_format($sub, 2); ?></span>
                                        </div>
                                        <span class="text-muted" style="font-size: 0.7rem;">Qty: <?php echo $item['quantity']; ?></span>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal</span>
                                <span class="small">LKR <?php echo number_format($total_bill, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Shipping</span>
                                <span class="text-success small fw-bold">FREE</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span class="fw-bold">Total Amount</span>
                                <span class="fw-bold fs-5">LKR <?php echo number_format($total_bill, 2); ?></span>
                            </div>
                        </div>

                        <button type="submit" class="btn-place-order">Complete Purchase</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePayment(el) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        el.parentElement.classList.add('active');
    }
</script>

<?php include 'includes/footer.php'; ?>