<?php
require_once __DIR__ . '/../../db.php';

// Lấy thông tin đơn hàng
$order_id = intval($_GET['detail'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();
if (!$order) {
    echo "<div class='alert alert-danger'>Đơn hàng không tồn tại!</div>";
    exit;
}

// Lấy các sản phẩm trong đơn hàng
$stmt = $pdo->prepare("
    SELECT oi.*, p.product_name 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll();

// Tính tổng tiền
$total = 0;
foreach ($order_items as $item) {
    $total += $item['quantity'] * $item['price_at_order_time'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chi tiết đơn hàng #<?= $order['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Chi tiết đơn hàng #<?= $order['id'] ?></h2>
    <div class="mb-3">
        <strong>Ngày đặt:</strong> <?= $order['order_date'] ?><br>
        <strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name'] ?? '') ?><br>
        <strong>Ghi chú:</strong> <?= htmlspecialchars($order['note'] ?? '') ?>
    </div>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-secondary">
            <tr>
                <th>Sản phẩm</th>
                <th>Giá tại thời điểm đặt</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= number_format($item['price_at_order_time']) ?> VNĐ</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['quantity'] * $item['price_at_order_time']) ?> VNĐ</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Tổng cộng</th>
                <th><?= number_format($total) ?> VNĐ</th>
            </tr>
        </tfoot>
    </table>
    <a href="index.php?page=orders" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>
</body>
</html>