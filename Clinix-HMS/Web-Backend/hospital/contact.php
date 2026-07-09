<?php $pageTitle = 'Contact Us'; require_once 'includes/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="mb-4">Contact Us</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h5>Get in Touch</h5>
                    <p class="text-muted mb-1"><i class="fas fa-phone me-2"></i>+91 9789275654</p>
                    <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i>info@hospital.com</p>
                    <p class="text-muted mb-1"><i class="fas fa-map-marker-alt me-2"></i>25 North Street,Ariyalur</p>
                    <p class="text-muted mb-0"><i class="fas fa-clock me-2"></i>24/7</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <h5>Send Message</h5>
                    <form>
                        <div class="mb-3"><input type="text" class="form-control" required placeholder="Your Name"></div>
                        <div class="mb-3"><input type="email" class="form-control" required placeholder="Your Email"></div>
                        <div class="mb-3"><textarea class="form-control" rows="4" required placeholder="Your Message"></textarea></div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>