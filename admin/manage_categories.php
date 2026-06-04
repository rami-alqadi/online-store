<?php
require '../includes/header.php';
requireAdmin();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $desc = mysqli_real_escape_string($conn, trim($_POST['description']));
        if (!empty($name)) {
            mysqli_query($conn, "INSERT INTO categories (name, description) VALUES ('$name', '$desc')");
            $msg = '<div class="alert alert-success">تمت إضافة الفئة بنجاح!</div>';
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
        $msg = '<div class="alert alert-warning">تم حذف الفئة.</div>';
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<h2 class="mb-3">📂 إدارة الفئات</h2>
<?= $msg ?>

<div class="card mb-4 p-3">
  <h5>إضافة فئة جديدة</h5>
  <form method="POST" class="row g-2">
    <input type="hidden" name="action" value="add">
    <div class="col-md-4">
      <input type="text" name="name" class="form-control" placeholder="اسم الفئة" required>
    </div>
    <div class="col-md-6">
      <input type="text" name="description" class="form-control" placeholder="وصف مختصر">
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">إضافة</button>
    </div>
  </form>
</div>

<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr><th>#</th><th>اسم الفئة</th><th>الوصف</th><th>إجراء</th></tr>
  </thead>
  <tbody>
    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
    <tr>
      <td><?= $cat['id'] ?></td>
      <td><?= htmlspecialchars($cat['name']) ?></td>
      <td><?= htmlspecialchars($cat['description']) ?></td>
      <td>
        <form method="POST" style="display:inline">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= $cat['id'] ?>">
          <button class="btn btn-danger btn-sm" onclick="return confirm('حذف الفئة؟')">حذف</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php require '../includes/footer.php'; ?>