<?php
 $pageTitle = 'All Patients';
require_once __DIR__ . '/../includes/header.php';
checkRole('admin');
 $search = sanitize($_GET['search'] ?? '');
 $sql = "SELECT * FROM patients";
if ($search) $sql .= " WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
 $sql .= " ORDER BY created_at DESC";
 $patients = $conn->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="mb-0">All Patients</h3>
    <span class="badge bg-primary fs-6 px-3 py-2"><?= $patients->num_rows ?> Patients</span>
</div>
<form method="GET" class="row g-3 mb-4"><div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"></div></form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>DOB</th><th>Registered</th></tr></thead>
            <tbody>
            <?php if ($patients->num_rows === 0): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No patients found.</td></tr>
            <?php else: while ($p = $patients->fetch_assoc()): ?>
                <tr><td><?= $p['name'] ?></td><td><?= $p['email'] ?></td><td><?= $p['phone'] ?></td><td><?= $p['gender'] ?></td><td><?= $p['dob'] ?></td><td><?= date('M d, Y', strtotime($p['created_at'])) ?></td></tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>