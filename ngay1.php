<?php
// filepath: x:\laragon\www\THUC_TAP\PHP\buoi1\bai1.php

// Hằng số
const COMMISSION_RATE = 0.2; // Tỷ lệ hoa hồng 20%
const VAT_RATE = 0.1;       // Thuế VAT 10%

// Dữ liệu đầu vào
$ten_chien_dich = "Spring Sale 2025"; // Tên chiến dịch
$ten_san_pham = "Áo thun nam"; // Tên sản phẩm
$gia_san_pham = 199.98;                // Giá sản phẩm (USD)
$loai_san_pham = "Thời trang";        // Loại sản phẩm
$trang_thai_chien_dich = true;        // Trạng thái chiến dịch (true = kết thúc)
$danh_sach_don_hang = [               // Danh sách đơn hàng (mã đơn hàng => giá trị)
    "DH001" => 199.98, // Đơn hàng 1
    "DH002" => 299.97, // Đơn hàng 2
    "DH003" => 399.96, // Đơn hàng 3
    "DH004" => 499.95, // Đơn hàng 4
    "DH005" => 599.94, // Đơn hàng 5
];

// Tính tổng doanh thu từ danh sách đơn hàng
$dem_so_don_hang = count($danh_sach_don_hang); // Đếm số lượng đơn hàng
$tong_doanh_thu = 0; // Khởi tạo biến tổng doanh thu
foreach ($danh_sach_don_hang as $ma_don_hang => $gia_tri_don_hang) {
    $tong_doanh_thu += $gia_tri_don_hang; // Cộng dồn giá trị từng đơn hàng
}

// Tính toán chi phí hoa hồng, thuế VAT và lợi nhuận
$chi_phi_hoa_hong = $tong_doanh_thu * COMMISSION_RATE; // Chi phí hoa hồng = Doanh thu * Tỷ lệ hoa hồng
$thue_vat = $tong_doanh_thu * VAT_RATE;               // Thuế VAT = Doanh thu * Tỷ lệ VAT
$loi_nhuan = $tong_doanh_thu - $chi_phi_hoa_hong - $thue_vat; // Lợi nhuận = Doanh thu - Hoa hồng - Thuế

// Đánh giá hiệu quả chiến dịch
if ($loi_nhuan > 0) {
    $ket_qua_chien_dich = "Chiến dịch thành công"; // Lợi nhuận dương
} elseif ($loi_nhuan == 0) {
    $ket_qua_chien_dich = "Chiến dịch hòa vốn";    // Lợi nhuận bằng 0
} else {
    $ket_qua_chien_dich = "Chiến dịch thất bại";   // Lợi nhuận âm
}

// Thông báo theo loại sản phẩm
switch ($loai_san_pham) {
    case "Điện tử":
        $thong_bao_san_pham = "Sản phẩm Điện tử có doanh thu cao.";
        break;
    case "Thời trang":
        $thong_bao_san_pham = "Sản phẩm Thời trang có doanh thu ổn định.";
        break;
    case "Gia dụng":
        $thong_bao_san_pham = "Sản phẩm Gia dụng có tiềm năng phát triển.";
        break;
    default:
        $thong_bao_san_pham = "Loại sản phẩm không xác định.";
}

// Hiển thị kết quả
echo "Tên chiến dịch: $ten_chien_dich<br>"; // Hiển thị tên chiến dịch
echo "Tên sản phẩm: $ten_san_pham<br>"; // Hiển thị tên sản phẩm
echo "Số lượng đơn hàng: $dem_so_don_hang<br>"; // Hiển thị số lượng đơn hàng
echo "Trạng thái: " . ($trang_thai_chien_dich ? "Kết thúc" : "Đang chạy") . "<br>"; // Hiển thị trạng thái chiến dịch
echo "Tổng doanh thu: $" . $tong_doanh_thu . "USD" . "<br>"; // Hiển thị tổng doanh thu
echo "Chi phí hoa hồng: $" . $chi_phi_hoa_hong . "USD" . "<br>"; // Hiển thị chi phí hoa hồng
echo "Thuế VAT: $" . $thue_vat . "USD" . "<br>"; // Hiển thị thuế VAT
echo "Lợi nhuận: $" . $loi_nhuan . "USD" . "<br>"; // Hiển thị lợi nhuận
echo "Đánh giá: $ket_qua_chien_dich<br>"; // Hiển thị đánh giá hiệu quả chiến dịch
echo "$thong_bao_san_pham<br>"; // Hiển thị thông báo theo loại sản phẩm
echo "----------------------------------------------------------------------------------------------------------------- <br>";
// Hiển thị chi tiết từng đơn hàng
echo "<br>Chi tiết từng đơn hàng:<br>";
foreach ($danh_sach_don_hang as $id => $gia_tri_don_hang) {
    echo " - Mã đơn: $id, Giá trị: $" . $gia_tri_don_hang . " USD" . "<br>";
}
// Thông báo mẫu: "Chiến dịch Spring Sale 2025 đã kết thúc với lợi nhuận: [số tiền] USD".
echo "<br>Chiến dịch $ten_chien_dich đã kết thúc với lợi nhuận: $" . $loi_nhuan . " USD.<br>";
echo "----------------------------------------------------------------------------------------------------------------- <br>";
// Debug thông tin file và dòng code
echo "<br>Debug Info:<br>";
echo "File: " . __FILE__. " line ". __LINE__. "<br>"; // Hiển thị tên file, số dòng hiện tại 

?>