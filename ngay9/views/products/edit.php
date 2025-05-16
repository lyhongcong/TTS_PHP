<?php

require_once __DIR__ . '/../../db.php';

// Lấy id từ tham số edit trên URL
$id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $price = floatval($_POST['unit_price']);
    $stock = intval($_POST['stock_quantity']);
    $stmt = $pdo->prepare("UPDATE products SET product_name=?, unit_price=?, stock_quantity=? WHERE id=?");
    $stmt->execute([$name, $price, $stock, $id]);
    header('Location: index.php?page=products');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Sửa sản phẩm</h2>
    <form method="post" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" >
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="unit_price" class="form-control" value="<?= $product['unit_price'] ?>" >
        </div>
        <div class="mb-3">
            <label class="form-label">Tồn kho</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?= $product['stock_quantity'] ?>" >
        </div>
        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
    </form>
    <div class="text-center mt-3">
        <a href="../../index.php?page=products" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
</body>
</html>