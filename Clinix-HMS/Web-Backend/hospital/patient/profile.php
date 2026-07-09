<?php
 $pageTitle = 'My Profile';
require_once __DIR__ . '/../includes/header.php';
checkRole('patient');
 $uid  = $_SESSION['user_id'];
 $user = $conn->query("SELECT * FROM patients WHERE id=$uid")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $gender  = $_POST['gender'];
    $dob     = $_POST['dob'];
    $address = trim($_POST['address']);
    $stmt = $conn->prepare("UPDATE patients SET name=?,phone=?,gender=?,dob=?,address=? WHERE id=?");
    $stmt->bind_param('sssssi', $name, $phone, $gender, $dob, $address, $uid);
    $stmt->execute();
    $_SESSION['user_name'] = $name;
    flash('Profile updated!');
    redirect('patient/profile.php');
}
?>
<h3 class="mb-4">My Profile</h3>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4 shadow-sm">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Email <small class="text-muted">(cannot change)</small></label><input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled></div>
                    <div class="col-md-6"><label class="form-label">Phone *</label><input type="tel" name="phone" class="form-control" required value="<?= htmlspecialchars($user['phone']) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Gender *</label><select name="gender" class="form-select" required><option value="Male" <?= $user['gender']==='Male'?'selected':'' ?>>Male</option><option value="Female" <?= $user['gender']==='Female'?'selected':'' ?>>Female</option><option value="Other" <?= $user['gender']==='Other'?'selected':'' ?>>Other</option></select></div>
                    <div class="col-md-6"><label class="form-label">Date of Birth *</label><input type="date" name="dob" class="form-control" required value="<?= $user['dob'] ?>"></div>
                    <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address'] ?? '') ?></textarea></div>
                    <div class="col-12"><button type="submit" class="btn btn-primary w-100 py-2">Update Profile</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>