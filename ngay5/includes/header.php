<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Nhật ký Hoạt động</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .log-warning {
            color: orange;
        }

        .log-danger {
            color: red;
        }

        .log-success {
            color: green;
        }

        body {
            padding-top: 20px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="mb-4">
            <h1 class="display-5 fw-bold">Hệ thống Nhật ký Hoạt động</h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Trang chính</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_log.php">Xem nhật ký</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav" style="margin-left: auto;">
                            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                                <li class="nav-item">
                                    <a class="btn btn-danger" href="logout.php">Đăng xuất</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="login.php">Đăng nhập</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>