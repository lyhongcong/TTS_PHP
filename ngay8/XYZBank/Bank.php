<?php
namespace XYZBank;

class Bank {
    public static int $totalAccounts = 0; 

    public static function getBankName(): string {
        return "Ngân hàng XYZ";
    }

    public static function incrementAccountCount(): void {
        self::$totalAccounts++; 
    }
}