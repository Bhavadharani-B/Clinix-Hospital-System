<?php
 $pageTitle = 'All Appointments';
require_once __DIR__ . '/../includes/header.php';
checkRole('admin');
 $search = sanitize($_GET['search'] ?? '');
 $filter = $_GET['filter'] ?? '';
 $statusColors = ['pending'=>'warning','accepted'=>'success','rejected'=>'danger','completed'=>'info','cancelled'=>'secondary'];
 $sql = "SELECT a.*, p.name AS patient_name, d.name AS doctor_name FROM appointments a JOIN patients p ON a.patient_id=p.id JOIN doctors d ON a.doctor_id=d.id WHERE 1=1";
if ($search) $sql .= " AND (p.name LIKE '%$search%' OR d.name LIKE '%$search%')";
if ($filter && in_array($filter, ['pending','accepted','rejected','completed','cancelled'])) $sql .= " AND a.status='$filter'";
 $sql .= " ORDER BY a.date DESC, a.time DESC";
 $rows = $conn->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="mb-0">All Appointments</h3>
    <span class="badge bg-primary fs-6 px-3 py-2"><?= $rows->num_rows ?> Records</span>
</div>
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search patient or doctor..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"></div>
    <div class="col-md-3">
        <select name="filter" class="form-select">
            <option value="">All Status</option>
            <?php foreach (['pending','accepted','rejected','completed','cancelled'] as $s): ?>
            <option value="<?= $s ?>" <?= $filter === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Reason</th><th>Status</th></tr></thead>
            <tbody>
            <?php if ($rows->num_rows === 0): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No appointments found.</td></tr>
            <?php else: while ($a = $rows->fetch_assoc()): ?>
                <tr>
                    <td><?= $a['patient_name'] ?></td><td><?= $a['doctor_name'] ?></td><td><?= $a['date'] ?></td><td><?= $a['time'] ?></td>
                    <td class="text-truncate" style="max-width:200px"><?= $a['reason'] ?: '—' ?></td>
                    <td><span class="badge bg-<?= $statusColors[$a['status']] ?? 'secondary' ?> badge-status"><?= ucfirst($a['status']) ?></span></td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>