<?php
 $pageTitle = 'Patient Dashboard';
require_once __DIR__ . '/../includes/header.php';
checkRole('patient');
 $uid = $_SESSION['user_id'];
 $total     = $conn->query("SELECT COUNT(*) FROM appointments WHERE patient_id=$uid")->fetch_row()[0];
 $pending   = $conn->query("SELECT COUNT(*) FROM appointments WHERE patient_id=$uid AND status='pending'")->fetch_row()[0];
 $upcoming  = $conn->query("SELECT COUNT(*) FROM appointments WHERE patient_id=$uid AND status='accepted' AND date>=CURDATE()")->fetch_row()[0];
 $completed = $conn->query("SELECT COUNT(*) FROM appointments WHERE patient_id=$uid AND status='completed'")->fetch_row()[0];
 $recent = $conn->query("SELECT a.*, d.name AS doc_name, d.specialization FROM appointments a JOIN doctors d ON a.doctor_id=d.id WHERE a.patient_id=$uid ORDER BY a.created_at DESC LIMIT 5");
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info','cancelled'=>'secondary'];
?>
<h3 class="mb-4">Welcome, <?= $_SESSION['user_name'] ?></h3>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-icon text-primary"><i class="fas fa-calendar"></i></div><div class="stat-number"><?= $total ?></div><small class="text-muted">Total</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#ffc107"><div class="stat-icon text-warning"><i class="fas fa-clock"></i></div><div class="stat-number"><?= $pending ?></div><small class="text-muted">Pending</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#198754"><div class="stat-icon text-success"><i class="fas fa-check-circle"></i></div><div class="stat-number"><?= $upcoming ?></div><small class="text-muted">Upcoming</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#6f42c1"><div class="stat-icon" style="color:#6f42c1"><i class="fas fa-flag-checkered"></i></div><div class="stat-number"><?= $completed ?></div><small class="text-muted">Completed</small></div></div>
</div>
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Appointments</h5>
        <a href="appointments.php" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Doctor</th><th>Specialization</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
            <?php if ($recent->num_rows === 0): ?>
                <tr><td colspan="4" class="text-center text-muted py-3">No appointments yet</td></tr>
            <?php else: while ($a = $recent->fetch_assoc()): ?>
                <tr><td><?= $a['doc_name'] ?></td><td><?= $a['specialization'] ?></td><td><?= $a['date'] ?></td><td><span class="badge bg-<?= $statusColors[$a['status']] ?? 'secondary' ?> badge-status"><?= ucfirst($a['status']) ?></span></td></tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>