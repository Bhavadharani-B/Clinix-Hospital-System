<?php
 $pageTitle = 'Our Doctors';
require_once __DIR__ . '/../includes/header.php';
checkRole('patient');
 $search = sanitize($_GET['search'] ?? '');
 $spec   = sanitize($_GET['specialization'] ?? '');
 $sql = "SELECT * FROM doctors WHERE status='active'";
if ($search) $sql .= " AND (name LIKE '%$search%' OR specialization LIKE '%$search%')";
if ($spec)   $sql .= " AND specialization='$spec'";
 $sql .= " ORDER BY name";
 $doctors = $conn->query($sql);
 $specs   = $conn->query("SELECT DISTINCT specialization FROM doctors WHERE status='active'");
?>
<h3 class="mb-4">Our Doctors</h3>
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search by name or specialization..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"></div>
    <div class="col-md-4">
        <select name="specialization" class="form-select">
            <option value="">All Specializations</option>
            <?php while ($s = $specs->fetch_assoc()): ?>
            <option value="<?= $s['specialization'] ?>" <?= ($spec === $s['specialization']) ? 'selected' : '' ?>><?= $s['specialization'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Search</button></div>
</form>
<div class="row g-4">
<?php if ($doctors->num_rows === 0): ?>
    <div class="col-12 text-center text-muted py-5">No doctors found.</div>
<?php else: while ($d = $doctors->fetch_assoc()): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card p-4 h-100 text-center">
            <div class="doc-avatar mx-auto mb-3"><i class="fas fa-user-md"></i></div>
            <h5 class="mb-1"><?= $d['name'] ?></h5>
            <p class="text-primary mb-1"><?= $d['specialization'] ?></p>
            <p class="text-muted small mb-3"><i class="fas fa-phone me-1"></i><?= $d['phone'] ?></p>
            <a href="book-appointment.php?doctor_id=<?= $d['id'] ?>" class="btn btn-primary btn-sm">Book Appointment</a>
        </div>
    </div>
<?php endwhile; endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>