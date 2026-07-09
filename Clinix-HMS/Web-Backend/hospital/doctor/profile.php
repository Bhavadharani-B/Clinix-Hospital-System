<?php
 $pageTitle = 'My Profile';
require_once __DIR__ . '/../includes/header.php';
checkRole('doctor');
 $uid  = $_SESSION['user_id'];
 $user = $conn->query("SELECT * FROM doctors WHERE id=$uid")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $spec  = trim($_POST['specialization']);
    $stmt = $conn->prepare("UPDATE doctors SET name=?,phone=?,specialization=? WHERE id=?");
    $stmt->bind_param('sssi', $name, $phone, $spec, $uid);
    $stmt->execute();
    $_SESSION['user_name'] = $name;
    flash('Profile updated!');
    redirect('doctor/profile.php');
}
?>
<h3 class="mb-4">My Profile</h3>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 shadow-sm">
            <form method="POST">
                <div class="mb-3"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>"></div>
                <div class="mb-3"><label class="form-label">Email <small class="text-muted">(cannot change)</small></label><input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled></div>
                <div class="mb-3"><label class="form-label">Phone *</label><input type="tel" name="phone" class="form-control" required value="<?= htmlspecialchars($user['phone']) ?>"></div>
                <div class="mb-3"><label class="form-label">Specialization *</label><input type="text" name="specialization" class="form-control" required value="<?= htmlspecialchars($user['specialization']) ?>"></div>
                <button type="submit" class="btn btn-primary w-100 py-2">Update Profile</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>