<?php
require_once '../db.php';
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id != ? ORDER BY RAND() LIMIT 3");
$stmt->execute([$id]);
$products = $stmt->fetchAll();
foreach ($products as $p) {
    echo "<div>{$p['product_name']} - " . number_format($p['unit_price']) . " VNĐ</div>";
}