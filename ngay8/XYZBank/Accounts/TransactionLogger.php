<?php
namespace XYZBank\Accounts;

trait TransactionLogger {
    public function logTransaction(string $type, float $amount, float $newBalance): void {
        echo "[" . date('Y-m-d H:i:s') . "] Giao dịch: $type " . number_format($amount) . " VNĐ | Số dư mới: " . number_format($newBalance) . " VNĐ\n";
    }
}