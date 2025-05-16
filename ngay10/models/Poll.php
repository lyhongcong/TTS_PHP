<?php
class Poll {
    public static function vote($option) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE poll SET votes = votes + 1 WHERE option_name=?");
        $stmt->execute([$option]);
    }
    public static function results() {
        global $pdo;
        return $pdo->query("SELECT * FROM poll")->fetchAll();
    }
}