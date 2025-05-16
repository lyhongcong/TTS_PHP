<?php

require_once __DIR__ . '/../models/Order.php';

class OrderController
{
    // Hiển thị danh sách đơn hàng
    public function index() {
        $orders = Order::all();
        require __DIR__ . '/../views/orders/index.php';
    }

    // Thêm đơn hàng mới
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Order::create($_POST);
            header('Location: /ngay9/index.php?page=orders');
            exit;
        }
        require __DIR__ . '/../views/orders/add.php';
    }

    // Sửa đơn hàng
    public function edit() {
        $id = $_GET['id'];
        $order = Order::find($id);
        $order_items = Order::items($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Order::update($id, $_POST);
            header('Location: /ngay9/index.php?page=orders');
            exit;
        }
        require __DIR__ . '/../views/orders/edit.php';
    }

    // Xóa đơn hàng
    public function delete() {
        $id = $_GET['id'];
        Order::delete($id);
        header('Location: /ngay9/index.php?page=orders');
        exit;
    }

    // Xem chi tiết đơn hàng
    public function detail() {
        $id = $_GET['id'];
        $order = Order::find($id);
        $order_items = Order::items($id);
        require __DIR__ . '/../views/orders/detail.php';
    }
}