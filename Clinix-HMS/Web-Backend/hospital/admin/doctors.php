<?php
 $pageTitle = 'Manage Doctors';
require_once __DIR__ . '/../includes/header.php';
checkRole('admin');
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM doctors WHERE id=" . (int)$_GET['delete']);
    flash('Doctor deleted.', 'info');
    redirect('admin/doctors.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editId = (int)($_POST['edit_id'] ?? 0);
    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $phone  = trim($_POST['phone']);
    $spec   = trim($_POST['specialization']);
    $status = $_POST['status'];
    $pass   = $_POST['password'];
    if ($editId) {
        if ($pass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE doctors SET name=?,email=?,phone=?,specialization=?,password=?,status=? WHERE id=?");
            $stmt->bind_param('ssssssi', $name, $email, $phone, $spec, $hash, $status, $editId);
        } else {
            $stmt = $conn->prepare("UPDATE doctors SET name=?,email=?,phone=?,specialization=?,status=? WHERE id=?");
            $stmt->bind_param('sssssi', $name, $email, $phone, $spec, $status, $editId);
        }
        $stmt->execute();
        flash('Doctor updated.');
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO doctors (name,email,phone,specialization,password,status) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('ssssss', $name, $email, $phone, $spec, $hash, $status);
        $stmt->execute();
        flash('Doctor added.');
    }
    redirect('doctors.php');
}
 $editDoc = null;
if (isset($_GET['edit'])) $editDoc = $conn->query("SELECT * FROM doctors WHERE id=" . (int)$_GET['edit'])->fetch_assoc();
 $search = sanitize($_GET['search'] ?? '');
 $sql = "SELECT * FROM doctors";
if ($search) $sql .= " WHERE name LIKE '%$search%' OR specialization LIKE '%$search%'";
 $sql .= " ORDER BY name";
 $doctors = $conn->query($sql);
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="mb-0">Manage Doctors</h3>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#docModal" onclick="clearForm()"><i class="fas fa-plus me-1"></i>Add Doctor</button>
</div>
<form method="GET" class="row g-3 mb-4"><div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search doctors..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"></div></form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Specialization</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php if ($doctors->num_rows === 0): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No doctors found.</td></tr>
            <?php else: while ($d = $doctors->fetch_assoc()): ?>
                <tr>
                    <td><?= $d['name'] ?></td><td><?= $d['email'] ?></td><td><?= $d['phone'] ?></td><td><?= $d['specialization'] ?></td>
                    <td><span class="badge bg-<?= $d['status']==='active'?'success':'secondary' ?> badge-status"><?= ucfirst($d['status']) ?></span></td>
                    <td>
                        <a href="?edit=<?= $d['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $d['id'] ?>" class="btn btn-sm btn-outline-danger" data-confirm="Delete this doctor?" title="Delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="docModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"><?= $editDoc ? 'Edit' : 'Add' ?> Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="editId" value="<?= $editDoc['id'] ?? '' ?>">
                    <div class="mb-3"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($editDoc['name'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($editDoc['email'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Phone *</label><input type="tel" name="phone" class="form-control" required value="<?= htmlspecialchars($editDoc['phone'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Specialization *</label><input type="text" name="specialization" class="form-control" required value="<?= htmlspecialchars($editDoc['specialization'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Password <?= $editDoc ? '(blank=keep)' : '*' ?></label><input type="password" name="password" class="form-control" <?= $editDoc ? '' : 'required' ?> minlength="6"></div>
                    <div class="mb-0"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" <?= ($editDoc['status'] ?? 'active')==='active'?'selected':'' ?>>Active</option><option value="inactive" <?= ($editDoc['status'] ?? '')==='inactive'?'selected':'' ?>>Inactive</option></select></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
<?php if ($editDoc): ?>
document.addEventListener('DOMContentLoaded', function() { new bootstrap.Modal(document.getElementById('docModal')).show(); });
<?php endif; ?>
function clearForm() {
    document.getElementById('editId').value = '';
    document.getElementById('modalTitle').textContent = 'Add Doctor';
    document.querySelector('#docModal form').reset();
}
</script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>