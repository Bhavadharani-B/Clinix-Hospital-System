<?php
 $pageTitle = 'Doctor Dashboard';
require_once __DIR__ . '/../includes/header.php';
checkRole('doctor');
 $uid = $_SESSION['user_id'];
 $total     = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctor_id=$uid")->fetch_row()[0];
 $pending   = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctor_id=$uid AND status='pending'")->fetch_row()[0];
 $accepted  = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctor_id=$uid AND status='accepted'")->fetch_row()[0];
 $completed = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctor_id=$uid AND status='completed'")->fetch_row()[0];
 $today = $conn->query("SELECT a.*, p.name AS patient_name, p.phone AS patient_phone FROM appointments a JOIN patients p ON a.patient_id=p.id WHERE a.doctor_id=$uid AND a.date=CURDATE() ORDER BY a.time");
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info'];
?>
<h3 class="mb-4">Welcome, Dr. <?= $_SESSION['user_name'] ?></h3>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-icon text-primary"><i class="fas fa-calendar"></i></div><div class="stat-number"><?= $total ?></div><small class="text-muted">Total</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#ffc107"><div class="stat-icon text-warning"><i class="fas fa-hourglass-half"></i></div><div class="stat-number"><?= $pending ?></div><small class="text-muted">Pending</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#198754"><div class="stat-icon text-success"><i class="fas fa-check"></i></div><div class="stat-number"><?= $accepted ?></div><small class="text-muted">Accepted</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#6f42c1"><div class="stat-icon" style="color:#6f42c1"><i class="fas fa-flag-checkered"></i></div><div class="stat-number"><?= $completed ?></div><small class="text-muted">Completed</small></div></div>
</div>
<div class="card p-4">
    <h5 class="mb-3">Today's Appointments (<?= date('Y-m-d') ?>)</h5>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Patient</th><th>Phone</th><th>Time</th><th>Reason</th><th>Status</th></tr></thead>
            <tbody>
            <?php if ($today->num_rows === 0): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">No appointments today</td></tr>
            <?php else: while ($a = $today->fetch_assoc()): ?>
                <tr><td><?= $a['patient_name'] ?></td><td><?= $a['patient_phone'] ?></td><td><?= $a['time'] ?></td><td class="text-truncate" style="max-width:200px"><?= $a['reason'] ?: '—' ?></td><td><span class="badge bg-<?= $statusColors[$a['status']] ?? 'secondary' ?> badge-status"><?= ucfirst($a['status']) ?></span></td></tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>