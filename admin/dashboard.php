<?php
require '../includes/header.php';
requireAdmin();

$total_users    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];
$total_products = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM products"))[0];
$total_orders   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM orders"))[0];
$total_revenue  = mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(total_price) FROM orders WHERE status != 'cancelled'"))[0] ?? 0;
?>

<h2 class="mb-4">📊 لوحة التحكم</h2>
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="card text-white bg-primary text-center p-3">
      <h3><?= $total_users ?></h3>
      <p class="mb-0">المستخدمون</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-success text-center p-3">
      <h3><?= $total_products ?></h3>
      <p class="mb-0">المنتجات</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-warning text-center p-3">
      <h3><?= $total_orders ?></h3>
      <p class="mb-0">الطلبات</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-danger text-center p-3">
      <h3>₪<?= number_format($total_revenue, 2) ?></h3>
      <p class="mb-0">الإيرادات</p>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <a href="manage_products.php" class="btn btn-outline-primary w-100 py-3">📦 إدارة المنتجات</a>
  </div>
  <div class="col-md-3">
    <a href="manage_users.php" class="btn btn-outline-secondary w-100 py-3">👤 إدارة المستخدمين</a>
  </div>
  <div class="col-md-3">
    <a href="manage_orders.php" class="btn btn-outline-warning w-100 py-3">🛒 إدارة الطلبات</a>
  </div>
  <div class="col-md-3">
    <a href="manage_categories.php" class="btn btn-outline-success w-100 py-3">📂 إدارة الفئات</a>
  </div>
</div>

<?php require '../includes/footer.php'; ?>