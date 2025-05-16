<?php
class Review {
    public static function getByProduct($product_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id=? ORDER BY created_at DESC");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll();
    }
}