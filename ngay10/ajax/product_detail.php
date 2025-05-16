<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/Product.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit('Missing product id');
}
$id = (int)$_GET['id'];
$product = Product::find($id);
if (!$product) {
    http_response_code(404);
    exit('Product not found');
}
?>
<div class="modal-backdrop show" style="z-index:1040;"></div>
<div class="modal show d-block" tabindex="-1" style="z-index:1050;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= htmlspecialchars($product['product_name']) ?></h5>
        <button type="button" class="btn-close close-detail-modal"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($product['image'])): ?>
          <img src="<?= htmlspecialchars($product['image']) ?>" style="max-width:120px;" class="mb-2 d-block">
        <?php endif; ?>
        <p><?= htmlspecialchars($product['description'] ?? '') ?></p>
        <p><b>Thương hiệu:</b> <?= htmlspecialchars($product['brand'] ?? '') ?></p>
        <p><b>Giá:</b> <?= number_format($product['unit_price']) ?> VNĐ</p>
        <p><b>Kho:</b> <?= (int)($product['stock_quantity'] ?? 0) ?> sản phẩm</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-sm add-to-cart" data-id="<?= $product['id'] ?>">Thêm vào giỏ hàng</button>
        <button class="btn btn-secondary btn-sm show-reviews" data-id="<?= $product['id'] ?>">Xem đánh giá</button>
        <button class="btn btn-outline-secondary btn-sm close-detail-modal">Đóng</button>
      </div>
    </div>
  </div>
</div>