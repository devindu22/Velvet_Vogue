<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Security Check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit();
}

// 2. Database
include '../includes/db.php';

// 3. Handle Processing (Before HTML output)
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cat = intval($_POST['category_id']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['colour']);

    $img = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($img);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO products (name, category_id, description, price, size, colour, image)
                  VALUES ('$name', $cat, '$desc', $price, '$size', '$color', '$img')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: dashboard.php?added=1");
            exit();
        } else {
            $message = "Database Error: " . mysqli_error($conn);
        }
    } else {
        $message = "Failed to upload image.";
    }
}

// 4. Fetch categories
$cat_res = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

// 5. HTML Header
include 'includes/admin_header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-5 text-center">
                <h6 class="text-gold fw-bold text-uppercase tracking-widest small mb-1">New Arrival</h6>
                <h2 class="fw-bold" style="font-family: 'Playfair Display', serif;">Add Collection Piece</h2>
                <hr class="mx-auto" style="width: 50px; border-top: 2px solid #d4af37;">
            </div>

            <?php if($message): ?>
                <div class="alert alert-danger rounded-0 small"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm p-4 bg-white border">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Product Name</label>
                            <input type="text" name="name" class="form-control rounded-0" placeholder="e.g. Silk Evening Gown" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Category</label>
                            <select name="category_id" class="form-select rounded-0" required>
                                <option value="">Select Category</option>
                                <?php while($cat = mysqli_fetch_assoc($cat_res)): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Price (LKR)</label>
                            <input type="number" step="0.01" name="price" class="form-control rounded-0" placeholder="0.00" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Size</label>
                            <input type="text" name="size" class="form-control rounded-0" placeholder="S, M, L">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Colour</label>
                            <input type="text" name="colour" class="form-control rounded-0" placeholder="e.g. Ivory">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Description</label>
                            <textarea name="description" rows="4" class="form-control rounded-0" placeholder="Describe the craftsmanship..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Product Image</label>
                            <input type="file" name="image" class="form-control rounded-0" required>
                        </div>
                        <div class="col-12 pt-3">
                            <button type="submit" name="add_product" class="btn btn-dark w-100 py-3 rounded-0 fw-bold tracking-widest text-uppercase">Add to Collection</button>
                            <div class="text-center mt-3">
                                <a href="dashboard.php" class="text-muted small text-decoration-none">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>