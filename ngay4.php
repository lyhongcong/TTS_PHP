<?php
// filepath: x:\laragon\www\THUC_TAP\PHP\bai4.php
session_start(); // Bắt đầu session để lưu trữ dữ liệu giao dịch

// Khởi tạo tổng thu và tổng chi nếu chưa có
if (!isset($GLOBALS['total_income'])) {
    $GLOBALS['total_income'] = 0;
}
if (!isset($GLOBALS['total_expense'])) {
    $GLOBALS['total_expense'] = 0;
}

// Tính lại tổng thu và tổng chi từ session khi tải lại trang
if (isset($_SESSION['transactions'])) {
    $GLOBALS['total_income'] = $GLOBALS['total_expense'] = 0;
    foreach ($_SESSION['transactions'] as $transaction) {
        if ($transaction['type'] === 'income') {
            $GLOBALS['total_income'] += $transaction['amount'];
        } else {
            $GLOBALS['total_expense'] += $transaction['amount'];
        }
    }
}

// Hàm kiểm tra và xử lý dữ liệu từ form
function validateAndProcessTransaction($data) {
    $errors = [];
    $transaction = [];

    // Kiểm tra tên giao dịch (không chứa ký tự đặc biệt)
    if (empty($data['transaction_name']) || !preg_match('/^[a-zA-Z0-9\s]+$/', $data['transaction_name'])) {
        $errors[] = "Tên giao dịch không hợp lệ (không được chứa ký tự đặc biệt).";
    } else {
        $transaction['transaction_name'] = htmlspecialchars($data['transaction_name']);
    }

    // Kiểm tra số tiền (phải là số dương)
    if (empty($data['amount']) || !preg_match('/^\d+(\.\d{1,2})?$/', $data['amount']) || $data['amount'] <= 0) {
        $errors[] = "Số tiền phải là số dương.";
    } else {
        $transaction['amount'] = (float)$data['amount'];
    }

    // Kiểm tra loại giao dịch (thu/chi)
    if (empty($data['type']) || !in_array($data['type'], ['income', 'expense'])) {
        $errors[] = "Loại giao dịch không hợp lệ.";
    } else {
        $transaction['type'] = $data['type'];
    }

    // Kiểm tra ngày thực hiện (định dạng dd/mm/yyyy)
    if (empty($data['date']) || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data['date'])) {
        $errors[] = "Ngày thực hiện không đúng định dạng dd/mm/yyyy.";
    } else {
        $transaction['date'] = htmlspecialchars($data['date']);
    }

    // Kiểm tra ghi chú (tùy chọn) và từ khóa nhạy cảm
    if (!empty($data['note'])) {
        $transaction['note'] = htmlspecialchars($data['note']);
        if (preg_match('/nợ xấu|vay nóng/i', $data['note'])) {
            $errors[] = "Ghi chú chứa từ khóa nhạy cảm.";
        }
    } else {
        $transaction['note'] = '';
    }

    // Nếu không có lỗi, xử lý giao dịch
    if (empty($errors)) {
        if ($transaction['type'] === 'income') {
            $GLOBALS['total_income'] += $transaction['amount'];
        } else {
            $GLOBALS['total_expense'] += $transaction['amount'];
        }

        // Lưu giao dịch vào session
        $_SESSION['transactions'][] = $transaction;

        // Chuyển hướng lại trang để tránh gửi lại form khi tải lại
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    return $errors;
}

// Xử lý khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateAndProcessTransaction($_POST);
}

// Lấy danh sách giao dịch từ session
$transactions = $_SESSION['transactions'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý giao dịch tài chính</title>

</head>
<body>
    <h1>Quản lý giao dịch tài chính</h1>

    <!-- Form nhập giao dịch -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="transaction_name">Tên giao dịch:</label>
        <input type="text" id="transaction_name" name="transaction_name" > <br> <br>

        <label for="amount">Số tiền:</label>
        <input type="number" id="amount" name="amount" step="0.01" > <br> <br>

        <label>Loại giao dịch:</label><br>
        <input type="radio" id="income" name="type" value="income" >
        <label for="income">Thu</label> <br>
        <input type="radio" id="expense" name="type" value="expense" > 
        <label for="expense">Chi</label> <br>

        <label for="date">Ngày thực hiện:</label>
        <input type="text" id="date" name="date" placeholder="dd/mm/yyyy" > <br> <br>

        <label for="note">Ghi chú:</label>
        <textarea id="note" name="note"></textarea> <br> <br>

        <button type="submit">Thêm giao dịch</button>
    </form>

    <!-- Hiển thị lỗi -->
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <h3>Lỗi:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Hiển thị danh sách giao dịch -->
    <?php if (!empty($transactions)): ?>
        <h2>Danh sách giao dịch</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Tên giao dịch</th>
                    <th>Số tiền</th>
                    <th>Loại</th>
                    <th>Ngày thực hiện</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['transaction_name']; ?></td>
                        <td><?php echo number_format($transaction['amount']); ?> VND</td>
                        <td><?php echo $transaction['type'] === 'income' ? 'Thu' : 'Chi'; ?></td>
                        <td><?php echo $transaction['date']; ?></td>
                        <td><?php echo $transaction['note']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Hiển thị thống kê -->
        <h3>Thống kê</h3>
        <p>Tổng thu: <?php echo number_format($GLOBALS['total_income']); ?> VND</p>
        <p>Tổng chi: <?php echo number_format($GLOBALS['total_expense']); ?> VND</p>
        <p>Số dư: <?php echo number_format($GLOBALS['total_income'] - $GLOBALS['total_expense']); ?> VND</p>
    <?php endif; ?>
</body>
</html>