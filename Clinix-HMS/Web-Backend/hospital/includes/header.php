<?php
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $pageTitle ?? 'Clinix' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= isLoggedIn() ? BASE_URL . '/' . getDashboardUrl() : BASE_URL . '/index.php' ?>">             <i class="fas fa-hospital me-2"></i>Clinix
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <?php foreach (getNavItems() as $label => $url): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($_SERVER['PHP_SELF'] === $url) ? 'active fw-semibold' : '' ?>"
                       href="<?= $url ?>"><?= $label ?></a>
                </li>
                <?php endforeach; ?>
                <?php if (isLoggedIn()): ?>
                <li class="nav-item ms-lg-2">
                    <span class="nav-link text-white-50 small">
                        <i class="fas fa-user-circle me-1"></i><?= $_SESSION['user_name'] ?>
                    </span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php if ($f = getFlash()): ?>
<div class="alert alert-<?= $f['type'] ?> alert-dismissible fade show mx-3 mt-3" role="alert">
    <i class="fas fa-<?= $f['type'] === 'success' ? 'check-circle' : ($f['type'] === 'danger' ? 'times-circle' : 'info-circle') ?> me-2"></i>
    <?= $f['msg'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<div class="container py-4">