<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Kiểm tra nếu có dữ liệu POST
    $username = $_POST['username']; // Lấy tên đăng nhập từ biểu mẫu
    $password = $_POST['password']; // Lấy mật khẩu từ biểu mẫu

    // Kiểm tra thông tin đăng nhập (thay thế bằng logic thực tế)
    if ($username === 'admin' && $password === '12345') {
        $_SESSION['logged_in'] = true;

        // Chuyển hướng đến trang chính
        header('Location: index.php');
        exit; // Dừng thực thi mã sau khi chuyển hướng
    } else {
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Đăng nhập</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" >
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" >
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Đăng nhập</button>
        <a style="margin-left: auto;" href="index.php" class="btn btn-secondary btn-sm mt-2">Quay về trang chính</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>