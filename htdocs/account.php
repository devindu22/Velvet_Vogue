<?php 
session_start(); 
if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}
include 'includes/header.php'; 
include 'includes/db.php';

$user_id = $_SESSION['user']['id'];
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Fetch orders
$orders_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);

?>

<style>
    .account-section { padding: 60px 0; }
    .profile-card { border: none; background: #fff; }
    .info-group { margin-bottom: 25px; }
    .info-label { 
        font-size: 0.65rem; 
        text-transform: uppercase; 
        color: #aaa; 
        letter-spacing: 1.5px; 
        font-weight: 700; 
        display: block;
        margin-bottom: 5px;
    }
    .info-value { font-size: 0.95rem; color: #111; font-weight: 500; }
    
    .nav-tabs-custom { border-bottom: 1px solid #eee; margin-bottom: 40px; }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #999;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        padding: 15px 0;
        margin-right: 40px;
        position: relative;
        background: none;
        cursor: pointer;
    }
    .nav-tabs-custom .nav-link.active { color: #111; }
    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 2px;
        background: #c5a059;
    }

    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeIn 0.4s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

    /* Wishlist Items */
    .wishlist-item { border-bottom: 1px solid #f5f5f5; padding: 20px 0; transition: all 0.3s; }
    .wishlist-item:hover { background: #fafafa; }
    .wishlist-img { width: 70px; height: 90px; object-fit: cover; background: #f9f9f9; }
    .wishlist-name { font-weight: 600; color: #111; text-decoration: none; font-size: 0.95rem; }
    
    .btn-wishlist-action {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        padding: 8px 15px;
        border-radius: 0;
    }

    /* Wallet Card */
    .payment-card-visual {
        background: linear-gradient(135deg, #222 0%, #000 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        width: 100%;
        max-width: 350px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>

<div class="account-section">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <div class="d-flex align-items-center mb-5">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-light" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <?php echo strtoupper(substr($user_data['name'], 0, 1)); ?>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-0"><?php echo $user_data['name']; ?></h5>
                            <p class="text-muted small mb-0">Member since <?php echo date('Y'); ?></p>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Email Address</span>
                        <span class="info-value"><?php echo $user_data['email']; ?></span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Phone</span>
                        <span class="info-value"><?php echo $user_data['phone'] ?? '—'; ?></span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Shipping Address</span>
                        <span class="info-value text-muted small lh-base"><?php echo $user_data['address'] ?? 'No address saved yet.'; ?></span>
                    </div>

                    <button class="btn btn-outline-dark btn-sm rounded-0 w-100 py-2 mt-3 text-uppercase small fw-bold">Edit Profile</button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-8">
                <div class="nav nav-tabs-custom">
                    <button class="nav-link active" onclick="switchTab(event, 'orders')">Orders</button>
                    <button class="nav-link" onclick="switchTab(event, 'wishlist')">Wishlist</button>
                    <button class="nav-link" onclick="switchTab(event, 'wallet')">Wallet</button>
                    <button class="nav-link" onclick="switchTab(event, 'security')">Settings</button>
                </div>

                <!-- Orders -->
                <div id="orders" class="tab-pane active">
                    <?php if ($orders_result && mysqli_num_rows($orders_result) > 0): ?>
                        <?php while($order = mysqli_fetch_assoc($orders_result)): ?>
                            <div class="order-row border-bottom py-3">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <span class="info-label">Order</span>
                                        <span class="fw-bold">#<?php echo $order['id']; ?></span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span class="info-label">Total</span>
                                        <span class="small">LKR <?php echo number_format($order['total_amount'], 2); ?></span>
                                    </div>
                                    <div class="col-4 text-end">
                                        <span class="status-pill px-3 py-1 border small fw-bold">Confirmed</span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted py-5 text-center small text-uppercase">No orders placed yet.</p>
                    <?php endif; ?>
                </div>

                <!-- Wishlist Tab -->
                <div id="wishlist" class="tab-pane">
                        <div class="text-center py-5">
                            <p class="text-muted small text-uppercase mb-3">Your wishlist is empty</p>
                            <a href="shop.php" class="btn btn-outline-dark btn-sm rounded-0 px-4">Browse Collection</a>
                        </div>
                </div>

                <!-- Wallet -->
                <div id="wallet" class="tab-pane">
                    <h6 class="fw-bold text-uppercase small letter-spacing-1 mb-4">Saved Cards</h6>
                    <div class="payment-card-visual mb-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <div style="width: 40px; height: 28px; background: #f9f295; border-radius: 4px;"></div>
                            <i class="fab fa-cc-visa fa-2x opacity-50"></i>
                        </div>
                        <div class="fs-5 letter-spacing-2 mb-4">•••• •••• •••• 8842</div>
                        <div class="row">
                            <div class="col-8">
                                <div class="info-label text-white-50">Card Holder</div>
                                <div class="small text-uppercase"><?php echo $user_data['name']; ?></div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="info-label text-white-50">Expiry</div>
                                <div class="small">12/28</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-dark btn-sm rounded-0">Add New Payment Method</button>
                </div>

                <!-- Security/Settings -->
                <div id="security" class="tab-pane">
                    <h6 class="fw-bold text-uppercase small mb-4">Account Settings</h6>
                    <div class="border p-4 mb-4">
                        <label class="info-label">Password</label>
                        <p class="small text-muted mb-3">Change your current account password.</p>
                        <button class="btn btn-dark btn-sm rounded-0 px-4">Update Password</button>
                    </div>
                    <div class="border p-4 border-danger">
                        <label class="info-label text-danger">Danger Zone</label>
                        <p class="small text-muted mb-3">Permanently delete your account and all data.</p>
                        <button class="btn btn-outline-danger btn-sm rounded-0 px-4">Delete Account</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(evt, tabId) {
        const panes = document.getElementsByClassName("tab-pane");
        for (let i = 0; i < panes.length; i++) {
            panes[i].classList.remove("active");
        }

        const links = document.getElementsByClassName("nav-link");
        for (let i = 0; i < links.length; i++) {
            links[i].classList.remove("active");
        }

        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>

<?php include 'includes/footer.php'; ?>