<?php $pageTitle = 'Forgot Password'; require_once 'includes/header.php'; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-sm-10">
        <div class="card p-4 shadow-sm">
            <h3 class="text-center mb-3"><i class="fas fa-key text-primary me-2"></i>Forgot Password</h3>
            <p class="text-muted text-center mb-3">Enter your email to receive a password reset link.</p>
            <form>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" required placeholder="Enter your registered email">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Send Reset Link</button>
                <p class="text-center mt-3 mb-0 small"><a href="login.php">Back to Login</a></p>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>