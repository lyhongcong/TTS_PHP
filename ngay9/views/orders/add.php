<?php

require_once __DIR__ . '/../../db.php';

// Lấy danh sách sản phẩm để chọn khi thêm đơn hàng
$products = $pdo->query("SELECT * FROM products ORDER BY product_name ASC")->fetchAll();

// Xử lý thêm đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = $_POST['customer_name'];
    $note = $_POST['note'];
    $order_date = $_POST['order_date'];
    $stmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (?, ?, ?)");
    $stmt->execute([$order_date, $customer, $note]);
    $order_id = $pdo->lastInsertId();

    // Thêm sản phẩm vào đơn hàng
    if (!empty($_POST['product_id'])) {
        foreach ($_POST['product_id'] as $idx => $pid) {
            $quantity = intval($_POST['quantity'][$idx]);
            $stmtP = $pdo->prepare("SELECT unit_price FROM products WHERE id=?");
            $stmtP->execute([$pid]);
            $price = $stmtP->fetchColumn();
            if ($price !== false) {
                $stmtOI = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
                $stmtOI->execute([$order_id, $pid, $quantity, $price]);
                // Trừ tồn kho
                $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id=?")->execute([$quantity, $pid]);
            }
        }
    }
    header("Location: index.php?page=orders");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Thêm đơn hàng mới</h2>
    <form method="post" class="card card-body mb-4">
        <div class="row mb-2">
            <div class="col">
                <input type="date" name="order_date" class="form-control" value="<?= date('Y-m-d') ?>" >
            </div>
            <div class="col">
                <input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" >
            </div>
            <div class="col">
                <input type="text" name="note" class="form-control" placeholder="Ghi chú">
            </div>
        </div>
        <div class="mb-2">
            <label>Chọn sản phẩm và số lượng:</label>
            <div id="order-products">
                <div class="row mb-1">
                    <div class="col-6">
                        <select name="product_id[]" class="form-select" >
                            <option value="">-- Chọn sản phẩm --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Số lượng" min="1" value="1" >
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addProductRow()">+ Thêm sản phẩm</button>
        </div>
        <div>
            <button type="submit" class="btn btn-success">Thêm đơn hàng</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
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