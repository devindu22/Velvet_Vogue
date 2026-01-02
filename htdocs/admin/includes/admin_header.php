<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Admin security check - ensures no one can view this even if they know the URL
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velvet Vogue | Admin Management</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --admin-gold: #d4af37; --admin-dark: #111; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333; }
        
        /* Admin Navbar Styling */
        .admin-nav { background: var(--admin-dark); border-bottom: 3px solid var(--admin-gold); padding: 15px 0; }
        .admin-brand { font-family: 'Playfair Display', serif; color: white !important; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; }
        .admin-brand span { color: var(--admin-gold); }
        
        .nav-link-admin { color: #aaa !important; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; transition: 0.3s; padding: 10px 15px !important; }
        .nav-link-admin:hover, .nav-link-admin.active { color: white !important; }
        
        .admin-user-tag { background: #222; border: 1px solid #333; padding: 5px 15px; border-radius: 50px; color: var(--admin-gold); font-size: 0.7rem; font-weight: 700; }
        
        /* Utility */
        .text-gold { color: var(--admin-gold) !important; }
        .tracking-widest { letter-spacing: 2px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg admin-nav sticky-top">
    <div class="container">
        <a class="navbar-brand admin-brand" href="dashboard.php">VELVET<span>VOGUE</span> <small class="ms-2 fw-normal opacity-50" style="font-size: 0.6rem; letter-spacing: 4px;">ADMIN</small></a>
        
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="adminMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-admin" href="dashboard.php">Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-admin" href="../shop.php" target="_blank">View Site</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center gap-3">
                <span class="admin-user-tag">
                    <i class="fas fa-user-shield me-2"></i> <?php echo strtoupper($_SESSION['user']['name']); ?>
                </span>
                <a href="../logout.php" class="btn btn-outline-light btn-sm rounded-0 border-0 fw-bold" title="Logout" style="font-size: 0.7rem; letter-spacing: 1px;">
                    <i class="fas fa-sign-out-alt me-1"></i> LOGOUT
                </a>
            </div>
        </div>
    </div>
</nav>