<?php
require '../includes/header.php';
requireAdmin();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status') {
        $id     = (int)$_POST['id'];
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$id");
        $msg = '<div class="alert alert-success">تم تحديث حالة الطلب.</div>';
    }
}

$orders = mysqli_query($conn, "SELECT o.*, u.name AS user_name FROM orders o LEFT JOIN users u ON o.user_id=u.id ORDER BY o.created_at DESC");
?>

<h2 class="mb-3">🛒 إدارة الطلبات</h2>
<?= $msg ?>

<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr><th>#</th><th>العميل</th><th>المبلغ</th><th>الحالة</th><th>التاريخ</th><th>تحديث</th></tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($orders) > 0): ?>
      <?php while ($o = mysqli_fetch_assoc($orders)): ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= htmlspecialchars($o['user_name']) ?></td>
        <td>₪<?= number_format($o['total_price'], 2) ?></td>
        <td>
          <span class="badge bg-info text-dark"><?= $o['status'] ?></span>
        </td>
        <td><?= date('Y-m-d', strtotime($o['created_at'])) ?></td>
        <td>
          <form method="POST" class="d-flex gap-1">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" value="<?= $o['id'] ?>">
            <select name="status" class="form-select form-select-sm">
              <?php foreach(['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= $o['status']===$s?'selected':'' ?>><?= $s ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-primary btn-sm">حفظ</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6" class="text-center">لا توجد طلبات بعد.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php require '../includes/footer.php'; ?>