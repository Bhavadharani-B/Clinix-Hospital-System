<?php
 $pageTitle = 'Book Appointment';
require_once __DIR__ . '/../includes/header.php';
checkRole('patient');
 $uid = $_SESSION['user_id'];
 $did = (int)($_GET['doctor_id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $did    = (int)$_POST['doctor_id'];
    $date   = $_POST['date'];
    $time   = $_POST['time'];
    $reason = trim($_POST['reason']);
    $chk = $conn->prepare("SELECT id FROM appointments WHERE patient_id=? AND doctor_id=? AND date=? AND status IN ('pending','accepted')");
    $chk->bind_param('iis', $uid, $did, $date);
    $chk->execute();
    if ($chk->get_result()->num_rows > 0) {
        flash('You already have a pending/accepted appointment with this doctor on this date.', 'warning');
    } else {
        $stmt = $conn->prepare("INSERT INTO appointments (patient_id,doctor_id,date,time,reason) VALUES (?,?,?,?,?)");
        $stmt->bind_param('iisss', $uid, $did, $date, $time, $reason);
        $stmt->execute();
        flash('Appointment booked successfully!');
        redirect('patient/appointments.php');
    }
}
 $doctors = $conn->query("SELECT id, name, specialization FROM doctors WHERE status='active' ORDER BY name");
?>
<h3 class="mb-4">Book Appointment</h3>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4 shadow-sm">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Select Doctor *</label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">Choose a doctor</option>
                        <?php while ($d = $doctors->fetch_assoc()): ?>
                        <option value="<?= $d['id'] ?>" <?= $did === (int)$d['id'] ? 'selected' : '' ?>><?= $d['name'] ?> — <?= $d['specialization'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6"><label class="form-label">Date *</label><input type="date" name="date" class="form-control" required min="<?= date('Y-m-d') ?>"></div>
                    <div class="col-6"><label class="form-label">Time *</label><input type="time" name="time" class="form-control" required></div>
                </div>
                <div class="mb-3"><label class="form-label">Reason</label><textarea name="reason" class="form-control" rows="3" placeholder="Brief description of your concern"></textarea></div>
                <button type="submit" class="btn btn-primary w-100 py-2">Book Appointment</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>