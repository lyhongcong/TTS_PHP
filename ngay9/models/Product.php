<?php

require_once __DIR__ . '/../db.php';

class Product
{
    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity) VALUES (?, ?, ?)");
        $stmt->execute([$data['product_name'], $data['unit_price'], $data['stock_quantity']]);
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE products SET product_name=?, unit_price=?, stock_quantity=? WHERE id=?");
        $stmt->execute([$data['product_name'], $data['unit_price'], $data['stock_quantity'], $id]);
    }

    public static function delete($id) {
    global $pdo;
    // Kiểm tra sản phẩm có trong order_items không
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM order_items WHERE product_id=?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        // Nếu có, không cho xóa
        return false;
    }
    // Nếu không có, cho phép xóa
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    return true;
    }
}