<?php
$pdo = new PDO('mysql:host=localhost;dbname=ngay10_php;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);