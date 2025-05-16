<?php
require_once '../db.php';
$product_id = intval($_POST['product_id']);
$user_name = $_POST['user_name'];
$content = $_POST['content'];
$rating = intval($_POST['rating']);
$image_path = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target = '../uploads/' . uniqid() . '_' . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_path = $target;
    }
}
$stmt = $pdo->prepare("INSERT INTO reviews (product_id, user_name, content, rating, image) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$product_id, $user_name, $content, $rating, $image_path]);
echo json_encode(['success' => true, 'message' => 'Đánh giá đã được gửi!']);