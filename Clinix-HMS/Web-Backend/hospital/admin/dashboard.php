<?php
 $pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../includes/header.php';
checkRole('admin');
 $doctors     = $conn->query("SELECT COUNT(*) FROM doctors")->fetch_row()[0];
 $patients    = $conn->query("SELECT COUNT(*) FROM patients")->fetch_row()[0];
 $appointments = $conn->query("SELECT COUNT(*) FROM appointments")->fetch_row()[0];
 $pending     = $conn->query("SELECT COUNT(*) FROM appointments WHERE status='pending'")->fetch_row()[0];
 $recent = $conn->query("SELECT a.*, p.name AS patient_name, d.name AS doctor_name FROM appointments a JOIN patients p ON a.patient_id=p.id JOIN doctors d ON a.doctor_id=d.id ORDER BY a.created_at DESC LIMIT 5");
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info','cancelled'=>'secondary'];
?>
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-icon text-primary"><i class="fas fa-user-md"></i></div><div class="stat-number"><?= $doctors ?></div><small class="text-muted">Doctors</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#198754"><div class="stat-icon text-success"><i class="fas fa-users"></i></div><div class="stat-number"><?= $patients ?></div><small class="text-muted">Patients</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#ffc107"><div class="stat-icon text-warning"><i class="fas fa-calendar-alt"></i></div><div class="stat-number"><?= $appointments ?></div><small class="text-muted">Appointments</small></div></div>
    <div class="col-6 col-md-3"><div class="stat-card" style="border-left-color:#dc3545"><div class="stat-icon text-danger"><i class="fas fa-clock"></i></div><div class="stat-number"><?= $pending ?></div><small class="text-muted">Pending</small></div></div>
</div>
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Appointments</h5>
        <a href="appointments.php" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
            <tbody>
            <?php if ($recent->num_rows === 0): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">No appointments yet</td></tr>
            <?php else: while ($a = $recent->fetch_assoc()): ?>
                <tr><td><?= $a['patient_name'] ?></td><td><?= $a['doctor_name'] ?></td><td><?= $a['date'] ?></td><td><?= $a['time'] ?></td><td><span class="badge bg-<?= $statusColors[$a['status']] ?? 'secondary' ?> badge-status"><?= ucfirst($a['status']) ?></span></td></tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>