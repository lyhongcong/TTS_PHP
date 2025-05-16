<?php

require_once __DIR__ . '/db.php';

// Xác định trang hiện tại
$page = $_GET['page'] ?? 'products';

// Bắt đầu lấy nội dung động
ob_start();
if ($page === 'orders') {
    if (isset($_GET['add'])) {
        require __DIR__ . '/views/orders/add.php';
    } elseif (isset($_GET['edit'])) {
        require __DIR__ . '/views/orders/edit.php';
    }elseif (isset($_GET['detail'])) {
        require __DIR__ . '/views/orders/detail.php';
    }else {
        require __DIR__ . '/views/orders/index.php';
    }
} else {
    if (isset($_GET['add'])) {
        require __DIR__ . '/views/products/add.php';
    } elseif (isset($_GET['edit'])) {
        require __DIR__ . '/views/products/edit.php';
    } else {
        require __DIR__ . '/views/products/index.php';
    }
}
$content = ob_get_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quản lý sản xuất</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">TechFactory</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link<?= $page === 'products' ? ' active' : '' ?>" href="index.php?page=products">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= $page === 'orders' ? ' active' : '' ?>" href="index.php?page=orders">Đơn hàng</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <?= $content ?>
</div>
</body>
</html>