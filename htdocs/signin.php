<?php 
include 'includes/header.php'; 
?>

<style>
    :root { --v-gold: #c5a059; }
    body { background-color: #fff; overflow-x: hidden; }

    .auth-wrapper {
        min-height: 90vh;
        display: flex;
        flex-wrap: wrap;
    }

    .auth-visual {
        flex: 1;
        background: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070') center/cover no-repeat;
        min-height: 400px;
    }

    .auth-form-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        background: #fff;
    }

    .auth-content { width: 100%; max-width: 360px; }

    .auth-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        margin-bottom: 5px;
        letter-spacing: -1px;
    }

    .auth-tagline {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #999;
        display: block;
        margin-bottom: 40px;
        font-weight: 700;
    }

    .input-block { margin-bottom: 30px; }
    
    .input-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
        margin-bottom: 8px;
        display: block;
    }

    .input-field {
        width: 100%;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
        font-size: 1rem;
        transition: border-color 0.3s;
        border-radius: 0;
    }

    .input-field:focus {
        outline: none;
        border-color: #111;
    }

    .btn-submit {
        background: #111;
        color: #fff;
        width: 100%;
        padding: 18px;
        border: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-submit:hover { background: var(--v-gold); }

    .auth-error {
        font-size: 0.7rem;
        color: #d9534f;
        border: 1px solid #d9534f;
        padding: 10px;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @media (max-width: 991px) {
        .auth-visual { display: none; }
        .auth-form-container { padding: 30px; }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-visual"></div>
    <div class="auth-form-container">
        <div class="auth-content">
            <div class="auth-header">
                <h1>Sign In</h1>
                <span class="auth-tagline">Velvet Vogue Boutique</span>
            </div>

            <?php if(isset($_GET['error'])): ?>
                <div class="auth-error">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php 
                        $err = $_GET['error'];
                        if($err == 'invalid') echo "Identity verification failed.";
                        else if($err == 'please_login') echo "Please sign in to continue.";
                        else echo "Access denied.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="actions/process_login.php" method="POST">
                <div class="input-block">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" class="input-field" placeholder="name@vogue.com" required>
                </div>

                <div class="input-block">
                    <div class="d-flex justify-content-between">
                        <label class="input-label">Password</label>
                        <a href="#" class="text-muted text-decoration-none" style="font-size: 0.6rem; font-weight: 700;">FORGOT?</a>
                    </div>
                    <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">Enter Boutique</button>
            </form>

            <div class="mt-5 pt-3 border-top text-center">
                <p class="small text-muted">New to the house? <a href="register.php" class="text-dark fw-bold text-decoration-none border-bottom border-dark">Create Account</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>