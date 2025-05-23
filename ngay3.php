<?php
// ==================== DỮ LIỆU GIẢ LẬP ====================
$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 5000000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 6000000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 5500000],
];

$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
    104 => ['2025-03-01', '2025-03-02', '2025-03-03', '2025-03-04'],
    105 => ['2025-03-01', '2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05'],  
    106 => ['2025-03-01', '2025-03-02', '2025-03-03'],
    107 => ['2025-03-01', '2025-03-02', '2025-03-03', '2025-03-04'],
];

$adjustments = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 300000, 'deduction' => 100000],
    103 => ['allowance' => 400000, 'deduction' => 150000],
    104 => ['allowance' => 600000, 'deduction' => 250000],
    105 => ['allowance' => 700000, 'deduction' => 300000],
    106 => ['allowance' => 800000, 'deduction' => 350000],
    107 => ['allowance' => 900000, 'deduction' => 400000],
];

define('STANDARD_DAYS', 22); // Số ngày làm việc tiêu chuẩn trong tháng

// ==================== CẬP NHẬT DỮ LIỆU ==================
$new_employees = [ 
    ['id' => 104, 'name' => 'Phạm Thị D', 'base_salary' => 5800000],
    ['id' => 105, 'name' => 'Nguyễn Thị E', 'base_salary' => 6200000],
    ['id' => 106, 'name' => 'Trần Văn F', 'base_salary' => 5300000],
    ['id' => 107, 'name' => 'Lê Thị G', 'base_salary' => 5900000],
];
$employees = array_merge($employees, $new_employees); // Thêm nhân viên mới vào danh sách nhân viên


array_push($timesheet[101], '2025-03-06');      // Thêm ngày làm việc vào cuối mảng cho nhân viên A
array_unshift($timesheet[101], '2025-02-28');   // Thêm ngày làm việc vào đầu mảng cho nhân viên A
array_pop($timesheet[101]);                     // Xóa ngày làm việc cuối cùng của nhân viên A
array_shift($timesheet[101]);                   // Xóa ngày làm việc đầu tiên của nhân viên A

array_push($timesheet[107], '2025-03-06');      // Thêm ngày làm việc vào cuối mảng cho nhân viên G
array_unshift($timesheet[107], '2025-02-28');   // Thêm ngày làm việc vào đầu mảng cho nhân viên G
// array_pop($timesheet[107]);                     
// array_shift($timesheet[107]);                   

// ==================== TÍNH NGÀY CÔNG ====================
$timesheet = array_map('array_unique', $timesheet); // Xử lý trùng lặp
$working_days = array_map('count', $timesheet);     // Đếm số ngày công của từng nhân viên

// ==================== TÍNH LƯƠNG ====================
$net_salaries = [];
foreach ($employees as $emp) {
    $id = $emp['id'];                                                               // Lấy ID nhân viên
    $days = $working_days[$id] ?? 0;                                                // Số ngày công của nhân viên
    $base = $emp['base_salary'];                                                    // Lương cơ bản của nhân viên
    $allow = $adjustments[$id]['allowance'] ?? 0;                                   // Phụ cấp của nhân viên
    $deduct = $adjustments[$id]['deduction'] ?? 0;                                  // Khấu trừ của nhân viên
    $net_salaries[$id] = round(($base / STANDARD_DAYS) * $days + $allow - $deduct); // Tính lương thực lĩnh
}

// ==================== BẢNG LƯƠNG ====================
$payroll = array_map(function ($emp) use ($working_days, $adjustments, $net_salaries) {
    $id = $emp['id'];                                       // Lấy ID nhân viên
    return [
        'id' => $id,                                        // Mã nhân viên
        'name' => $emp['name'],                             // Họ tên nhân viên
        'working_days' => $working_days[$id] ?? 0,          // Ngày công
        'base_salary' => $emp['base_salary'],               // Lương cơ bản
        'allowance' => $adjustments[$id]['allowance'] ?? 0, // Phụ cấp
        'deduction' => $adjustments[$id]['deduction'] ?? 0, // Khấu trừ
        'net_salary' => $net_salaries[$id] ?? 0,            // Lương thực lĩnh
    ];
}, $employees);

// ==================== TÌM MAX / MIN NGÀY CÔNG ====================
$sorted_by_days = $working_days; // Tạo một mảng mới với số ngày công
asort($sorted_by_days);         // Sắp xếp theo số ngày công tăng dần
$min_id = array_key_first($sorted_by_days); // Lấy ID nhân viên có ngày công ít nhất
$max_id = array_key_last($sorted_by_days); // Lấy ID nhân viên có ngày công nhiều nhất
$min_name = array_values(array_filter($employees, fn($e) => $e['id'] === $min_id))[0]['name']; // Tìm tên nhân viên có ngày công ít nhất
$max_name = array_values(array_filter($employees, fn($e) => $e['id'] === $max_id))[0]['name']; // Tìm tên nhân viên có ngày công nhiều nhất

// ==================== LỌC NHÂN VIÊN ĐỦ ĐIỀU KIỆN ====================
$qualified = array_filter($working_days, fn($days) => $days >= 4); // Lọc nhân viên có ngày công >= 4
$qualified_names = array_map(function ($id) use ($employees) {
    // Tìm tên nhân viên đủ điều kiện
    return array_values(array_filter($employees, fn($e) => $e['id'] === $id))[0]['name']; 
}, array_keys($qualified)); // Lấy danh sách tên nhân viên đủ điều kiện

// ==================== KIỂM TRA DỮ LIỆU ====================
$check_day = in_array('2025-03-03', $timesheet[102]);           // Kiểm tra nhân viên B có đi làm vào ngày 2025-03-03 không
$exists_adjustment = array_key_exists(101, $adjustments);       // Kiểm tra thông tin phụ cấp của nhân viên 101 có tồn tại không


// ==================== IN BẢNG LƯƠNG DƯỚI DẠNG HTML ====================
echo "<h2>BẢNG LƯƠNG THÁNG 03/2025</h2>";
echo "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; width: 100%; text-align: left;'>";
echo "<thead>";
echo "<tr>";
echo "<th>Mã NV</th>";
echo "<th>Họ tên</th>";
echo "<th>Ngày công</th>";
echo "<th>Lương cơ bản</th>";
echo "<th>Phụ cấp</th>";
echo "<th>Khấu trừ</th>";
echo "<th>Lương thực lĩnh</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($payroll as $p) {
    echo "<tr>";
    echo "<td>{$p['id']}</td>";
    echo "<td>{$p['name']}</td>";
    echo "<td>{$p['working_days']}</td>";
    echo "<td>" . number_format($p['base_salary'], 0, ',', '.') . " VND</td>"; 
    echo "<td>" . number_format($p['allowance'], 0, ',', '.') . " VND</td>";
    echo "<td>" . number_format($p['deduction'], 0, ',', '.') . " VND</td>";
    echo "<td>" . number_format($p['net_salary'], 0, ',', '.') . " VND</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table> <br>";

$total_payroll = array_sum($net_salaries); // Tính tổng quỹ lương
echo "Tổng quỹ lương tháng 03/2025: " . number_format($total_payroll) . " VND"."<br>";
echo "Nhân viên làm nhiều nhất: $max_name ({$working_days[$max_id]} ngày công)"."<br>";
echo "Nhân viên làm ít nhất: $min_name ({$working_days[$min_id]} ngày công)"."<br>";

echo "Danh sách nhân viên đủ điều kiện xét thưởng:"."<br>";
foreach ($qualified_names as $name) { // In danh sách nhân viên đủ điều kiện xét thưởng
    echo "- $name"."<br>";
}