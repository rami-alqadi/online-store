<?php
require '../includes/header.php';
requireLogin();

// تهيئة السلة
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        $pid = (int)$_POST['product_id'];
        $qty = (int)$_POST['quantity'];
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] += $qty;
        } else {
            $_SESSION['cart'][$pid] = $qty;
        }
        $msg = '<div class="alert alert-success">تمت إضافة المنتج للسلة!</div>';
    } elseif ($_POST['action'] === 'remove') {
        $pid = (int)$_POST['product_id'];
        unset($_SESSION['cart'][$pid]);
        $msg = '<div class="alert alert-warning">تم حذف المنتج من السلة.</div>';
    } elseif ($_POST['action'] === 'clear') {
        $_SESSION['cart'] = [];
        $msg = '<div class="alert alert-info">تم تفريغ السلة.</div>';
    }
}

$total = 0;
$cart_items = [];

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $pid  = (int)$pid;
        $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $pid);
        mysqli_stmt_execute($stmt);
        $res     = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($res);
        if ($product) {
            $product['qty']      = $qty;
            $product['subtotal'] = $product['price'] * $qty;
            $total              += $product['subtotal'];
            $cart_items[]        = $product;
        }
    }
}
?>

<h2 class="mb-4">🛒 سلة التسوق</h2>
<?= $msg ?>

<?php if (empty($cart_items)): ?>
  <div class="alert alert-info">السلة فارغة. <a href="../index.php">تسوق الآن</a></div>
<?php else: ?>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr><th>المنتج</th><th>السعر</th><th>الكمية</th><th>المجموع</th><th>إجراء</th></tr>
    </thead>
    <tbody>
      <?php foreach ($cart_items as $item): ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>₪<?= number_format($item['price'], 2) ?></td>
        <td><?= $item['qty'] ?></td>
        <td>₪<?= number_format($item['subtotal'], 2) ?></td>
        <td>
          <form method="POST">
            <input type="hidden" name="action" value="remove">
            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
            <button class="btn btn-danger btn-sm">حذف</button>