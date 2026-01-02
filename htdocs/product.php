<?php 
include 'includes/header.php'; 
include 'includes/db.php';

// Get product ID from URL and sanitize it
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<div class='container my-5 text-center py-5'><h3 class='display-6'>Product not found.</h3><a href='shop.php' class='btn btn-outline-dark mt-3 px-4'>Return to Shop</a></div>";
    include 'includes/footer.php';
    exit;
}
?>

<style>
    /* Premium Styling Overrides */
    :root {
        --premium-black: #1a1a1a;
        --premium-gray: #f8f9fa;
        --accent-gold: #c5a059; /* Optional luxury accent */
    }

    .breadcrumb-item + .breadcrumb-item::before { content: "•"; color: #ccc; }
    .breadcrumb a { font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase; transition: color 0.3s; }
    
    .product-title { font-size: 2.8rem; letter-spacing: -0.02em; line-height: 1.1; color: var(--premium-black); }
    .product-price { font-size: 1.75rem; font-weight: 300; color: #444; margin-bottom: 2rem; }
    
    /* Image Section: Sticky Behavior for Desktop */
    @media (min-width: 768px) {
        .sticky-column { position: sticky; top: 100px; height: fit-content; }
    }
    
    .product-image-wrapper {
        background: var(--premium-gray);
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-image-wrapper:hover img { transform: scale(1.03); }
    .product-image-wrapper img { transition: transform 0.8s ease; }

    /* Custom Controls */
    .qty-input-group {
        border: 1px solid #e0e0e0;
        border-radius: 50px;
        padding: 4px;
        background: #fff;
        display: inline-flex;
        align-items: center;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: #000;
        font-weight: bold;
        transition: background 0.2s;
    }
    .qty-btn:hover { background: #f0f0f0; }
    .qty-val { border: none; text-align: center; width: 40px; font-weight: 600; outline: none; }

    .btn-buy {
        background: var(--premium-black);
        color: white;
        border-radius: 50px;
        padding: 1rem 2rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1px solid var(--premium-black);
        transition: all 0.3s ease;
    }
    .btn-buy:hover {
        background: transparent;
        color: var(--premium-black);
        transform: translateY(-2px);
    }

    .attribute-label { font-size: 0.75rem; text-transform: uppercase; color: #888; letter-spacing: 0.1em; font-weight: 700; }
    .attribute-value { font-size: 1.1rem; color: #333; font-weight: 500; }
    
    .section-divider { border-top: 1px solid #eee; margin: 2rem 0; }
</style>

<div class="container my-5 py-md-5">
    <div class="row g-lg-5">
        <!-- Product Image -->
        <div class="col-md-7 col-lg-6">
            <div class="sticky-column">
                <div class="product-image-wrapper shadow-sm">
                    <?php $img = !empty($product['image']) ? "assets/images/".$product['image'] : "https://via.placeholder.com/800x1000?text=Premium+Collection"; ?>
                    <img src="<?php echo $img; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid w-100">
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-5 col-lg-6 mt-5 mt-md-0">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="shop.php" class="text-decoration-none text-muted">Collections</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $product['category_name']; ?></li>
                </ol>
            </nav>

            <h1 class="product-title fw-bold mb-2"><?php echo $product['name']; ?></h1>
            <div class="product-price">
                LKR <?php echo number_format($product['price'], 0); ?>
            </div>
            
            <div class="mb-5">
                <p class="attribute-label mb-2">The Story</p>
                <p class="text-secondary lh-lg" style="font-size: 1.05rem;"><?php echo nl2br($product['description']); ?></p>
            </div>

            <div class="row mb-5">
                <div class="col-6">
                    <p class="attribute-label mb-1">Colour</p>
                    <p class="attribute-value"><?php echo $product['colour']; ?></p>
                </div>
                <div class="col-6">
                    <p class="attribute-label mb-1">Available Size</p>
                    <p class="attribute-value"><?php echo $product['size']; ?></p>
                </div>
            </div>

            <div class="section-divider"></div>

            <!-- Add to Cart Form -->
            <form action="actions/add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                
                <div class="d-flex flex-column flex-sm-row gap-4 align-items-start align-items-sm-center">
                    <div>
                        <p class="attribute-label mb-2">Quantity</p>
                        <div class="qty-input-group">
                            <button type="button" class="qty-btn" onclick="updateQty(-1)">−</button>
                            <input type="number" name="qty" id="qty" class="qty-val" value="1" min="1" readonly>
                            <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                        </div>
                    </div>
                    
                    <div class="flex-grow-1 w-100">
                        <p class="d-none d-sm-block attribute-label mb-2">&nbsp;</p>
                        <button type="submit" class="btn btn-buy w-100 d-flex align-items-center justify-content-center">
                            Add to Bag
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="mt-5 p-4 rounded-4 bg-light">
                <div class="d-flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-truck me-2 text-dark" viewBox="0 0 16 16">
                        <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 7V5h1.02a.5.5 0 0 1 .39.188l1.48 1.85a.5.5 0 0 1 .11.312V8H12z"/>
                    </svg>
                    <span class="small fw-bold text-uppercase letter-spacing-1">Complimentary Shipping</span>
                </div>
                <p class="small text-muted mb-0">Free standard delivery on all orders over LKR 20,000 within Sri Lanka.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQty(delta) {
        const input = document.getElementById('qty');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }
</script>

<?php include 'includes/footer.php'; ?>