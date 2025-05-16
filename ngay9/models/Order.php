<?php

require_once __DIR__ . '/../db.php';

class Order
{
    // Lấy tất cả đơn hàng
    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
    }

    // Lấy đơn hàng theo ID
    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm đơn hàng mới và các sản phẩm chi tiết
    public static function create($data) {
        global $pdo;
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (?, ?, ?)");
            $stmt->execute([
                $data['order_date'],
                $data['customer_name'],
                $data['note'] ?? null
            ]);
            $order_id = $pdo->lastInsertId();

            if (!empty($data['product_id'])) {
                foreach ($data['product_id'] as $idx => $pid) {
                    $quantity = intval($data['quantity'][$idx]);
                    $stmtP = $pdo->prepare("SELECT unit_price FROM products WHERE id=?");
                    $stmtP->execute([$pid]);
                    $price = $stmtP->fetchColumn();
                    if ($price !== false) {
                        $stmtOI = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
                        $stmtOI->execute([$order_id, $pid, $quantity, $price]);
                        // Trừ tồn kho
                        $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id=?")->execute([$quantity, $pid]);
                    }
                }
            }
            $pdo->commit();
            return $order_id;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    // Cập nhật đơn hàng và chi tiết sản phẩm
    public static function update($id, $data) {
        global $pdo;
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE orders SET order_date=?, customer_name=?, note=? WHERE id=?");
            $stmt->execute([
                $data['order_date'],
                $data['customer_name'],
                $data['note'] ?? null,
                $id
            ]);
            // Xóa chi tiết cũ
            $pdo->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$id]);
            // Thêm lại chi tiết mới
            if (!empty($data['product_id'])) {
                foreach ($data['product_id'] as $idx => $pid) {
                    $quantity = intval($data['quantity'][$idx]);
                    $stmtP = $pdo->prepare("SELECT unit_price FROM products WHERE id=?");
                    $stmtP->execute([$pid]);
                    $price = $stmtP->fetchColumn();
                    if ($price !== false) {
                        $stmtOI = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
                        $stmtOI->execute([$id, $pid, $quantity, $price]);
                    }
                }
            }
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    // Xóa đơn hàng và chi tiết
    public static function delete($id) {
        global $pdo;
        $pdo->beginTransaction();
        try {
            $pdo->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$id]);
            $pdo->prepare("DELETE FROM orders WHERE id=?")->execute([$id]);
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    // Lấy chi tiết sản phẩm của đơn hàng
    public static function items($order_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT oi.*, p.product_name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll();
    }
}