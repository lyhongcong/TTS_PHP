<?php


require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../models/Product.php';

$msg = '';
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        if (!Product::delete($id)) {
            session_start();
            $_SESSION['msg'] = "<div class='alert alert-danger'>Không thể xóa sản phẩm vì đã có trong đơn hàng!</div>";
        } else {
            session_start();
            $_SESSION['msg'] = "<div class='alert alert-success'>Đã xóa sản phẩm thành công!</div>";
        }
    }
    header("Location: index.php?page=products");
    exit;
}

// Hiển thị thông báo nếu có
session_start();
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// Lọc sản phẩm theo giá
$filter_price = isset($_GET['filter_price']) ? true : false;
$show_latest = isset($_GET['latest']) ? true : false;

if ($filter_price) {
    $products = $pdo->query("SELECT * FROM products WHERE unit_price > 1000000 ORDER BY id DESC")->fetchAll();
    $filter_title = "Sản phẩm có giá > 1.000.000 VNĐ";
} elseif ($show_latest) {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 5")->fetchAll();
    $filter_title = "5 sản phẩm mới nhất";
} else {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    $filter_title = "Tất cả sản phẩm";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <?= $msg ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><?= $filter_title ?></h2>
        <a href="index.php?page=products&add=1" class="btn btn-success">+ Thêm sản phẩm mới</a>
    </div>
    <div class="mb-3">
        <a href="index.php?page=products" class="btn btn-outline-primary btn-sm<?= !$filter_price && !$show_latest ? ' active' : '' ?>">Tất cả</a>
        <a href="index.php?page=products&filter_price=1" class="btn btn-outline-primary btn-sm<?= $filter_price ? ' active' : '' ?>">Giá &gt; 1.000.000 VNĐ</a>
        <a href="index.php?page=products&latest=1" class="btn btn-outline-primary btn-sm<?= $show_latest ? ' active' : '' ?>">5 sản phẩm mới nhất</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center" style="width:60px;">ID</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-end">Giá</th>
                        <th class="text-end">Tồn kho</th>
                        <th class="text-center" style="width:180px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td class="text-center"><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['product_name'] ?? '') ?></td>
                        <td class="text-end"><?= number_format($p['unit_price']) ?> VNĐ</td>
                        <td class="text-end"><?= $p['stock_quantity'] ?></td>
                        <td class="text-center">
                            <a href="index.php?page=products&edit=<?= $p['id'] ?>" class="btn btn-warning btn-sm me-1">Sửa</a>
                            <a href="index.php?page=products&delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>