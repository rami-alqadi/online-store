<?php
require '../includes/header.php';
requireAdmin();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
        $price    = (float)$_POST['price'];
        $stock    = (int)$_POST['stock'];
        $cat_id   = (int)$_POST['category_id'];
        $desc     = mysqli_real_escape_string($conn, trim($_POST['description']));
        mysqli_query($conn, "INSERT INTO products (name, price, stock, category_id, description) VALUES ('$name', $price, $stock, $cat_id, '$desc')");
        $msg = '<div class="alert alert-success">تمت إضافة المنتج بنجاح!</div>';
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        mysqli_query($conn, "DELETE FROM products WHERE id=$id");
        $msg = '<div class="alert alert-warning">تم حذف المنتج.</div>';
    }
}

$products   = mysqli_query($conn, "SELECT p.*, c.name AS cat FROM products p LEFT JOIN categories c ON p.category_id=c.id");
$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<h2 class="mb-3">📦 إدارة المنتجات</h2>
<?= $msg ?>

<div class="card mb-4 p-3">
  <h5>إضافة منتج جديد</h5>
  <form method="POST" class="row g-2">
    <input type="hidden" name="action" value="add">
    <div class="col-md-3">
      <input type="text" name="name" class="form-control" placeholder="اسم المنتج" required>
    </div>
    <div class="col-md-2">
      <input type="number" name="price" class="form-control" placeholder="السعر" step="0.01" required>
    </div>
    <div class="col-md-2">
      <input type="number" name="stock" class="form-control" placeholder="الكمية" required>
    </div>
    <div class="col-md-2">
      <select name="category_id" class="form-select">
        <?php
        // إعادة تعيين المؤشر
        mysqli_data_seek($categories, 0);
        while ($c = mysqli_fetch_assoc($categories)): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-2">
      <input type="text" name="description" class="form-control" placeholder="وصف مختصر">
    </div>
    <div class="col-md-1">
      <button class="btn btn-primary w-100">إضافة</button>
    </div>
  </form>
</div>

<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr><th>#</th><th>المنتج</th><th>الفئة</th><th>السعر</th><th>الكمية</th><th>إجراء</th></tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($products) > 0): ?>
      <?php while ($p = mysqli_fetch_assoc($products)): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['cat']) ?></td>
        <td>₪<?= number_format($p['price'], 2) ?></td>
        <td><?= $p['stock'] ?></td>
        <td>
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button class="btn btn-danger btn-sm" onclick="return confirm('حذف المنتج؟')">حذف</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6" class="text-center">لا توجد منتجات بعد.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php require '../includes/footer.php'; ?>