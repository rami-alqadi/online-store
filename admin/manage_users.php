<?php
require '../includes/header.php';
requireAdmin();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        if ($id !== $_SESSION['user_id']) {
            mysqli_query($conn, "DELETE FROM users WHERE id=$id");
            $msg = '<div class="alert alert-warning">تم حذف المستخدم.</div>';
        }
    } elseif ($_POST['action'] === 'toggle_role') {
        $id      = (int)$_POST['id'];
        $newRole = $_POST['current_role'] === 'admin' ? 'customer' : 'admin';
        mysqli_query($conn, "UPDATE users SET role='$newRole' WHERE id=$id");
        $msg = '<div class="alert alert-success">تم تغيير الصلاحية.</div>';
    }
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

<h2 class="mb-3">👤 إدارة المستخدمين</h2>
<?= $msg ?>

<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr><th>#</th><th>الاسم</th><th>البريد</th><th>الصلاحية</th><th>تاريخ التسجيل</th><th>إجراءات</th></tr>
  </thead>
  <tbody>
    <?php while ($u = mysqli_fetch_assoc($users)): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td>
        <span class="badge bg-<?= $u['role']==='admin'?'danger':'success' ?>">
          <?= $u['role']==='admin'?'مدير':'عميل' ?>
        </span>
      </td>
      <td><?= date('Y-m-d', strtotime($u['created_at'])) ?></td>
      <td class="d-flex gap-1">
        <form method="POST">
          <input type="hidden" name="action" value="toggle_role">
          <input type="hidden" name="id" value="<?= $u['id'] ?>">
          <input type="hidden" name="current_role" value="<?= $u['role'] ?>">
          <button class="btn btn-warning btn-sm">تغيير الصلاحية</button>
        </form>
        <?php if ($u['id'] !== $_SESSION['user_id']): ?>
        <form method="POST">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= $u['id'] ?>">
          <button class="btn btn-danger btn-sm" onclick="return confirm('حذف المستخدم؟')">حذف</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php require '../includes/footer.php'; ?>