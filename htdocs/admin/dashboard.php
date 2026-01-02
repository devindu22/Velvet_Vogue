<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check: Only allow admins
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../signin.php?error=access_denied");
    exit();
}

// Use main header (which already includes db.php)
include 'includes/admin_header.php';

// Ensure $conn is available if header.php uses include_once
if (!isset($conn)) {
    include '../includes/db.php';
}

// Fetch Statistics with error suppression/fallbacks
$total_products_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
$total_products = ($total_products_res) ? mysqli_fetch_assoc($total_products_res)['count'] : 0;

$total_orders_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders");
$total_orders = ($total_orders_res) ? mysqli_fetch_assoc($total_orders_res)['count'] : 0;

$total_revenue_res = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders");
$total_revenue = ($total_revenue_res) ? (mysqli_fetch_assoc($total_revenue_res)['total'] ?? 0) : 0;

// Fetch Recent Products with category names
$products_res = mysqli_query($conn, "SELECT p.*, c.name as category_name 
                                     FROM products p 
                                     LEFT JOIN categories c ON p.category_id = c.id 
                                     ORDER BY p.id DESC");
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h6 class="text-gold fw-bold text-uppercase tracking-widest small mb-1">Administration</h6>
            <h2 class="fw-bold display-6" style="font-family: 'Playfair Display', serif;">House Dashboard</h2>
        </div>
        <a href="add_product.php" class="btn btn-dark px-4 py-2 rounded-0 small fw-bold tracking-widest">
            <i class="fas fa-plus me-2"></i> ADD NEW PIECE
        </a>
    </div>

    <!-- Statistics Grid -->
    <div class="row g-4 mb-5 text-center">
        <div class="col-md-4">
            <div class="p-4 border bg-white shadow-sm">
                <p class="text-muted extra-small text-uppercase tracking-widest fw-bold mb-2">Total Inventory</p>
                <h3 class="fw-bold mb-0"><?php echo $total_products; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border bg-white shadow-sm">
                <p class="text-muted extra-small text-uppercase tracking-widest fw-bold mb-2">Total Orders</p>
                <h3 class="fw-bold mb-0"><?php echo $total_orders; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border bg-white shadow-sm">
                <p class="text-muted extra-small text-uppercase tracking-widest fw-bold mb-2">Revenue</p>
                <h3 class="fw-bold text-gold mb-0">LKR <?php echo number_format($total_revenue, 0); ?></h3>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white border shadow-sm">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 small text-uppercase tracking-wider">Product Catalog</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 py-3 small text-uppercase tracking-widest">Product</th>
                        <th class="border-0 py-3 small text-uppercase tracking-widest">Collection</th>
                        <th class="border-0 py-3 small text-uppercase tracking-widest">Price</th>
                        <th class="border-0 py-3 small text-uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($products_res && mysqli_num_rows($products_res) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($products_res)): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center py-2">
                                    <img src="../assets/images/<?php echo htmlspecialchars($row['image']); ?>" 
                                         class="border" style="width: 45px; height: 60px; object-fit: cover;"
                                         onerror="this.src='https://via.placeholder.com/45x60?text=No+Img'">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-0 small"><?php echo htmlspecialchars($row['name']); ?></p>
                                        <p class="text-muted mb-0 extra-small">ID: #<?php echo $row['id']; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal"><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></span>
                            </td>
                            <td class="fw-bold small">LKR <?php echo number_format($row['price'], 2); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-dark btn-sm rounded-0" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-outline-danger btn-sm rounded-0" 
                                       onclick="return confirm('Remove this piece from the collection permanently?')" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No products found in the boutique inventory.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .text-gold { color: #d4af37 !important; }
    .extra-small { font-size: 0.7rem; }
    .tracking-widest { letter-spacing: 2px; }
    .table thead th { font-weight: 700; color: #888; letter-spacing: 0.5px; font-size: 0.65rem; }
</style>

<?php include 'includes/admin_footer.php'; ?>