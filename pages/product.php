<?php
require '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$id   = (int)$_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result  = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: ../index.php");
    exit();
}
?>

<div class="row">
  <div class="col-md-6">
    <div class="bg-secondary" style="height:300px;border-radius:8px;display:flex;align-items:center;justify-content:center">
      <span class="text-white fs-1">📦</span>
    </div>
  </div>
  <div class="col-md-6">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p class="text-muted"><?= htmlspecialchars($product['category_name']) ?></p>
    <h3 class="text-success">₪<?= number_format($product['price'], 2) ?></h3>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>الكمية المتوفرة: <strong><?= $product['stock'] ?></strong></p>

    <?php if (isLoggedIn()): ?>
      <form method="POST" action="cart.php">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="action" value="add">
        <div class="d-flex gap-2 mb-3">
          <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control" style="width:80px">
          <button class="btn btn-primary">أضف للسلة 🛒</button>
        </div>
      </form>
    <?php else: ?>
      <a href="../auth/login.php" class="btn btn-outline-primary">سجل دخول للشراء</a>
    <?php endif; ?>

    <a href="../index.php" class="btn btn-outline-secondary mt-2">← العودة للمتجر</a>
  </div>
</div>

<?php require '../includes/footer.php'; ?>