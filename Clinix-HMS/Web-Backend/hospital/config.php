<?php
define('BASE_URL', '/hospital');// e.g. '/hospital' if inside a subfolder

 $conn = new mysqli('localhost', 'root', '', 'hospital_db');
if ($conn->connect_error) die('Database connection failed.');
 $conn->set_charset('utf8mb4');
session_start();

function flash($msg, $type = 'success') {
    $_SESSION['flash'] = compact('msg', 'type');
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function redirect($url) {
    header("Location: " . BASE_URL . "/" . ltrim($url, '/'));
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function checkRole($role) {
    if (!isLoggedIn() || $_SESSION['role'] !== $role) redirect('login.php');
}

function getDashboardUrl() {
    return match ($_SESSION['role'] ?? '') {
        'admin'   => 'admin/dashboard.php',
        'doctor'  => 'doctor/dashboard.php',
        'patient' => 'patient/dashboard.php',
        default   => 'index.php'
    };
}
function getNavItems() {
    $b = BASE_URL;
    $role = $_SESSION['role'] ?? null;
    if (!$role) return [
        'Home'     => "$b/index.php",
        'About'    => "$b/about.php",
        'Contact'  => "$b/contact.php",
        'Login'    => "$b/login.php",
        'Register' => "$b/register.php"
    ];
    if ($role === 'patient') return [
        'Dashboard'    => "$b/patient/dashboard.php",
        'Doctors'      => "$b/patient/doctors.php",
        'Appointments' => "$b/patient/appointments.php",
        'Profile'      => "$b/patient/profile.php",
        'Logout'       => "$b/logout.php"
    ];
    if ($role === 'doctor') return [
        'Dashboard'    => "$b/doctor/dashboard.php",
        'Appointments' => "$b/doctor/appointments.php",
        'Profile'      => "$b/doctor/profile.php",
        'Logout'       => "$b/logout.php"
    ];
    if ($role === 'admin') return [
        'Dashboard'    => "$b/admin/dashboard.php",
        'Doctors'      => "$b/admin/doctors.php",
        'Patients'     => "$b/admin/patients.php",
        'Appointments' => "$b/admin/appointments.php",
        'Logout'       => "$b/logout.php"
    ];
    return [];
}

function sanitize($str) {
    global $conn;
    return $conn->real_escape_string(trim($str));
}