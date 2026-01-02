<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/db.php';
?>

<!-- Full-Screen Hero Section -->
<section class="hero-v2 position-relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="container h-100 position-relative" style="z-index: 2;">
        <div class="row h-100 align-items-center">
            <div class="col-lg-7 text-white">
                <h6 class="text-gold fw-bold text-uppercase mb-3 tracking-widest animate-up">Season 2026 Collection</h6>
                <h1 class="display-1 fw-bold mb-4 animate-up-delay-1 main-title" style="font-family: 'Playfair Display', serif;">The Art of <br>Modern Elegance</h1>
                <p class="lead mb-5 fw-medium animate-up-delay-2 hero-subtext" style="max-width: 550px;">Explore our curated selection of premium fabrics and timeless silhouettes designed for the discerning individual.</p>
                <div class="d-flex animate-up-delay-3">
                    <a href="#arrivals" class="btn-vv-primary me-3">Shop Now</a>
                    <a href="shop.php" class="btn-vv-outline">View Collection</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-image-wrapper">
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070" alt="Hero Banner">
    </div>
</section>

<!-- Category Feature Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="category-card position-relative overflow-hidden shadow-sm">
                    <img src="https://images.unsplash.com/photo-1488161628813-04466f872be2?q=80&w=1000" class="img-fluid" alt="Men's Collection">
                    <div class="category-overlay">
                        <div class="text-center">
                            <h2 class="text-white fw-bold display-6 mb-2">Men's Edition</h2>
                            <a href="shop.php" class="text-gold text-decoration-none small tracking-widest fw-bold border-bottom border-gold pb-1">DISCOVER MORE</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="category-card position-relative overflow-hidden shadow-sm">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1000" class="img-fluid" alt="Women's Collection">
                    <div class="category-overlay">
                        <div class="text-center">
                            <h2 class="text-white fw-bold display-6 mb-2">Women's Wear</h2>
                            <a href="shop.php" class="text-gold text-decoration-none small tracking-widest fw-bold border-bottom border-gold pb-1">DISCOVER MORE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Spotlight Section -->
<section class="seasonal-spotlight bg-black overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row g-0 align-items-stretch">
            <div class="col-lg-7 position-relative">
                <div class="seasonal-img-container h-100">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=2070" alt="Spring Collection" class="h-100">
                </div>
            </div>
            <div class="col-lg-5 d-flex align-items-center bg-black text-white p-4 p-md-5">
                <div class="p-lg-5">
                    <span class="text-gold fw-bold tracking-widest text-uppercase d-block mb-3">Limited Edition</span>
                    <h2 class="display-4 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Spring/Summer <br>Revival 2026</h2>
                    <p class="text-light opacity-75 mb-4 fs-5">Embrace the warmth with our lightest linens and breathable silks. This collection is a tribute to the effortless grace of the island breeze.</p>
                    <a href="shop.php" class="btn btn-gold-outline px-5 py-3 rounded-0 fw-bold tracking-widest">EXPLORE SPRING</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section id="arrivals" class="py-5 bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold display-5 mb-0" style="font-family: 'Playfair Display', serif;">New Arrivals</h2>
                <div class="bg-gold" style="width: 80px; height: 3px; margin-top: 15px;"></div>
            </div>
            <a href="shop.php" class="text-dark fw-bold small text-decoration-none border-bottom border-dark pb-1 tracking-widest">VIEW ALL</a>
        </div>

        <div class="row g-4">
            <?php
            $query = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_assoc($result)): 
            ?>
                <div class="col-6 col-md-3">
                    <div class="vv-product-card bg-white p-2 shadow-sm">
                        <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none">
                            <div class="vv-img-container">
                                <?php $img = !empty($row['image']) ? "assets/images/".$row['image'] : "https://via.placeholder.com/400x600?text=Premium+Item"; ?>
                                <img src="<?php echo $img; ?>" alt="<?php echo $row['name']; ?>" class="img-fluid">
                                <div class="vv-quick-add">
                                    <span>VIEW DETAILS</span>
                                </div>
                            </div>
                            <div class="pt-3 px-2 pb-2">
                                <p class="text-gold fw-bold extra-small mb-1 text-uppercase tracking-widest">New Drop</p>
                                <h6 class="text-dark fw-bold mb-1" style="font-size: 1.1rem;"><?php echo $row['name']; ?></h6>
                                <p class="text-muted fw-bold m-0">LKR <?php echo number_format($row['price'], 2); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<!-- RESTORED: Website Info / Brand Values Section (High Contrast) -->
<section class="py-5 bg-white border-top">
    <div class="container py-5 text-center">
        <div class="row g-5">
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-shipping-fast fa-3x text-gold"></i>
                </div>
                <h5 class="fw-bold text-uppercase tracking-widest mb-3" style="font-size: 0.9rem;">Islandwide Shipping</h5>
                <p class="small text-muted px-lg-5">Complimentary delivery for all premium orders over LKR 15,000 across the island.</p>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-gem fa-3x text-gold"></i>
                </div>
                <h5 class="fw-bold text-uppercase tracking-widest mb-3" style="font-size: 0.9rem;">Premium Quality</h5>
                <p class="small text-muted px-lg-5">Crafted with the finest materials. Every garment is a masterpiece of sartorial precision.</p>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-undo fa-3x text-gold"></i>
                </div>
                <h5 class="fw-bold text-uppercase tracking-widest mb-3" style="font-size: 0.9rem;">Easy Returns</h5>
                <p class="small text-muted px-lg-5">Not a perfect fit? Enjoy a hassle-free 7-day return policy on all unworn items.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Global Helpers */
    .text-gold { color: #d4af37 !important; }
    .bg-gold { background-color: #d4af37; }
    .border-gold { border-color: #d4af37 !important; }
    .tracking-widest { letter-spacing: 3px; }
    .extra-small { font-size: 0.7rem; }

    /* Hero */
    .hero-v2 { height: 90vh; min-height: 650px; }
    .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.3)); z-index: 1; }
    .main-title { text-shadow: 0 4px 15px rgba(0,0,0,0.3); }
    .hero-image-wrapper { position: absolute; top: 0; right: 0; width: 100%; height: 100%; z-index: 0; }
    .hero-image-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    /* Category Cards */
    .category-card { height: 480px; }
    .category-card img { width: 100%; height: 100%; object-fit: cover; transition: 1.2s cubic-bezier(0.17, 0.67, 0.83, 0.67); }
    .category-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center; transition: 0.5s; }
    .category-card:hover img { transform: scale(1.1); }
    .category-card:hover .category-overlay { background: rgba(0,0,0,0.45); }

    /* Seasonal Spotlight */
    .seasonal-img-container img { width: 100%; height: 100%; object-fit: cover; min-height: 500px; }
    .btn-gold-outline { border: 2px solid #d4af37; color: #d4af37; background: transparent; transition: 0.3s; font-size: 0.8rem; }
    .btn-gold-outline:hover { background: #d4af37; color: #000; }

    /* Product Cards */
    .vv-img-container { position: relative; overflow: hidden; }
    .vv-img-container img { transition: 0.6s; width: 100%; aspect-ratio: 3/4; object-fit: cover; }
    .vv-quick-add { position: absolute; bottom: -50px; width: 100%; background: #111; color: #fff; padding: 12px; text-align: center; transition: 0.4s; font-size: 0.75rem; font-weight: 700; }
    .vv-product-card:hover .vv-quick-add { bottom: 0; }
    .vv-product-card:hover img { filter: brightness(0.85); }
    
    /* Buttons */
    .btn-vv-primary { background: #d4af37; color: #000; padding: 16px 45px; text-decoration: none; font-weight: 800; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; display: inline-block; transition: 0.3s; }
    .btn-vv-primary:hover { background: #fff; transform: translateY(-3px); }
    .btn-vv-outline { border: 2px solid white; color: white; padding: 16px 45px; text-decoration: none; font-weight: 800; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; display: inline-block; transition: 0.3s; }
    .btn-vv-outline:hover { background: white; color: #000; }

    /* Animations */
    .animate-up { animation: fadeInUp 1s ease backwards; }
    .animate-up-delay-1 { animation: fadeInUp 1s ease 0.2s backwards; }
    .animate-up-delay-2 { animation: fadeInUp 1s ease 0.4s backwards; }
    .animate-up-delay-3 { animation: fadeInUp 1s ease 0.6s backwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include 'includes/footer.php'; ?>