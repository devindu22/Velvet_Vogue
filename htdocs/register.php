<?php include 'includes/header.php'; ?>

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
        background: url('https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?q=80&w=2070') center/cover no-repeat;
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

    .auth-content { width: 100%; max-width: 400px; }

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

    .input-field, textarea {
        width: 100%;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
        font-size: 1rem;
        transition: border-color 0.3s;
        border-radius: 0;
        resize: none;
    }

    .input-field:focus, textarea:focus {
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
        cursor: pointer;
    }

    .btn-submit:hover { background: var(--v-gold); }

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
                <h1>Create Account</h1>
                <span class="auth-tagline">Velvet Vogue Boutique</span>
            </div>

            <form action="actions/process_register.php" method="POST">
                <div class="input-block">
                    <label class="input-label">Name</label>
                    <input type="text" name="name" class="input-field" placeholder="Your full name" required>
                </div>

                <div class="input-block">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" class="input-field" placeholder="name@vogue.com" required>
                </div>

                <div class="input-block">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                </div>

                <div class="input-block">
                    <label class="input-label">Phone</label>
                    <input type="text" name="phone" class="input-field" placeholder="+94 77 123 4567" required>
                </div>

                <div class="input-block">
                    <label class="input-label">Address</label>
                    <textarea name="address" class="input-field" placeholder="Street, City, Country" required></textarea>
                </div>

                <button type="submit" class="btn-submit">Create Account</button>
            </form>

            <div class="mt-5 pt-3 border-top text-center">
                <p class="small text-muted">Already part of the house? 
                    <a href="signin.php" class="text-dark fw-bold text-decoration-none border-bottom border-dark">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>