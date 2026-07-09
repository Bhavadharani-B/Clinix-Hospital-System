<?php $pageTitle = 'Home — Hospital Management System'; ?>
<?php require_once 'includes/header.php'; ?>
<div class="hero-section text-center">
    <div class="container">
        <h1>Welcome to Clinix</h1>
        <p class="lead mb-4">Quality healthcare at your fingertips. Book appointments, manage records, and more.</p>
        <a href="register.php" class="btn btn-light btn-lg px-4 me-2">Get Started</a>
        <a href="login.php" class="btn btn-outline-light btn-lg px-4">Login</a>
    </div>
</div>
<div class="container py-5">
    <div class="row g-4 text-center mb-5">
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                <h5>Expert Doctors</h5>
                <p class="text-muted mb-0">Highly qualified specialists across all major departments.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                <h5>Easy Booking</h5>
                <p class="text-muted mb-0">Book appointments online in just a few clicks.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>Secure System</h5>
                <p class="text-muted mb-0">Your data is safe with our secure management system.</p>
            </div>
        </div>
    </div>
    <div class="row align-items-center g-4">
        <div class="col-md-6">
            <h2>Why Choose Us?</h2>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>24/7 Patient Support</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Multiple Specializations</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Digital Health Records</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Real-time Appointment Tracking</li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="images (1).jpg" class="img-fluid rounded-3 shadow" alt="Hospital">
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>