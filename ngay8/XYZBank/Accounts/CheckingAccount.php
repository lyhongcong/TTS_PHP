<?php
namespace XYZBank\Accounts;

class CheckingAccount extends BankAccount {
    use TransactionLogger;

    public function deposit(float $amount): void {
        $this->balance += $amount; // Gửi tiền vào tài khoản thanh toán
        $this->logTransaction("Gửi tiền", $amount, $this->balance); // Ghi lại giao dịch
    }

    public function withdraw(float $amount): void {
        $this->balance -= $amount; // Rút tiền từ tài khoản thanh toán
        $this->logTransaction("Rút tiền", $amount, $this->balance); // Ghi lại giao dịch
    }

    public function getAccountType(): string {
        return "Thanh toán";
    }
}