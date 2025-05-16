<?php
require_once 'XYZBank/Accounts/BankAccount.php';
require_once 'XYZBank/Accounts/InterestBearing.php';
require_once 'XYZBank/Accounts/TransactionLogger.php';
require_once 'XYZBank/Accounts/SavingsAccount.php';
require_once 'XYZBank/Accounts/CheckingAccount.php';
require_once 'XYZBank/Accounts/AccountCollection.php';
require_once 'XYZBank/Bank.php';

use XYZBank\Accounts\SavingsAccount;
use XYZBank\Accounts\CheckingAccount;
use XYZBank\Accounts\AccountCollection;
use XYZBank\Bank;

// Tạo tài khoản tiết kiệm
$savings = new SavingsAccount("10201122", "Minh", 25000000);
Bank::incrementAccountCount();

// Tạo tài khoản thanh toán
$checking1 = new CheckingAccount("20301123", "Giang", 9000000); 
Bank::incrementAccountCount(); 

$checking2 = new CheckingAccount("20401124", "Hòa", 12000000);
Bank::incrementAccountCount(); 

// Gửi tiền và rút tiền
$checking1->deposit(5000000); // Gửi tiền vào tài khoản thanh toán
$checking2->withdraw(2000000); // Rút tiền từ tài khoản thanh toán

// Tính lãi suất
echo "Lãi suất hàng năm cho Minh: " . number_format($savings->calculateAnnualInterest()) . " VNĐ\n";

// Quản lý tài khoản
$accountCollection = new AccountCollection();
$accountCollection->addAccount($savings); // Thêm tài khoản tiết kiệm vào danh sách
$accountCollection->addAccount($checking1); // Thêm tài khoản thanh toán vào danh sách
$accountCollection->addAccount($checking2); // Thêm tài khoản thanh toán vào danh sách

// Duyệt qua tất cả tài khoản
foreach ($accountCollection as $account) {
    echo "Tài khoản: {$account->getAccountNumber()} | {$account->getOwnerName()} | Loại: {$account->getAccountType()} | Số dư: " . number_format($account->getBalance()) . " VNĐ\n";
}

// Tổng số tài khoản và tên ngân hàng
echo "Tổng số tài khoản đã tạo: " . Bank::$totalAccounts . "\n";
echo "Tên ngân hàng: " . Bank::getBankName() . "\n";