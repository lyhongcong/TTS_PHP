<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function index() {
        $products = Product::all();
        require __DIR__ . '/../views/products/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Product::create($_POST);
            header('Location: /ngay9/index.php');
            exit;
        }
        require __DIR__ . '/../views/products/add.php';
    }

    public function edit() {
        $id = $_GET['id'];
        $product = Product::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Product::update($id, $_POST);
            header('Location: /ngay9/index.php');
            exit;
        }
        require __DIR__ . '/../views/products/edit.php';
    }

    public function delete() {
        $id = $_GET['id'];
        Product::delete($id);
        header('Location: /ngay9/index.php');
        exit;
    }
}