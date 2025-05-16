<?php
namespace XYZBank\Accounts;

interface InterestBearing {
    public function calculateAnnualInterest(): float; // Tính lãi suất hàng năm
}