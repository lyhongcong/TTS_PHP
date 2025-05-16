<?php
session_start();
$id = intval($_POST['id'] ?? 0);
$qty = intval($_POST['qty'] ?? 1);
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
} else {
    $_SESSION['cart'][$id] = $qty;
}
echo json_encode([
    'success' => true,
    'cartCount' => array_sum($_SESSION['cart'])
]);