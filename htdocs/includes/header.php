<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
if (!isset($conn)) {
    include_once 'db.php'; 
}

// Live cart count logic
$cart_count = 0;
if (isset($_SESSION['user']) && isset($conn)) {
    $uid = $_SESSION['user']['id'];
    $count_res = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $uid");
    if ($count_res) {
        $count_row = mysqli_fetch_assoc($count_res);
        $cart_count = $count_row['total'] ?? 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velvet Vogue | Modern Elegance</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    
    <style>
        :root {
            --vv-gold: #c5a059; /* More refined gold */
            --vv-dark: #111111;
        }

        body { font-family: 'Poppins', sans-serif; padding-top: 110px; }

        .promo-bar {
            background: var(--vv-dark);
            color: white;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 8px 0;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1031;
        }

        .vv-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: fixed;
            top: 31px;
            width: 100%;
            z-index: 1030;
            height: 80px;
            display: flex;
            align-items: center;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 4px;
            color: var(--vv-dark) !important;
        }

        .nav-link {
            color: var(--vv-dark) !important;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 0 15px;
        }

        /* Icons Area Styling */
        .header-icons a {
            color: var(--vv-dark);
            text-decoration: none;
            margin-left: 22px;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-icons a:hover {
            color: var(--vv-gold) !important;
            transform: translateY(-1px);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--vv-gold);
            color: white;
            font-size: 0.6rem;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .user-greeting {
            font-size: 0.7rem;
            color: #999;
            margin-right: 5px;
            letter-spacing: 0.5px;
        }

        @media (max-width: 991px) {
            .vv-header { top: 0; height: auto; padding: 15px 0; }
            .promo-bar { display: none; }
        }
    </style>
</head>
<body>

<div class="promo-bar">
    Complimentary Shipping on all Orders above LKR 15,000
</div>

<nav class="navbar navbar-expand-lg vv-header">
    <div class="container">
        <a class="navbar-brand" href="index.php">VELVET VOGUE</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#vvNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="vvNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link px-3" href="shop.php?">New Arrivals</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="shop.php?category=1">Mens</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="shop.php?category=2">Women</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-gold" href="shop.php?category=5">Accessories</a></li>
            </ul>

            <div class="header-icons d-flex align-items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="user-greeting d-none d-xl-inline">Hello, <?php echo explode(' ', $_SESSION['user']['name'])[0]; ?></span>
                    
                    <!-- 1. Account Icon -->
                    <a href="account.php" title="My Account"><i class="far fa-user"></i></a>
                    
                    <!-- 2. Admin Icon (if applicable) -->
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="admin/dashboard.php" title="Admin Panel"><i class="fas fa-cog"></i></a>
                    <?php endif; ?>

                    <!-- 3. Cart Icon -->
                    <a href="cart.php" class="position-relative">
                        <i class="fas fa-shopping-bag"></i>
                        <?php if($cart_count > 0): ?>
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- 4. Logout Icon (Now after cart, black by default, gold on hover) -->
                    <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>

                <?php else: ?>
                    <a href="signin.php" title="Login"><i class="far fa-user"></i></a>
                    <a href="cart.php" class="position-relative">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
