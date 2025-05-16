<?php
require_once 'db.php';
require_once 'models/Product.php';
session_start();
$products = Product::all();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .product-card {
            min-height: 320px;
        }

        .product-img {
            height: 120px;
            object-fit: contain;
        }

        .search-item {
            padding: 5px;
            border-bottom: 1px solid #eee;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1040;
        }

        #product-detail-modal .modal {
            z-index: 1050;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light mb-3">
        <div class="container">
            <span class="navbar-brand mb-0 h1">E-Commerce</span>
            <a href="#" class="btn btn-outline-primary">
                Giỏ hàng <span id="cart-count" class="badge bg-primary"><?= $cartCount ?></span>
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="mb-3">
            <input type="text" id="live-search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
            <div id="search-result"></div>
        </div>
        <div class="mb-3">
            <h5>Lọc sản phẩm</h5>
            <div class="row g-2">
                <div class="col-auto">
                    <button id="filter-all" class="btn btn-secondary">Tất cả</button>
                </div>
                <div class="col-auto">
                    <select id="category-select" class="form-select">
                        <option value="">Chọn ngành hàng</option>
                        <option value="Điện tử">Điện tử</option>
                        <option value="Thời trang">Thời trang</option>
                        <!-- Thêm các ngành hàng khác nếu có -->
                    </select>
                </div>
                <div class="col-auto">
                    <select id="brand-select" class="form-select">
                        <option value="">Chọn thương hiệu</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" id="product-list">
            <?php foreach ($products as $p): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 product-item"
                    data-category="<?= htmlspecialchars($p['category'] ?? '') ?>"
                    data-brand="<?= htmlspecialchars($p['brand'] ?? '') ?>">
                    <div class="card h-100 product-card">
                        <?php if (!empty($p['image'])): ?>
                            <img src="<?= htmlspecialchars($p['image']) ?>"
                                class="card-img-top product-img mx-auto d-block mt-3"
                                alt="<?= htmlspecialchars($p['product_name']) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold"><?= htmlspecialchars($p['product_name']) ?></h6>
                            <p class="mb-1">Thương hiệu: <b><?= htmlspecialchars($p['brand'] ?? '') ?></b></p>
                            <p class="mb-1">Giá: <b><?= number_format($p['unit_price']) ?> VNĐ</b></p>
                            <div class="mt-auto">
                                <button class="btn btn-info btn-sm show-detail" data-id="<?= $p['id'] ?>">Chi tiết</button>
                                <button class="btn btn-primary btn-sm add-to-cart" data-id="<?= $p['id'] ?>">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="product-detail-modal" style="display:none;"></div>
        <div id="reviews-modal" style="display:none;"></div>
        <div class="mt-4">
            <h5>Giúp chúng tôi cải thiện!</h5>
            <form id="poll-form">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option" value="Giao diện" id="poll1">
                    <label class="form-check-label" for="poll1">Giao diện</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option" value="Tốc độ" id="poll2">
                    <label class="form-check-label" for="poll2">Tốc độ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option" value="Dịch vụ khách hàng" id="poll3">
                    <label class="form-check-label" for="poll3">Dịch vụ khách hàng</label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Gửi đánh giá</button>
            </form>
            <div id="poll-result"></div>
        </div>
    </div>
    <script src="assets/main.js"></script>
</body>

</html>