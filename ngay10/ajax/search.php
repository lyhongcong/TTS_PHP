<?php
require_once '../db.php';
$q = $_GET['q'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE ?");
$stmt->execute(['%' . $q . '%']);
$products = $stmt->fetchAll();
foreach ($products as $p) {
    echo "<div class='search-item'>
        <img src='{$p['image']}' width='40'> 
        <b>{$p['product_name']}</b> - " . number_format($p['unit_price']) . " VNĐ
    </div>";
}