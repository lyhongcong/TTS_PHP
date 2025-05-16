<?php
require_once '../db.php';
require_once '../models/Review.php';
$product_id = intval($_GET['product_id'] ?? 0);
$reviews = Review::getByProduct($product_id);
?>
<div class="modal-backdrop show" style="z-index:1040;"></div>
<div class="modal show d-block" tabindex="-1" style="z-index:1050;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Đánh giá sản phẩm</h5>
        <button type="button" class="btn-close close-reviews-modal"></button>
      </div>
      <div class="modal-body">
        <?php if (empty($reviews)): ?>
          <p>Chưa có đánh giá nào.</p>
        <?php else: ?>
          <?php foreach ($reviews as $r): ?>
            <div class='review'>
              <b><?= htmlspecialchars($r['user_name']) ?></b> (<?= (int)$r['rating'] ?>/5): <?= htmlspecialchars($r['content']) ?>
              <hr>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary btn-sm close-reviews-modal">Đóng</button>
      </div>
    </div>
  </div>
</div>