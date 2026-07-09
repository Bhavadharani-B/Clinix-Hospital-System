<?php
 $pageTitle = 'Register';
require_once 'includes/header.php';
if (isLoggedIn()) redirect(getDashboardUrl());
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender   = $_POST['gender'];
    $dob      = $_POST['dob'];
    $address  = trim($_POST['address'] ?? '');
    $chk = $conn->prepare("SELECT id FROM patients WHERE email=?");
    $chk->bind_param('s', $email);
    $chk->execute();
    if ($chk->get_result()->num_rows > 0) {
        flash('Email already registered.', 'danger');
    } else {
        $stmt = $conn->prepare("INSERT INTO patients (name,email,phone,password,gender,dob,address) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', $name, $email, $phone, $password, $gender, $dob, $address);
        $stmt->execute();
        flash('Registration successful! Please login.');
        redirect('login.php');
    }
}
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-sm-10">
        <div class="card p-4 shadow-sm">
            <h3 class="text-center mb-4"><i class="fas fa-user-plus text-primary me-2"></i>Patient Registration</h3>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password * <small class="text-muted">(min 6)</small></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender *</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth *</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                    </div>
                </div>
                <p class="text-center mt-3 mb-0 small">Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>