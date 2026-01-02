<?php
session_start();

// 1. SECURITY CHECK FIRST (Before any HTML output)
if (!isset($_SESSION['user'])) {
header("Location: signin.php?error=please_signin");
exit();
}

// 2. NOW include headers and DB
include 'includes/header.php';
include 'includes/db.php';

$user_id = $_SESSION['user']['id'];

// Fetch cart items
$query = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.image, p.size, p.colour
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

$total_bill = 0;
?>

<style>
:root {
--vv-gold: #c5a059;
--vv-light-gray: #f9f9f9;
--vv-border: #eeeeee;
}

.cart-header { padding: 60px 0 40px; }
.cart-header h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; letter-spacing: -1px; }

.cart-item { padding: 30px 0; border-bottom: 1px solid var(--vv-border); transition: opacity 0.3s; }
.cart-item:first-child { border-top: 1px solid var(--vv-border); }

.cart-img-wrapper { 
    background: #fcfcfc;
    width: 120px;
    height: 160px;
    overflow: hidden;
}
.cart-img { width: 100%; height: 100%; object-fit: cover; }

.item-details h5 { font-weight: 600; font-size: 1rem; margin-bottom: 5px; }
.item-meta { color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }

.qty-selector { display: flex; align-items: center; border: 1px solid #ddd; width: fit-content; }
.qty-btn { border: none; background: none; padding: 5px 12px; font-size: 1rem; }
.qty-input { width: 40px; border: none; text-align: center; font-size: 0.9rem; background: transparent; }

.summary-card { background: var(--vv-light-gray); padding: 35px; border-radius: 0; position: sticky; top: 100px; }
.summary-title { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; color: #999; margin-bottom: 25px; }

.btn-checkout { 
    background: #111; 
    color: white; 
    width: 100%; 
    border-radius: 0; 
    padding: 18px; 
    text-transform: uppercase; 
    font-weight: 700; 
    font-size: 0.8rem; 
    letter-spacing: 2px;
    transition: 0.3s;
    border: none;
}
.btn-checkout:hover { background: var(--vv-gold); color: white; }

.remove-link { font-size: 0.65rem; text-transform: uppercase; color: #cc0000; text-decoration: none; font-weight: 700; letter-spacing: 1px; }
.letter-spacing-2 { letter-spacing: 2px; }


</style>

<div class="container pb-5 mb-5">
<div class="cart-header text-center">
<h1 class="mb-2">Your Shopping Bag</h1>
<p class="text-muted small text-uppercase letter-spacing-2">Carefully curated for your elegance</p>
</div>

<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <div class="row g-5">
        <!-- Items List -->
        <div class="col-lg-8">
            <?php while($item = mysqli_fetch_assoc($result)): 
                $subtotal = $item['price'] * $item['quantity'];
                $total_bill += $subtotal;
            ?>
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2">
                            <div class="cart-img-wrapper">
                                <img src="assets/images/<?php echo $item['image']; ?>" class="cart-img" alt="<?php echo $item['name']; ?>">
                            </div>
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="item-details">
                                        <p class="item-meta mb-1"><?php echo $item['colour']; ?> / <?php echo $item['size']; ?></p>
                                        <h5><?php echo $item['name']; ?></h5>
                                        <a href="actions/remove_cart.php?id=<?php echo $item['cart_id']; ?>" class="remove-link">Remove Item</a>
                                    </div>
                                </div>
                                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                    <div class="d-flex flex-md-column justify-content-between h-100">
                                        <p class="fw-bold mb-0">LKR <?php echo number_format($item['price'], 2); ?></p>
                                        
                                        <div class="mt-md-3 d-flex align-items-center justify-content-md-end">
                                            <div class="qty-selector me-3 me-md-0">
                                                <button class="qty-btn" onclick="updateQty(<?php echo $item['cart_id']; ?>, 'minus')">-</button>
                                                <input type="text" value="<?php echo $item['quantity']; ?>" class="qty-input" readonly>
                                                <button class="qty-btn" onclick="updateQty(<?php echo $item['cart_id']; ?>, 'plus')">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <div class="mt-4">
                <a href="shop.php" class="text-dark small fw-bold text-decoration-none text-uppercase letter-spacing-2">
                    <i class="fas fa-arrow-left me-2"></i> Continue Browsing
                </a>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <div class="col-lg-4">
            <div class="summary-card">
                <h6 class="summary-title">Order Summary</h6>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Subtotal</span>
                    <span class="fw-bold small">LKR <?php echo number_format($total_bill, 2); ?></span>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted small">Shipping</span>
                    <span class="text-success small fw-bold">Calculated at next step</span>
                </div>

                <hr class="mb-4" style="opacity: 0.1;">

                <div class="d-flex justify-content-between mb-4 align-items-center">
                    <span class="fw-bold text-uppercase small">Total Amount</span>
                    <span class="fs-4 fw-bold">LKR <?php echo number_format($total_bill, 2); ?></span>
                </div>

                <p class="small text-muted mb-4 mt-2" style="font-size: 0.7rem; line-height: 1.4;">
                    Shipping & taxes calculated at checkout. Secure encrypted payment processing.
                </p>

                <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
                
                <div class="text-center mt-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="15" class="me-3 opacity-70">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" height="15" class="opacity-70">
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-shopping-bag fa-3x text-light"></i>
        </div>
        <h3 class="fw-light mb-3">Your bag is currently empty.</h3>
        <p class="text-muted mb-5">Discover our new arrivals and find something special.</p>
        <a href="shop.php" class="btn btn-dark rounded-0 px-5 py-3 text-uppercase letter-spacing-2 small">Explore Collections</a>
    </div>
<?php endif; ?>


</div>

<script>
function updateQty(cartId, action) {
// Basic redirect for quantity updates - ideally this would be AJAX
window.location.href = `actions/update_cart.php?id=${cartId}&action=${action}`;
}
</script>

<?php include 'includes/footer.php'; ?>