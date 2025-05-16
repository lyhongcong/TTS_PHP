<?php
namespace XYZBank\Accounts;

use IteratorAggregate;
use ArrayIterator;

class AccountCollection implements IteratorAggregate {
    private array $accounts = []; 

    public function addAccount(BankAccount $account): void {
        $this->accounts[] = $account; // Thêm tài khoản vào danh sách
    }

    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->accounts); // Trả về một ArrayIterator để duyệt qua các tài khoản
    }

    public function filterByBalance(float $minBalance): array {
        return array_filter($this->accounts, function (BankAccount $account) use ($minBalance) {
            return $account->getBalance() >= $minBalance; // Lọc tài khoản theo số dư tối thiểu
        });
    }
}