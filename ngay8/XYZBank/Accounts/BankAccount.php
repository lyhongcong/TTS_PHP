<?php
namespace XYZBank\Accounts;

abstract class BankAccount {
    protected string $accountNumber;
    protected string $ownerName;
    protected float $balance;

    public function __construct(string $accountNumber, string $ownerName, float $balance) {
        $this->accountNumber = $accountNumber; 
        $this->ownerName = $ownerName;
        $this->balance = $balance; 
    }

    public function getBalance(): float {
        return $this->balance; // Trả về số dư tài khoản
    }

    public function getOwnerName(): string {
        return $this->ownerName; // Trả về tên chủ tài khoản
    }

    public function getAccountNumber(): string {
        return $this->accountNumber; // Trả về số tài khoản
    }

    abstract public function deposit(float $amount): void; // Phương thức trừu tượng để gửi tiền
    abstract public function withdraw(float $amount): void; // Phương thức trừu tượng để rút tiền
    abstract public function getAccountType(): string; // Phương thức trừu tượng để lấy loại tài khoản
}