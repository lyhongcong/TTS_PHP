<?php
session_start();

// Đọc cookie để điền sẵn email
$customer_email = isset($_COOKIE['customer_email']) ? $_COOKIE['customer_email'] : '';

// Khởi tạo giỏ hàng trong session nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sách vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Lấy và xác thực dữ liệu đầu vào
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS); // Thay thế FILTER_SANITIZE_STRING
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{10,15}$/']]);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS); // Thay thế FILTER_SANITIZE_STRING

        if (!$title || !$price || !$quantity || !$email || !$phone || !$address) {
            throw new Exception("Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.");
        }

        // Lưu email vào cookie (7 ngày)
        setcookie('customer_email', $email, time() + (7 * 24 * 60 * 60));

        // Thêm sách vào giỏ hàng
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['title'] === $title) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = ['title' => $title, 'price' => $price, 'quantity' => $quantity];
        }

        // Lưu giỏ hàng vào file JSON
        $cart_data = [
            'customer_email' => $email,
            'customer_phone' => $phone, // Thêm số điện thoại
            'customer_address' => $address, // Thêm địa chỉ
            'products' => $_SESSION['cart'],
            'total_amount' => array_reduce($_SESSION['cart'], function ($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0),
            'created_at' => date('Y-m-d H:i:s')
        ];
        file_put_contents('cart_data.json', json_encode($cart_data, JSON_PRETTY_PRINT));

        $message = "Sách đã được thêm vào giỏ hàng!";
        $messageType = "success";
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Thêm Sách Vào Giỏ Hàng</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?> text-center">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="p-3 border rounded">
        <div class="mb-3">
            <label for="title" class="form-label">Tên sách *</label>
            <input type="text" class="form-control" id="title" name="title" >
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá *</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" >
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng *</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer_email); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại *</label>
            <input type="text" class="form-control" id="phone" name="phone" >
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ *</label>
            <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
    </form>

    <div class="mt-4">
        <a href="checkout.php" class="btn btn-success w-100">Xem giỏ hàng và thanh toán</a>
    </div>
</div>
</body>
</html>