<?php

require_once __DIR__ . '/../../db.php';

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['product_name']);
    $price = floatval($_POST['unit_price']);
    $stock = intval($_POST['stock_quantity']);
    if ($name === '' || $price <= 0 || $stock < 0) {
        $msg = "<div class='alert alert-danger'>Vui lòng nhập đầy đủ và hợp lệ thông tin sản phẩm!</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $stock]);
        header("Location: index.php"); // Chuyển về trang danh sách sản phẩm sau khi thêm thành công
        exit;
    }
}

// Hiển thị toàn bộ danh sách sản phẩm
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Thêm sản phẩm mới</h2>
    <?= $msg ?? '' ?>
    <form method="post" class="card card-body mb-4" style="max-width:600px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="product_name" class="form-control" >
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="unit_price" class="form-control" min="0" step="0.01" >
        </div>
        <div class="mb-3">
            <label class="form-label">Tồn kho</label>
            <input type="number" name="stock_quantity" class="form-control" min="0" >
        </div>
        <div>
            <button type="submit" name="add_product" class="btn btn-success">Thêm sản phẩm</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>
</body>
</html>