<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/db.php';

// --- Handle Filtering Logic ---
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : null;
$search_filter = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$price_filter = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$color_filter = isset($_GET['color']) ? mysqli_real_escape_string($conn, $_GET['color']) : '';
$size_filter = isset($_GET['size']) ? mysqli_real_escape_string($conn, $_GET['size']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// Base Query
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id";

$conditions = [];

if ($category_filter) { $conditions[] = "p.category_id = $category_filter"; }
if ($search_filter) { $conditions[] = "(p.name LIKE '%$search_filter%' OR p.description LIKE '%$search_filter%')"; }
if ($color_filter) { $conditions[] = "p.colour = '$color_filter'"; }
if ($size_filter) { $conditions[] = "p.size LIKE '%$size_filter%'"; }

// Price Range Logic
if ($price_filter) {
    if ($price_filter == 'under-5000') { $conditions[] = "p.price < 5000"; }
    elseif ($price_filter == '5000-15000') { $conditions[] = "p.price BETWEEN 5000 AND 15000"; }
    elseif ($price_filter == 'above-15000') { $conditions[] = "p.price > 15000"; }
}

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

// --- Handle Sorting Logic ---
switch ($sort) {
    case 'price_low': $query .= " ORDER BY p.price ASC"; break;
    case 'price_high': $query .= " ORDER BY p.price DESC"; break;
    case 'oldest': $query .= " ORDER BY p.id ASC"; break;
    default: $query .= " ORDER BY p.id DESC"; break; // latest
}

$result = mysqli_query($conn, $query);

// Fetch dynamic filter options
$cat_res = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
$color_res = mysqli_query($conn, "SELECT DISTINCT colour FROM products WHERE colour != '' ORDER BY colour ASC");
?>

<div class="shop-header bg-black text-white py-5 mb-5">
    <div class="container text-center py-4">
        <h1 class="display-4 fw-bold mb-2" style="font-family: 'Playfair Display', serif;">The Collection</h1>
        <p class="text-gold tracking-widest text-uppercase small fw-bold">Sophisticated Style for Every Occasion</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Enhanced Sidebar Filters -->
        <div class="col-lg-3 pe-lg-5 mb-5">
            <div class="filter-sidebar">
                
                <!-- NEW: Keyword Search Option -->
                <div class="mb-5">
                    <h5 class="fw-bold text-uppercase tracking-widest mb-4 small">Search</h5>
                    <form action="shop.php" method="GET" class="position-relative">
                        <!-- Keep existing filters in hidden inputs so search doesn't reset them -->
                        <?php if($category_filter): ?><input type="hidden" name="category" value="<?php echo $category_filter; ?>"><?php endif; ?>
                        <?php if($price_filter): ?><input type="hidden" name="price_range" value="<?php echo $price_filter; ?>"><?php endif; ?>
                        
                        <input type="text" name="search" class="form-control border-0 border-bottom rounded-0 px-0 small bg-transparent" 
                               placeholder="Keywords..." value="<?php echo htmlspecialchars($search_filter); ?>" style="font-size: 0.85rem;">
                        <button type="submit" class="btn p-0 position-absolute end-0 top-0 mt-1" style="background: none; border: none;">
                            <i class="fas fa-search small"></i>
                        </button>
                    </form>
                </div>

                <!-- Category Filter -->
                <div class="mb-5">
                    <h5 class="fw-bold text-uppercase tracking-widest mb-4 small">Collections</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="shop.php" class="text-decoration-none filter-link <?php echo !$category_filter ? 'active' : ''; ?>">All Items</a>
                        </li>
                        <?php while($cat = mysqli_fetch_assoc($cat_res)): ?>
                        <li class="mb-2">
                            <a href="shop.php?category=<?php echo $cat['id']; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search_filter); ?>" 
                               class="text-decoration-none filter-link <?php echo ($category_filter == $cat['id']) ? 'active' : ''; ?>">
                                <?php echo $cat['name']; ?>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <!-- NEW: Choose Size Option -->
                <div class="mb-5">
                    <h5 class="fw-bold text-uppercase tracking-widest mb-4 small">Size</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $available_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                        foreach($available_sizes as $s): 
                            $size_active = ($size_filter == $s) ? 'size-active' : '';
                        ?>
                            <a href="shop.php?size=<?php echo $s; ?>&category=<?php echo $category_filter; ?>&search=<?php echo urlencode($search_filter); ?>&price_range=<?php echo $price_filter; ?>" 
                               class="size-option <?php echo $size_active; ?>">
                                <?php echo $s; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="mb-5">
                    <h5 class="fw-bold text-uppercase tracking-widest mb-4 small">Price Range</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="shop.php?price_range=under-5000&category=<?php echo $category_filter; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search_filter); ?>" class="filter-link small <?php echo $price_filter == 'under-5000' ? 'active' : ''; ?>">Under LKR 5,000</a>
                        <a href="shop.php?price_range=5000-15000&category=<?php echo $category_filter; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search_filter); ?>" class="filter-link small <?php echo $price_filter == '5000-15000' ? 'active' : ''; ?>">LKR 5,000 - 15,000</a>
                        <a href="shop.php?price_range=above-15000&category=<?php echo $category_filter; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search_filter); ?>" class="filter-link small <?php echo $price_filter == 'above-15000' ? 'active' : ''; ?>">Above LKR 15,000</a>
                    </div>
                </div>

                <!-- Color Filter -->
                <div class="mb-5">
                    <h5 class="fw-bold text-uppercase tracking-widest mb-4 small">Color Palette</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php while($c_row = mysqli_fetch_assoc($color_res)): ?>
                            <a href="shop.php?color=<?php echo urlencode($c_row['colour']); ?>&category=<?php echo $category_filter; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search_filter); ?>" 
                               class="badge rounded-pill border py-2 px-3 text-decoration-none <?php echo $color_filter == $c_row['colour'] ? 'bg-dark text-white' : 'bg-light text-dark'; ?>" 
                               style="font-size: 0.7rem;">
                                <?php echo strtoupper($c_row['colour']); ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>

                <a href="shop.php" class="btn btn-outline-dark btn-sm w-100 py-2 tracking-widest fw-bold">RESET ALL FILTERS</a>
            </div>
        </div>

        <!-- Product Grid Area -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <p class="text-muted small mb-0">Discovering <strong><?php echo mysqli_num_rows($result); ?></strong> unique pieces</p>
                
                <!-- Working Sort Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle fw-bold small text-uppercase tracking-widest border-bottom rounded-0" type="button" data-bs-toggle="dropdown">
                        Sort By: <?php 
                            if($sort == 'price_low') echo 'Price: Low to High';
                            elseif($sort == 'price_high') echo 'Price: High to Low';
                            else echo 'Latest Arrivals';
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-0">
                        <li><a class="dropdown-item small" href="shop.php?sort=latest&category=<?php echo $category_filter; ?>&price_range=<?php echo $price_filter; ?>&search=<?php echo urlencode($search_filter); ?>">Latest Arrivals</a></li>
                        <li><a class="dropdown-item small" href="shop.php?sort=price_low&category=<?php echo $category_filter; ?>&price_range=<?php echo $price_filter; ?>&search=<?php echo urlencode($search_filter); ?>">Price: Low to High</a></li>
                        <li><a class="dropdown-item small" href="shop.php?sort=price_high&category=<?php echo $category_filter; ?>&price_range=<?php echo $price_filter; ?>&search=<?php echo urlencode($search_filter); ?>">Price: High to Low</a></li>
                    </ul>
                </div>
            </div>

            <div class="row g-4">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-6 col-md-4">
                            <div class="vv-product-card bg-white p-2 border-0 h-100">
                                <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none">
                                    <div class="vv-img-container">
                                        <?php $img = !empty($row['image']) ? "assets/images/".$row['image'] : "https://via.placeholder.com/400x600?text=Velvet+Vogue"; ?>
                                        <img src="<?php echo $img; ?>" alt="<?php echo $row['name']; ?>" class="img-fluid">
                                        <div class="vv-quick-add"><span>EXPLORE PIECE</span></div>
                                    </div>
                                    <div class="pt-3 px-1">
                                        <p class="text-gold fw-bold extra-small mb-1 text-uppercase tracking-widest"><?php echo $row['category_name']; ?></p>
                                        <h6 class="text-dark fw-bold mb-1" style="font-size: 0.95rem;"><?php echo $row['name']; ?></h6>
                                        <p class="text-muted fw-bold m-0" style="font-size: 0.85rem;">LKR <?php echo number_format($row['price'], 2); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <h4 class="fw-bold">No pieces match your search</h4>
                        <p class="text-muted">Try removing some filters to see more results.</p>
                        <a href="shop.php" class="btn btn-dark px-4 py-2 mt-2">Clear All Filters</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-link { color: #888; transition: 0.3s; font-size: 0.85rem; font-weight: 500; text-decoration: none; }
    .filter-link:hover, .filter-link.active { color: #d4af37; font-weight: 600; transform: translateX(5px); display: inline-block; }
    
    /* Size selection styles */
    .size-option { 
        width: 38px; height: 38px; 
        display: flex; align-items: center; justify-content: center; 
        border: 1px solid #eee; text-decoration: none; color: #888; 
        font-size: 0.75rem; font-weight: 600; transition: 0.3s;
    }
    .size-option:hover { border-color: #d4af37; color: #d4af37; }
    .size-active { background: #000; color: #fff; border-color: #000; }
    .size-active:hover { color: #fff; }

    .vv-img-container { position: relative; overflow: hidden; background: #fdfdfd; }
    .vv-img-container img { transition: 0.8s; width: 100%; aspect-ratio: 3/4; object-fit: cover; }
    .vv-quick-add { position: absolute; bottom: -50px; width: 100%; background: #000; color: #fff; padding: 12px; text-align: center; transition: 0.3s; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; }
    .vv-product-card:hover .vv-quick-add { bottom: 0; }
    .vv-product-card:hover img { transform: scale(1.08); filter: brightness(0.9); }
    .text-gold { color: #d4af37 !important; }
    .extra-small { font-size: 0.65rem; }
</style>

<?php include 'includes/footer.php'; ?>