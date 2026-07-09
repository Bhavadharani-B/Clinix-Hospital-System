<?php
 $pageTitle = 'My Appointments';
require_once __DIR__ . '/../includes/header.php';
checkRole('patient');
 $uid = $_SESSION['user_id'];
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info','cancelled'=>'secondary'];
if (isset($_GET['cancel'])) {
    $id = (int)$_GET['cancel'];
    $conn->query("UPDATE appointments SET status='cancelled' WHERE id=$id AND patient_id=$uid AND status='pending'");
    flash('Appointment cancelled.', 'info');
    redirect('patient/appointments.php');
}
 $rows = $conn->query("SELECT a.*, d.name AS doc_name, d.specialization FROM appointments a JOIN doctors d ON a.doctor_id=d.id WHERE a.patient_id=$uid ORDER BY a.date DESC, a.time DESC");
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="mb-0">My Appointments</h3>
    <a href="doctors.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Book New</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Doctor</th><th>Specialization</th><th>Date</th><th>Time</th><th>Reason</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            <?php if ($rows->num_rows === 0): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No appointments found.</td></tr>
            <?php else: while ($a = $rows->fetch_assoc()): ?>
                <tr>
                    <td><?= $a['doc_name'] ?></td><td><?= $a['specialization'] ?></td><td><?= $a['date'] ?></td><td><?= $a['time'] ?></td>
                    <td class="text-truncate" style="max-width:140px"><?= $a['reason'] ?: '—' ?></td>
                    <td><span class="badge bg-<?= $statusColors[$a['status']] ?> badge-status"><?= ucfirst($a['status']) ?></span></td>
                    <td>
                        <?php if ($a['status'] === 'pending'): ?>
                            <a href="?cancel=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger" data-confirm="Cancel this appointment?">Cancel</a>
                        <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>