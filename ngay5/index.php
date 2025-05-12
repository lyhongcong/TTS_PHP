<?php
session_start(); // Bắt đầu session

// Bao gồm các tệp cần thiết
require_once 'includes/logger.php';
require_once 'includes/upload.php';

// Khởi tạo các biến
$message = '';
$messageType = '';
$uploadedFile = null;

// Xử lý khi gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? trim($_POST['action']) : ''; // Lấy mô tả hành động từ biểu mẫu
    
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = handleFileUpload($_FILES['attachment']); // Gọi hàm tải lên file
        
        if ($uploadResult['success']) { 
            $uploadedFile = $uploadResult['filename']; // Lưu tên file đã tải lên
            $message = $uploadResult['message']; // Thông báo thành công
            $messageType = 'success';
        } else {
            $message = $uploadResult['message']; // Thông báo lỗi
            $messageType = 'danger';
        }
    }
    
    if (!empty($action)) {
        if (logActivity($action, $uploadedFile)) {
            $message .= ' Hoạt động đã được ghi nhật ký thành công.';
            $messageType = 'success';
        } else {
            $message .= ' Không thể ghi nhật ký hoạt động.';
            $messageType = 'danger';
        }
    } else {
        $message = 'Vui lòng nhập mô tả hành động.';
        $messageType = 'warning';
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center text-success">Ghi nhật ký hoạt động</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?> text-center" role="alert"> 
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" class="p-3 border rounded">
        <div class="mb-3">
            <label for="action" class="form-label">Mô tả hành động *</label>
            <input type="text" class="form-control" id="action" name="action" placeholder="Nhập mô tả hành động">
        </div>
        
        <div class="mb-3">
            <label for="attachment" class="form-label">File minh chứng (tùy chọn)</label>
            <input type="file" class="form-control" id="attachment" name="attachment">
        </div>
        
        <button type="submit" class="btn btn-success w-100">Ghi nhật ký</button>
    </form>
    
    <div class="mt-4">
        <h4 class="text-center text-secondary">Các hành động mẫu</h4>
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Đăng nhập vào hệ thống')">Đăng nhập vào hệ thống</button>
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Đăng xuất khỏi hệ thống')">Đăng xuất khỏi hệ thống</button>
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Gửi biểu mẫu đánh giá')">Gửi biểu mẫu đánh giá</button>
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Chỉnh sửa thông tin cá nhân')">Chỉnh sửa thông tin cá nhân</button>
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Đăng nhập thất bại')">Đăng nhập thất bại</button>
            <button type="button" class="list-group-item list-group-item-action" onclick="setAction('Cảnh báo bảo mật')">Cảnh báo bảo mật</button>
        </div>
    </div>
</div>

<script>
    function setAction(actionText) {
        document.getElementById('action').value = actionText;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>