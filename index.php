<?php
require 'includes/header.php';

$result = mysqli_query($conn, "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
?>

<h2 class="mb-4">🛍️ المنتجات</h2>
<div class="row row-cols-1 row-cols-md-3 g-4">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($product = mysqli_fetch_assoc($result)): ?>
    <div class="col">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
          <p class="text-muted small"><?= htmlspecialchars($product['category_name']) ?></p>
          <p class="card-text text-success fw-bold">₪<?= number_format($product['price'], 2) ?></p>
          <p class="card-text small"><?= htmlspecialchars($product['description']) ?></p>
        </div>
        <div class="card-footer">
          <a href="pages/product.php?id=<?= $product['id'] ?>" class="btn btn-primary w-100">عرض المنتج</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="col-12">
      <div class="alert alert-info">لا توجد منتجات حالياً.</div>
    </div>
  <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>