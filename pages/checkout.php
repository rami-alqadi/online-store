<?php
require '../includes/header.php';
requireLogin();

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = 0;
    $items = [];

    foreach ($_SESSION['cart'] as $pid => $qty) {
        $pid  = (int)$pid;
        $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $pid);
        mysqli_stmt_execute($stmt);
        $res     = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($res);
        if ($product) {
            $total   += $product['price'] * $qty;
            $items[]  = ['product' => $product, 'qty' => $qty];
        }
    }

    // إنشاء الطلب
    $user_id = $_SESSION['user_id'];
    $stmt2   = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt2, "id", $user_id, $total);
    mysqli_stmt_execute($stmt2);
    $order_id = mysqli_insert_id($conn);

    // إضافة تفاصيل الطلب
    foreach ($items as $item) {
        $pid   = $item['product']['id'];
        $qty   = $item['qty'];
        $price = $item['product']['price'];
        $stmt3 = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt3, "iiid", $order_id, $pid, $qty, $price);
        mysqli_stmt_execute($stmt3);

        // تحديث المخزون
        mysqli_query($conn, "UPDATE products SET stock=stock-$qty WHERE id=$pid");
    }

    // تفريغ السلة
    $_SESSION['cart'] = [];
    $msg = '<div clas