<?php
require '../includes/db.php';
require '../includes/auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $error = "جميع الحقول مطلوبة!";
    } elseif (strlen($password) < 6) {
        $error = "كلمة المرور يجب أن تكون 6 أحرف على الأقل!";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "البريد الإلكتروني مسجل مسبقاً!";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt2  = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, "sss", $name, $email, $hashed);
            if (mysqli_stmt_execute($stmt2)) {
                $success = "تم التسجيل بنجاح!";
            } else {
                $error = "حدث خطأ، حاول مجدداً.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إنشاء حساب</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">🛒 إنشاء حساب جديد</h3>
          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?> <a href="login.php">تسجيل الدخول</a></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label>الاسم الكامل</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>كلمة المرور</label>
              <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-success w-100">إنشاء حساب</button>
          </form>
          <p class="text-center mt-3">لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
        </div>
      </div>
    </div>
  </di