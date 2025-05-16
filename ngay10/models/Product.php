<?php
class Product {
    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    }
    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}