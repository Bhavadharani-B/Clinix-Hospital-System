<?php
 $pageTitle = 'Login';
require_once 'includes/header.php';
if (isLoggedIn()) redirect(getDashboardUrl());
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['email']);
    $pass  = $_POST['password'];
    $role  = $_POST['role'];
    if ($role === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    } else {
        $table = $role === 'doctor' ? 'doctors' : 'patients';
        $stmt = $conn->prepare("SELECT * FROM $table WHERE email=?");
    }
    $stmt->bind_param('s', $input);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']      = $role;
        flash('Login successful!');
        redirect(getDashboardUrl());
    } else {
        flash('Invalid credentials.', 'danger');
    }
}
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-sm-10">
        <div class="card p-4 shadow-sm">
            <h3 class="text-center mb-4"><i class="fas fa-sign-in-alt text-primary me-2"></i>Login</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Login As</label>
                    <select name="role" class="form-select" required>
                        <option value="patient">Patient</option>
                        <option value="doctor">Doctor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="text" name="email" class="form-control" required placeholder="Enter email or username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                <div class="text-center mt-3 small">
                    <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                    <span class="mx-1 text-muted">|</span>
                    <a href="register.php" class="text-decoration-none">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>