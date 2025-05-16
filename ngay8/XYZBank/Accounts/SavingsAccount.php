<?php
namespace XYZBank\Accounts;

class SavingsAccount extends BankAccount implements InterestBearing {
    use TransactionLogger;

    private const INTEREST_RATE = 0.05; // 5%/năm

    public function deposit(float $amount): void {
        $this->balance += $amount; // Gửi tiền vào tài khoản tiết kiệm
        $this->logTransaction("Gửi tiền", $amount, $this->balance); // Ghi lại giao dịch
    }

    public function withdraw(float $amount): void {
        if ($this->balance - $amount < 1000000) {
            throw new \Exception("Số dư không đủ để thực hiện giao dịch. Số dư tối thiểu phải là 1.000.000 VNĐ.");
        }
        $this->balance -= $amount; // Rút tiền từ tài khoản tiết kiệm
        $this->logTransaction("Rút tiền", $amount, $this->balance); // Ghi lại giao dịch
    }

    public function calculateAnnualInterest(): float {
        return $this->balance * self::INTEREST_RATE; // Tính lãi suất hàng năm
    }

    public function getAccountType(): string {
        return "Tiết kiệm";
    }
}