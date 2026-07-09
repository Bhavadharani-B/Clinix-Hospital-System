<?php
 $pageTitle = 'Manage Appointments';
require_once __DIR__ . '/../includes/header.php';
checkRole('doctor');
 $uid = $_SESSION['user_id'];
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info'];
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    if (in_array($action, ['accepted','rejected','completed'])) {
        $conn->query("UPDATE appointments SET status='$action' WHERE id=$id AND doctor_id=$uid");
        flash("Appointment " . ucfirst($action) . ".");
        redirect('doctor/appointments.php');
    }
}
 $filter = $_GET['filter'] ?? '';
 $sql = "SELECT a.*, p.name AS patient_name, p.phone AS patient_phone FROM appointments a JOIN patients p ON a.patient_id=p.id WHERE a.doctor_id=$uid";
if ($filter && in_array($filter, ['pending','accepted','rejected','completed'])) $sql .= " AND a.status='$filter'";
 $sql .= " ORDER BY a.date DESC, a.time DESC";
 $rows = $conn->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="mb-0">Appointments</h3>
    <div class="d-flex gap-2 flex-wrap">
        <?php foreach ([''=>'All','pending'=>'Pending','accepted'=>'Accepted','completed'=>'Completed'] as $k => $v): ?>
        <a href="?filter=<?= $k ?>" class="btn btn-sm <?= (!$filter && !$k) || $filter === $k ? 'btn-primary' : 'btn-outline-primary' ?>"><?= $v ?></a>
        <?php endforeach; ?>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Patient</th><th>Phone</th><th>Date</th><th>Time</th><th>Reason</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php if ($rows->num_rows === 0): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No appointments found.</td></tr>
            <?php else: while ($a = $rows->fetch_assoc()): ?>
                <tr>
                    <td><?= $a['patient_name'] ?></td><td><?= $a['patient_phone'] ?></td><td><?= $a['date'] ?></td><td><?= $a['time'] ?></td>
                    <td class="text-truncate" style="max-width:140px"><?= $a['reason'] ?: '—' ?></td>
                    <td><span class="badge bg-<?= $statusColors[$a['status']] ?> badge-status"><?= ucfirst($a['status']) ?></span></td>
                    <td>
                        <?php if ($a['status'] === 'pending'): ?>
                            <a href="?action=accepted&id=<?= $a['id'] ?>" class="btn btn-sm btn-success me-1" data-confirm="Accept?">Accept</a>
                            <a href="?action=rejected&id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" data-confirm="Reject?">Reject</a>
                        <?php elseif ($a['status'] === 'accepted'): ?>
                            <a href="?action=completed&id=<?= $a['id'] ?>" class="btn btn-sm btn-info text-white" data-confirm="Mark completed?">Complete</a>
                        <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>