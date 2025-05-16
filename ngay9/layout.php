
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TechFactory - Quản lý sản xuất</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">TechFactory</a>
        <div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link<?= $page === 'products' ? ' active' : '' ?>" href="index.php?page=products">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= $page === 'orders' ? ' active' : '' ?>" href="index.php?page=orders">Đơn hàng</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <?= $content ?>
</div>
</body>
</html>