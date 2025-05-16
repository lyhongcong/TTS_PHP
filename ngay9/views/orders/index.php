<?php

require_once __DIR__ . '/../../db.php';

// Xử lý xóa đơn hàng
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Xóa các sản phẩm thuộc đơn hàng trước (nếu dùng ON DELETE CASCADE thì không cần)
    $pdo->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$id]);
    // Xóa đơn hàng
    $pdo->prepare("DELETE FROM orders WHERE id=?")->execute([$id]);
    // Chuyển hướng về trang chính đơn hàng qua index gốc để giữ layout và menu
    header("Location: index.php?page=orders");
    exit;
}

$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
$order_totals = [];
foreach ($orders as $order) {
    $stmt = $pdo->prepare("SELECT SUM(quantity * price_at_order_time) as total FROM order_items WHERE order_id=?");
    $stmt->execute([$order['id']]);
    $order_totals[$order['id']] = $stmt->fetchColumn() ?: 0;
}
?>
<h2 class="mb-4 text-center">Danh sách đơn hàng</h2>
<div class="mb-3 text-end">
    <a href="index.php?page=orders&add=1" class="btn btn-success">+ Thêm đơn hàng mới</a>
</div>
<table class="table table-bordered table-striped align-middle">
    <thead class="table-secondary">
        <tr>
            <th>ID</th>
            <th>Ngày</th>
            <th>Khách hàng</th>
            <th>Ghi chú</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= $o['order_date'] ?></td>
            <td><?= htmlspecialchars($o['customer_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($o['note'] ?? '') ?></td>
            <td><?= number_format($order_totals[$o['id']]) ?> VNĐ</td>
            <td>
                <a href="index.php?page=orders&detail=<?= $o['id'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="index.php?page=orders&edit=<?= $o['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="index.php?page=orders&delete=<?= $o['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa đơn hàng này?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>