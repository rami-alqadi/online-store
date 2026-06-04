<?php
require '../includes/db.php';
require '../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify(trim($_POST['password']), $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role']      = $user['role'];
            setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), '/');
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        }
    }
    $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة!";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">🛒 تسجيل الدخول</h3>
          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label>البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>كلمة المرور</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">دخول</button>
          </form>
          <p class="text-center mt-3">ليس لديك حساب؟ <a href="register.php">سجل الآن</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>