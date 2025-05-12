<?php
session_start();

// Xử lý yêu cầu xóa giỏ hàng
if (isset($_POST['clear_cart'])) {
    // Xóa giỏ hàng trong session
    unset($_SESSION['cart']);
    
    // Xóa file JSON nếu tồn tại
    if (file_exists('cart_data.json')) {
        unlink('cart_data.json');
    }

    // Chuyển hướng để tránh gửi lại form khi refresh
    header("Location: checkout.php");
    exit();
}

// Đọc giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Tính tổng tiền
$total_amount = array_reduce($cart, function ($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0);

// Đọc thông tin từ file JSON
$cart_data = file_exists('cart_data.json') ? json_decode(file_get_contents('cart_data.json'), true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Thông Tin Thanh Toán</h2>

    <?php if (!empty($cart)): ?>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo number_format($item['price']); ?> VND</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity']); ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-end">Tổng tiền: <?php echo number_format($total_amount); ?> VND</h4>

        <h5 class="mt-4">Thông tin khách hàng:</h5>
        <p>Email: <?php echo htmlspecialchars($cart_data['customer_email'] ?? ''); ?></p>
        <p>Số điện thoại: <?php echo htmlspecialchars($cart_data['customer_phone'] ?? ''); ?></p>
        <p>Địa chỉ: <?php echo htmlspecialchars($cart_data['customer_address'] ?? ''); ?></p>
        <p>Thời gian đặt hàng: <?php echo htmlspecialchars($cart_data['created_at'] ?? ''); ?></p>

        <!-- Nút xóa giỏ hàng -->
        <form method="POST" class="mt-4">
            <button type="submit" name="clear_cart" class="btn btn-danger w-100">Xóa giỏ hàng</button>
        </form>
    <?php else: ?>
        <p class="text-center">Giỏ hàng trống.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php" class="btn btn-primary w-100">Quay lại trang chính</a>
    </div>
</div>
</body>
</html>