<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>متجرنا الإلكتروني</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/online_store/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/online_store/index.php">🛒 متجرنا</a>
    <div class="ms-auto d-flex gap-2">
      <?php if (isLoggedIn()): ?>
        <span class="text-light align-self-center">مرحباً، <?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <?php if (isAdmin()): ?>
          <a href="/online_store/admin/dashboard.php" class="btn btn-warning btn-sm">لوحة التحكم</a>
        <?php endif; ?>
        <a href="/online_store/auth/logout.php" class="btn btn-danger btn-sm">خروج</a>
      <?php else: ?>
        <a href="/online_store/auth/login.php" class="btn btn-outline-light btn-sm">دخول</a>
        <a href="/online_store/auth/register.php" class="btn btn-primary btn-sm">تسجيل</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container mt-4">