<?php 
include 'includes/header.php'; 
?>

<style>
    :root { --v-gold: #c5a059; }
    
    .support-hero {
        background: #111;
        padding: 80px 0;
        color: #fff;
        text-align: center;
    }
    
    .support-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 10px; }
    .support-hero p { color: #888; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; }

    .support-grid { margin-top: -40px; }

    .info-card {
        background: #fff;
        padding: 40px;
        height: 100%;
        border-radius: 0;
        border-right: 1px solid #eee;
    }

    .info-item { margin-bottom: 30px; }
    .info-item h6 { font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--v-gold); }
    .info-item p { font-size: 0.95rem; color: #555; }

    .inquiry-form-card {
        background: #fff;
        padding: 40px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    }

    .v-label { font-size: 0.65rem; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; margin-bottom: 8px; display: block; }
    .v-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #eee;
        padding: 12px 0;
        margin-bottom: 25px;
        transition: 0.3s;
        border-radius: 0;
    }
    .v-input:focus { outline: none; border-bottom-color: #111; }
    
    .btn-vogue {
        background: #111;
        color: #fff;
        padding: 15px 40px;
        border: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        transition: 0.3s;
    }
    .btn-vogue:hover { background: var(--v-gold); transform: translateY(-3px); }

    .faq-section { padding: 80px 0; background: #fafafa; }
    .faq-title { font-family: 'Playfair Display', serif; margin-bottom: 40px; }
    .accordion-item { border: none; background: transparent; margin-bottom: 10px; }
    .accordion-button { font-weight: 600; font-size: 0.9rem; padding: 20px 0; border: none !important; background: transparent !important; box-shadow: none !important; color: #111; }
    .accordion-button::after { filter: grayscale(1); }
</style>

<section class="support-hero">
    <div class="container">
        <h1>Client Concierge</h1>
        <p>Inquiries & Support</p>
    </div>
</section>

<section class="container mb-5 support-grid">
    <div class="row g-0 shadow-lg">
        <!-- Contact Info -->
        <div class="col-lg-4">
            <div class="info-card">
                <div class="info-item">
                    <h6>Boutique Location</h6>
                    <p>No. 42, Ward Place,<br>Colombo 07, Sri Lanka</p>
                </div>
                <div class="info-item">
                    <h6>General Inquiries</h6>
                    <p>support@velvetvogue.lk<br>+94 11 234 5678</p>
                </div>
                <div class="info-item">
                    <h6>Operating Hours</h6>
                    <p>Mon — Sat: 10:00 - 19:00<br>Sun: 11:00 - 17:00</p>
                </div>
                <div class="mt-5">
                    <a href="#" class="me-3 text-dark"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="me-3 text-dark"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-lg-8">
            <div class="inquiry-form-card">
                <h4 class="mb-4 fw-bold">Send an Inquiry</h4>
                <form action="actions/process_inquiry.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="v-label">Full Name</label>
                            <input type="text" name="name" class="v-input" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="v-label">Email Address</label>
                            <input type="email" name="email" class="v-input" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <label class="v-label">Subject</label>
                    <select name="subject" class="v-input">
                        <option>Order Tracking</option>
                        <option>Product Information</option>
                        <option>Returns & Exchanges</option>
                        <option>Other</option>
                    </select>
                    
                    <label class="v-label">Message</label>
                    <textarea name="message" class="v-input" rows="4" placeholder="How can we assist you today?" required></textarea>
                    
                    <button type="submit" class="btn-vogue">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Simple FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="faq-title text-center">Frequently Asked</h2>
                <div class="accordion" id="supportFaq">
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                How long does shipping take?
                            </button>
                        </h2>
                        <div id="q1" class="accordion-collapse collapse" data-bs-parent="#supportFaq">
                            <div class="accordion-body text-muted small">
                                For local orders within Colombo, delivery takes 1-2 business days. Outstation orders typically arrive within 3-5 business days.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="q2" class="accordion-collapse collapse" data-bs-parent="#supportFaq">
                            <div class="accordion-body text-muted small">
                                Items can be exchanged within 7 days of purchase, provided they are in original condition with tags attached.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>