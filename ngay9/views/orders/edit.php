<?php

require_once __DIR__ . '/../../db.php';

// Lấy ID đơn hàng
$order_id = intval($_GET['edit'] ?? 0);

// Lấy thông tin đơn hàng
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();
if (!$order) {
    echo "<div class='alert alert-danger'>Đơn hàng không tồn tại!</div>";
    exit;
}

// Lấy danh sách sản phẩm
$products = $pdo->query("SELECT * FROM products ORDER BY product_name ASC")->fetchAll();

// Lấy các sản phẩm đã có trong đơn hàng
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll();

// Xử lý cập nhật đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = $_POST['customer_name'];
    $note = $_POST['note'];
    $order_date = $_POST['order_date'];

    $pdo->beginTransaction();
    try {
        // Cập nhật thông tin đơn hàng
        $stmt = $pdo->prepare("UPDATE orders SET order_date=?, customer_name=?, note=? WHERE id=?");
        $stmt->execute([$order_date, $customer, $note, $order_id]);

        // Xóa chi tiết cũ
        $pdo->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$order_id]);

        // Thêm lại chi tiết mới
        if (!empty($_POST['product_id'])) {
            foreach ($_POST['product_id'] as $idx => $pid) {
                $quantity = intval($_POST['quantity'][$idx]);
                $stmtP = $pdo->prepare("SELECT unit_price FROM products WHERE id=?");
                $stmtP->execute([$pid]);
                $price = $stmtP->fetchColumn();
                if ($price !== false) {
                    $stmtOI = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
                    $stmtOI->execute([$order_id, $pid, $quantity, $price]);
                }
            }
        }
        $pdo->commit();
        header("Location: index.php?page=orders");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Sửa đơn hàng #<?= $order['id'] ?></h2>
    <form method="post" class="card card-body mb-4">
        <div class="row mb-2">
            <div class="col">
                <input type="date" name="order_date" class="form-control" value="<?= $order['order_date'] ?>" >
            </div>
            <div class="col">
                <input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" value="<?= htmlspecialchars($order['customer_name'] ?? '') ?>" >
            </div>
            <div class="col">
                <input type="text" name="note" class="form-control" placeholder="Ghi chú" value="<?= htmlspecialchars($order['note'] ?? '') ?>">
            </div>
        </div>
        <div class="mb-2">
            <label>Chọn sản phẩm và số lượng:</label>
            <div id="order-products">
                <?php
                $count = count($order_items) ?: 1;
                for ($i = 0; $i < $count; $i++):
                    $item = $order_items[$i] ?? null;
                ?>
                <div class="row mb-1">
                    <div class="col-6">
                        <select name="product_id[]" class="form-select" >
                            <option value="">-- Chọn sản phẩm --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= ($item && $item['product_id'] == $p['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['product_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Số lượng" min="1" value="<?= $item['quantity'] ?? 1 ?>" >
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addProductRow()">+ Thêm sản phẩm</button>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
            <a href="index.php" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
<script>
function addProductRow() {
    var row = `<div class="row mb-1">
        <div class="col-6">
            <select name="product_id[]" class="form-select" required>
                <option value="">-- Chọn sản phẩm --</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-3">
            <input type="number" name="quantity[]" class="form-control" placeholder="Số lượng" min="1" value="1" required>
        </div>
    </div>`;
    document.getElementById('order-products').insertAdjacentHTML('beforeend', row);
}
</script>
</body>
</html>