<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Security Check (MUST BE FIRST)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit();
}

// 2. Database connection
include '../includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// 3. Handle Update Logic (BEFORE any HTML output)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cat = intval($_POST['category_id']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['colour']);

    $update_query = "UPDATE products SET 
                     name = '$name', 
                     category_id = $cat, 
                     description = '$desc', 
                     price = $price, 
                     size = '$size', 
                     colour = '$color'";

    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $img);
        $update_query .= ", image = '$img'";
    }

    $update_query .= " WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        // Successful redirect works now because no HTML has been sent yet!
        header("Location: dashboard.php?updated=1");
        exit();
    } else {
        $message = "Update failed: " . mysqli_error($conn);
    }
}

// 4. Fetch current data for the form
$res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($res);
$cat_res = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

if (!$product) {
    die("Piece not found.");
}

// 5. Finally, include the header (starts HTML output)
include 'includes/admin_header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-5 text-center">
                <h6 class="text-gold fw-bold text-uppercase tracking-widest small mb-1">Curation</h6>
                <h2 class="fw-bold" style="font-family: 'Playfair Display', serif;">Update Collection Piece</h2>
                <hr class="mx-auto" style="width: 50px; border-top: 2px solid #d4af37;">
            </div>

            <?php if($message): ?>
                <div class="alert alert-danger rounded-0"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm p-4 bg-white border">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Product Name</label>
                            <input type="text" name="name" class="form-control rounded-0" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Category</label>
                            <select name="category_id" class="form-select rounded-0" required>
                                <?php while($cat = mysqli_fetch_assoc($cat_res)): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Price (LKR)</label>
                            <input type="number" step="0.01" name="price" class="form-control rounded-0" value="<?php echo $product['price']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Size</label>
                            <input type="text" name="size" class="form-control rounded-0" value="<?php echo htmlspecialchars($product['size']); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Colour</label>
                            <input type="text" name="colour" class="form-control rounded-0" value="<?php echo htmlspecialchars($product['colour']); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Description</label>
                            <textarea name="description" rows="4" class="form-control rounded-0"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Product Image</label>
                            <div class="d-flex align-items-center gap-3 p-3 border bg-light">
                                <img src="../assets/images/<?php echo $product['image']; ?>" style="width: 50px; height: 70px; object-fit: cover;" class="border">
                                <input type="file" name="image" class="form-control rounded-0 bg-white">
                            </div>
                        </div>
                        <div class="col-12 pt-3">
                            <button type="submit" name="update_product" class="btn btn-dark w-100 py-3 rounded-0 fw-bold tracking-widest text-uppercase">Update Piece</button>
                            <div class="text-center mt-3">
                                <a href="dashboard.php" class="text-muted small text-decoration-none">Cancel Changes</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>